<?php

namespace App\Http\Controllers;

use App\Events\OrderCompletedEvent;
use App\Models\Affiliate;
use App\Models\Attendee;
use App\Models\Event;
use App\Models\EventStats;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemOption;
use App\Models\QuestionAnswer;
use App\Models\ReservedTickets;
use App\Models\ReservedOptionsGeneric;
use App\Models\Ticket;
use App\Models\TicketOptions;
use App\Models\TicketOptionsDetails;
use App\Models\Discount;
use Carbon\Carbon;
use Cookie;
use DB;
use Illuminate\Http\Request;
use Log;
use Omnipay;
use PDF;
use PhpSpec\Exception\Exception;
use Validator;

class EventCheckoutController extends Controller
{
    /**
     * Is the checkout in an embedded Iframe?
     *
     * @var bool
     */
    protected $is_embedded;

    /**
     * EventCheckoutController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        /*
         * See if the checkout is being called from an embedded iframe.
         */
        $this->is_embedded = $request->get('is_embedded') == '1';
    }

    /**
     * Validate a ticket request. If successful reserve the tickets and redirect to checkout
     *
     * @param Request $request
     * @param $event_id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function postValidateTickets(Request $request, $event_id)
    {
        /*
         * Order expires after X min
         */
        $order_expires_time = Carbon::now()->addMinutes(config('attendize.checkout_timeout_after'));

        $event = Event::findOrFail($event_id);

        if (!$request->has('attendees')) {
            return response()->json([
                'status'  => 'error',
                'message' => "__pas de participants choisis",
                //'message' => __('controllers_eventcheckoutcontroller.no_tickets_selected'),
            ]);
        }

        $attendees_ids = $request->get('attendees');

        /*
         * Remove any tickets and options the user has reserved
         */
        ReservedTickets::where('session_id', '=', session()->getId())->delete();
        ReservedOptionsGeneric::where('session_id', '=', session()->getId())->delete();

        /*
         * Go though the selected tickets and check if they're available
         * , tot up the price and reserve them to prevent over selling.
         */

        $validation_rules                    = [];
        $validation_messages                 = [];
        $tickets                             = [];
        $order_total                         = 0;
        $total_ticket_quantity               = 0;
        $booking_fee                         = 0;
        $organiser_booking_fee               = 0;
        $quantity_available_validation_rules = [];

        //$tickets_quantity_verification = [];

        foreach ($attendees_ids as $attendee_id) {
            //on récupère le ticket choisi pour l'utilisateur
            $ticket_id = (int)$request->get('attendee_' . $attendee_id . '_ticket');

            if (!$ticket_id) {
                continue;
            }

            // Debut de la vérification du nombre de ticket pris par rapport au nombre de ticket disponible...
            //if(array_key_exists($ticket_id, $tickets_quantity_verification)){
            //    $tickets_quantity_verification[$ticket_id] = $tickets_quantity_verification[$ticket_id] + 1;
            //} else {
            //    $tickets_quantity_verification[$ticket_id] = 1;
            //}
            //$current_ticket_quantity = $tickets_quantity_verification[$ticket_id];
            $current_ticket_quantity = 1;

            $total_ticket_quantity = $total_ticket_quantity + 1;

            $ticket = Ticket::find($ticket_id);

            $ticket_quantity_remaining = $ticket->quantity_remaining;

            $max_per_person = min($ticket_quantity_remaining, $ticket->max_per_person);

            if($total_ticket_quantity < $ticket->min_per_person){
                return response()->json([
                    'status'   => 'error',
                    'message' => '__ le nombre de ticket "'.$ticket->title.'" exigé par personne n\'est pas respecté',
                ]);
            } else if($total_ticket_quantity > $max_per_person){
                return response()->json([
                    'status'   => 'error',
                    'message' => '__ le nombre de ticket "'.$ticket->title.'" reservé dépasse la quantité disponible',
                ]);
            }

            //fin vérification quantitié ticket disponible.

            $order_total           = $order_total +  $ticket->price;
            $booking_fee           = $booking_fee +  $ticket->booking_fee;
            $organiser_booking_fee = $organiser_booking_fee +  $ticket->organiser_booking_fee;

            //validation options
            $details = [];
            foreach($ticket->options_enabled as $option){
                $detail_ids = $request->get('attendee_' .$attendee_id. '_ticket_'.$ticket_id.'_options_'.$option->id);
                if(!is_array($detail_ids)){
                    $detail_ids = [$detail_ids];   
                }
                foreach($detail_ids as $detail_id){
                    $detail = TicketOptionsDetails::find($detail_id);
                    if(!$detail){
                      continue;
                    }

                    if($detail->ticket_options_id != $option->id){
                        continue; 
                    }

                    if(!$detail->isRemaining()){
                        return response()->json([
                            'status'   => 'error',
                            'message' => 'l\'option : "'.$detail->title.'" n\'est plus disponible',
                        ]);
                    }

                    $details[] = $detail;
                    $order_total = $order_total + $detail->price;
                }
            }

            $attendee['first_name'] = $request->get('attendee_' .$attendee_id. '_first_name');
            $attendee['gender'] = $request->get('attendee_' .$attendee_id. '_gender');
            $attendee['last_name'] = $request->get('attendee_' .$attendee_id. '_last_name');
            $attendee['email'] = $request->get('attendee_' .$attendee_id. '_email');

            $tickets[] = [
                'ticket'                => $ticket,
                'qty'                   => $current_ticket_quantity,
                'price'                 => $ticket->price,
                'booking_fee'           => $ticket->booking_fee,
                'organiser_booking_fee' => $ticket->organiser_booking_fee,
                'full_price'            => $ticket->price + $ticket->total_booking_fee,
                'options'               => $details,
                'attendee'              => $attendee,
                'attendee_id'           => $attendee_id,
            ];

            /*
             * Reserve the tickets for X amount of minutes
             */
            $reservedTickets                    = new ReservedTickets();
            $reservedTickets->ticket_id         = $ticket_id;
            $reservedTickets->event_id          = $event_id;
            $reservedTickets->quantity_reserved = $current_ticket_quantity;
            $reservedTickets->expires           = $order_expires_time;
            $reservedTickets->session_id        = session()->getId();
            $reservedTickets->save();

            /*
             * Reserve options for X amount of minutes
             */
            foreach($details as $detail){
                if($detail->ticket_options_details_generic){
                    $reservedOptionsGeneric                    = new ReservedOptionsGeneric();
                    $reservedOptionsGeneric->ticket_options_details_generic_id = $detail->ticket_options_details_generic->id;
                    $reservedOptionsGeneric->quantity_reserved = 1;
                    $reservedOptionsGeneric->expires           = $order_expires_time;
                    $reservedOptionsGeneric->session_id        = session()->getId();
                    $reservedOptionsGeneric->save();
                }
            }

            /*
             * Create our validation rules here
             */
            $validation_rules['ticket_holder_first_name.' . $attendee_id . '.' . $ticket_id] = ['required'];
            $validation_rules['ticket_holder_last_name.' . $attendee_id . '.' . $ticket_id] = ['required'];
            $validation_rules['ticket_holder_gender.' . $attendee_id . '.' . $ticket_id] = ['required'];
            $validation_rules['ticket_holder_email.' . $attendee_id . '.' . $ticket_id] = ['email'];
            $validation_rules['ticket_holder_phone.' . $attendee_id . '.' . $ticket_id] = ['required'];
            $validation_rules['ticket_holder_address_line_1.' . $attendee_id . '.' . $ticket_id] = ['required'];
            $validation_rules['ticket_holder_city.' . $attendee_id . '.' . $ticket_id] = ['required'];
            $validation_rules['ticket_holder_postal_code.' . $attendee_id . '.' . $ticket_id] = ['required'];
            $validation_rules['privacy_policy_consent'] = ['required'];

            $validation_messages['ticket_holder_first_name.' . $attendee_id . '.' . $ticket_id . '.required'] = __('controllers_eventcheckoutcontroller.first_name', ['person' => ($attendee_id + 1)]);
            $validation_messages['ticket_holder_last_name.' . $attendee_id . '.' . $ticket_id . '.required'] = __('controllers_eventcheckoutcontroller.first_name', ['person' => ($attendee_id + 1)]);
            $validation_messages['ticket_holder_gender.' . $attendee_id . '.' . $ticket_id . '.required'] = __('controllers_eventcheckoutcontroller.gender', ['person' => ($attendee_id + 1)]);
            //$validation_messages['ticket_holder_email.' . $attendee_id . '.' . $ticket_id . '.required'] = __('controllers_eventcheckoutcontroller.email_required', ['person' => ($attendee_id + 1)]);
            $validation_messages['ticket_holder_email.' . $attendee_id . '.' . $ticket_id . '.email'] = __('controllers_eventcheckoutcontroller.email_invalid', ['person' => ($attendee_id + 1)]);
            $validation_messages['ticket_holder_phone.' . $attendee_id . '.' . $ticket_id . '.required'] = __('controllers_eventcheckoutcontroller.phone_required', ['person' => ($attendee_id + 1)]);
            $validation_messages['ticket_holder_address_line_1.' . $attendee_id . '.' . $ticket_id . '.required'] = __('controllers_eventcheckoutcontroller.address_line_1_required', ['person' => ($attendee_id + 1)]);
            $validation_messages['ticket_holder_city.' . $attendee_id . '.' . $ticket_id . '.required'] = __('controllers_eventcheckoutcontroller.city_required', ['person' => ($attendee_id + 1)]);
            $validation_messages['ticket_holder_postal_code.' . $attendee_id . '.' . $ticket_id . '.required'] = __('controllers_eventcheckoutcontroller.postal_code_required', ['person' => ($attendee_id + 1)]);
            $validation_messages['privacy_policy_consent'] = __('controllers_eventcheckoutcontroller.privacy_policy_required');

            /*
             * Validation rules for custom questions
             */
            foreach ($ticket->questions as $question) {

                if ($question->is_required && $question->is_enabled) {
                    $validation_rules['ticket_holder_questions.' . $ticket_id . '.' . $attendee_id . '.' . $question->id] = ['required'];
                    $validation_messages['ticket_holder_questions.' . $ticket_id . '.' . $attendee_id . '.' . $question->id . '.required'] = __('controllers_eventcheckoutcontroller.question_required');
                }
            }

        }

        if (empty($tickets)) {
            return response()->json([
                'status'  => 'error',
                'message' => __('controllers_eventcheckoutcontroller.no_tickets_selected'),
            ]);
        }

        /*
         * Check if discount
         * If so, update total
         */
        $discount_code = $request->get('discount-code');
        $discount = False;
        if (!empty($discount_code)) {
            $discount = Discount::where('code', $discount_code)->first();
        }
        if ($discount && $discount->quantity_remaining > 0 && $discount->is_enabled) {
            if ($discount->type == 'amount') {
                $order_total = $order_total + $discount->price;
            } else if ($discount->type == 'percentage') {
                $order_total = $order_total - abs($discount->price) * $order_total / 100;
            } else {
                $discount = False;
            }
        } else {
            $discount = False;
        }
        // check if the total is positive…
        if ($order_total < 0) {
            $order_total = 0.0;
        }

        /*
         * The 'ticket_order_{event_id}' session stores everything we need to complete the transaction.
         */
        session()->put('ticket_order_' . $event->id, [
            'validation_rules'        => $validation_rules,
            'validation_messages'     => $validation_messages,
            'event_id'                => $event->id,
            'tickets'                 => $tickets,
            'total_ticket_quantity'   => $total_ticket_quantity,
            'discount'                => $discount,
            'order_started'           => time(),
            'expires'                 => $order_expires_time,
            'reserved_tickets_id'     => $reservedTickets->id,
            'order_total'             => $order_total,
            'booking_fee'             => $booking_fee,
            'organiser_booking_fee'   => $organiser_booking_fee,
            'total_booking_fee'       => $booking_fee + $organiser_booking_fee,
            'order_requires_payment'  => (ceil($order_total) == 0) ? false : true,
            'account_id'              => $event->account->id,
            'affiliate_referral'      => Cookie::get('affiliate_' . $event_id),
            'account_payment_gateway' => $event->account->active_payment_gateway ? $event->account->active_payment_gateway : false,
            'payment_gateway'         => $event->account->active_payment_gateway ? $event->account->active_payment_gateway->payment_gateway : false,
        ]);

        /*
         * If we're this far assume everything is OK and redirect them
         * to the the checkout page.
         */
        if ($request->ajax()) {
            return response()->json([
                'status'      => 'success',
                'redirectUrl' => route('showEventCheckout', [
                    'event_id'    => $event_id,
                    'is_embedded' => $this->is_embedded,
                ]) . '#order_form',
            ]);
        }

        /*
         * Maybe display something prettier than this?
         */
        exit(__('controllers_eventcheckoutcontroller.enable_javascript'));
    }

    /**
     * Show the checkout page
     *
     * @param Request $request
     * @param $event_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function showEventCheckout(Request $request, $event_id)
    {
        $order_session = session()->get('ticket_order_' . $event_id);

        if (!$order_session || $order_session['expires'] < Carbon::now()) {
            $route_name = $this->is_embedded ? 'showEmbeddedEventPage' : 'showEventPage';
            return redirect()->route($route_name, ['event_id' => $event_id]);
        }

        $secondsToExpire = Carbon::now()->diffInSeconds($order_session['expires']);

        $data = $order_session + [
            'event'           => Event::findorFail($order_session['event_id']),
            'secondsToExpire' => $secondsToExpire,
            'is_embedded'     => $this->is_embedded,
        ];

        if ($this->is_embedded) {
            return view('Public.ViewEvent.Embedded.EventPageCheckout', $data);
        }

        return view('Public.ViewEvent.EventPageCheckout', $data);
    }

    /**
     * Create the order, handle payment, update stats, fire off email jobs then redirect user
     *
     * @param Request $request
     * @param $event_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postCreateOrder(Request $request, $event_id)
    {

        /*
         * If there's no session kill the request and redirect back to the event homepage.
         */
        if (!session()->get('ticket_order_' . $event_id)) {
            return response()->json([
                'status'      => 'error',
                'message'     => __('controllers_eventcheckoutcontroller.session_expired'),
                'redirectUrl' => route('showEventPage', [
                    'event_id' => $event_id,
                ])
            ]);
        }

        $event = Event::findOrFail($event_id);
        $order = new Order;
        $ticket_order = session()->get('ticket_order_' . $event_id);

        $validation_rules = $ticket_order['validation_rules'];
        $validation_messages = $ticket_order['validation_messages'];

        $order->rules = $order->rules + $validation_rules;
        $order->messages = $order->messages() + $validation_messages;

        if (!$order->validate($request->all())) {
            return response()->json([
                'status'   => 'error',
                'messages' => $order->errors(),
            ]);
        }

        /*
         * Add the request data to a session in case payment is required off-site
         */
        session()->push('ticket_order_' . $event_id . '.request_data', $request->except(['card-number', 'card-cvc']));

        /*
         * Begin payment attempt before creating the attendees etc.
         * */
        if ($ticket_order['order_requires_payment']) {

            /*
             * Check if the user has chosen to pay offline
             * and if they are allowed
             */
            if ($request->get('pay_offline') && $event->enable_offline_payments) {
                return $this->completeOrder($event_id);
            }

            try {

                $gateway = Omnipay::create($ticket_order['payment_gateway']->name);

                $gateway->initialize($ticket_order['account_payment_gateway']->config + [
                        'testMode' => config('attendize.enable_test_payments'),
                    ]);

                $transaction_data = [
                        'amount'      => ($ticket_order['order_total'] + $ticket_order['organiser_booking_fee']),
                        'currency'    => $event->currency->code,
                        'description' => 'Order for customer: ' . $request->get('order_email'),
                    ];


                switch ($ticket_order['payment_gateway']->id) {
                    case config('attendize.payment_gateway_paypal'):
                    case config('attendize.payment_gateway_coinbase'):
                        $transaction_data += [
                            'cancelUrl' => route('showEventCheckoutPaymentReturn', [
                                'event_id'             => $event_id,
                                'is_payment_cancelled' => 1
                            ]),
                            'returnUrl' => route('showEventCheckoutPaymentReturn', [
                                'event_id'              => $event_id,
                                'is_payment_successful' => 1
                            ]),
                            'brandName' => isset($ticket_order['account_payment_gateway']->config['brandingName'])
                                ? $ticket_order['account_payment_gateway']->config['brandingName']
                                : $event->organiser->name
                        ];
                        break;
                    case config('attendize.payment_gateway_stripe'):
                        $token = $request->get('stripeToken');
                        $transaction_data += [
                            'token'         => $token,
                            'receipt_email' => $request->get('order_email'),
                        ];
                        break;
                    case config('attendize.payment_gateway_migs'):
                        $transaction_data += [
                            'transactionId' => $event_id . date('YmdHis'),       // TODO: Where to generate transaction id?
                            'returnUrl' => route('showEventCheckoutPaymentReturn', [
                                'event_id'              => $event_id,
                                'is_payment_successful' => 1
                            ]),

                        ];

                        // Order description in MIGS is only 34 characters long; so we need a short description
                        $transaction_data['description'] = "Ticket sales " . $transaction_data['transactionId'];

                        break;
                    case config('attendize.payment_gateway_scellius'):
                        $transactionId = mt_rand(100000, 999999); //transaction ID 6 chiffre numérique obligatoire

                        $firstname = $request->input('order_first_name', 'test3');
                        $lastname = $request->input('order_last_name', 'test2');
                        $suffix_reference = substr($lastname,0,3).substr($firstname,0,3);

                        $transactionReference = strtoupper(substr(uniqid($suffix_reference),0,15)); //transaction reference (order id) 15 maxi dans attendize
                        $transaction_data += [
                            'transactionId' => $transactionId,
                            'transactionReference' => $transactionReference,
                            'customerEmail' => $request->input('order_email', 'test1'),
                            'customerName' => $request->input('order_last_name', 'test2'),
                            'customerFirstname' => $request->input('order_first_name', 'test3'),
                            'cancelUrl' => route('showEventCheckoutPaymentScelliusReturn', [
                                'event_id'             => $event_id,
                                'is_payment_cancelled' => 1
                            ]),
                            'returnUrl' => route('showEventCheckoutPaymentScelliusReturn', [
                                'event_id'             => $event_id,
                                'transactionId'       => $transactionId,
                            ]),
                            'automaticReturnUrl' => route('showEventCheckoutPaymentScelliusReturn', [
                                'event_id'              => $event_id,
                                'is_payment_successful' => 1,
                                'session'               => session()->getId()
                            ]),
                        ];
                        break;
                    default:
                        Log::error('No payment gateway configured.');
                        return repsonse()->json([
                            'status'  => 'error',
                            'message' => __('controllers_eventcheckoutcontroller.no_gateway_configured')
                        ]);
                        break;
                }


                $transaction = $gateway->purchase($transaction_data);

                $response = $transaction->send();

                if ($response->isSuccessful()) {

                    session()->push('ticket_order_' . $event_id . '.transaction_id',
                        $response->getTransactionReference());

                    return $this->completeOrder($event_id);

                } elseif ($response->isRedirect()) {
                    if($ticket_order['payment_gateway']->id == config('attendize.payment_gateway_scellius')) {
                        $responseScellius = $response->getRedirectContentScellius();
                        if($responseScellius['success']){
                            session()->push('ticket_order_' . $event_id . '.transaction_data', $transaction_data);
                            Log::info("Redirect url: " . $response->getRedirectUrl());
                            $return = [
                                'status'       => 'success',
                                'completePurchase'  => true,
                                'completePurchase'  => $responseScellius['message'],
                            ];
                        } else {
                            $return = [
                                'status'       => 'error',
                                'completePurchase'  => true,
                                'message'  => $responseScellius['message'],
                            ];
                        }
                    } else {

                      /*
                       * As we're going off-site for payment we need to store some data in a session so it's available
                       * when we return
                       */
                      session()->push('ticket_order_' . $event_id . '.transaction_data', $transaction_data);
                      Log::info("Redirect url: " . $response->getRedirectUrl());

                        $return = [
                            'status'       => 'success',
                            'redirectUrl'  => $response->getRedirectUrl(),
                            'message'      => 'Redirecting to ' . $ticket_order['payment_gateway']->provider_name
                        ];
                        // GET method requests should not have redirectData on the JSON return string
                        if($response->getRedirectMethod() == 'POST') {
                            $return['redirectData'] = $response->getRedirectData();
                        }
                    }

                    return response()->json($return);

                } else {
                    // display error to customer
                    return response()->json([
                        'status'  => 'error',
                        'message' => $response->getMessage(),
                    ]);
                }
            } catch (\Exeption $e) {
                Log::error($e);
                $error = __('controllers_eventcheckoutcontroller.try_again');
            }

            if ($error) {
                return response()->json([
                    'status'  => 'error',
                    'message' => $error,
                ]);
            }
        }


        /*
         * No payment required so go ahead and complete the order
         */
        return $this->completeOrder($event_id);

    }


    /**
     * Attempt to complete a user's payment when they return from
     * an off-site gateway
     *
     * @param Request $request
     * @param $event_id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function showEventCheckoutPaymentReturn(Request $request, $event_id)
    {
        if ($request->get('is_payment_cancelled') == '1') {
            session()->flash('message', __('controllers_eventcheckoutcontroller.payment_cancelled'));
            return response()->redirectToRoute('showEventCheckout', [
                'event_id'             => $event_id,
                'is_payment_cancelled' => 1,
            ]);
        }

        //If automatic return Url
        if ($request->get('session')){
          session()->setId($request->get('session'));
          session()->start();
        }

        $ticket_order = session()->get('ticket_order_' . $event_id);

        //Si le ticket à déjà été validé par la banque
        if(!isset($ticket_order)){
          if($request->get('transactionId')){
                $order = Order::where('transaction_id', $request->get('transactionId'))->first();
                return response()->redirectToRoute('showOrderDetails', [
                    'is_embedded'     => $this->is_embedded,
                    'order_reference' => $order->order_reference,
                ]);
          
          } else {
            session()->flash('message', "désolé, une erreur est survenue");
            return response()->redirectToRoute('showEventCheckout', [
                'event_id'          => $event_id,
                'is_payment_failed' => 1,
            ]);
          }
        
        }

                                //'transactionId'       => $transactionId,
        $gateway = Omnipay::create($ticket_order['payment_gateway']->name);

        $gateway->initialize($ticket_order['account_payment_gateway']->config + [
                'testMode' => config('attendize.enable_test_payments'),
            ]);

        $transaction = $gateway->completePurchase($ticket_order['transaction_data'][0]);

        $response = $transaction->send();

        if ($response->isSuccessful()) {
            session()->push('ticket_order_' . $event_id . '.transaction_id', $response->getTransactionId());
            session()->push('ticket_order_' . $event_id . '.order_reference', $response->getOrderId());
            return $this->completeOrder($event_id, false);
        } else {
            session()->flash('message', $response->getMessage());
            return response()->redirectToRoute('showEventCheckout', [
                'event_id'          => $event_id,
                'is_payment_failed' => 1,
            ]);
        }

    }

    /**
     * Complete an order
     *
     * @param $event_id
     * @param bool|true $return_json
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function completeOrder($event_id, $return_json = true)
    {

        DB::beginTransaction();

        try {

            $order              = new Order();
            $ticket_order       = session()->get('ticket_order_' . $event_id);
            $transaction_id     = session()->get('ticket_order_' . $event_id. '.transaction_id');
            $order_reference    = session()->get('ticket_order_' . $event_id. '.order_reference');
            $request_data       = $ticket_order['request_data'][0];
            $event              = Event::findOrFail($ticket_order['event_id']);
            $attendee_increment = 1;
            $ticket_questions   = isset($request_data['ticket_holder_questions']) ? $request_data['ticket_holder_questions'] : [];

            /*
             * Create the order
             */
            if (isset($ticket_order['transaction_id'])) {
                $order->transaction_id = $ticket_order['transaction_id'][0];
            } else if (isset($transaction_id)){
                $order->transaction_id = $transaction_id[0];
            }
            if (isset($order_reference)){
              $order->order_reference = $order_reference[0];
            }
            if ($ticket_order['order_requires_payment'] && !isset($request_data['pay_offline'])) {
                $order->payment_gateway_id = $ticket_order['payment_gateway']->id;
            }
            $order->first_name            = mb_convert_case(trim(strip_tags($request_data['order_first_name'])), MB_CASE_TITLE, 'UTF-8');
            $order->last_name             = mb_convert_case(trim(strip_tags($request_data['order_last_name'])), MB_CASE_UPPER, 'UTF-8');
            $order->email                 = $request_data['order_email'];
            $order->phone                 = $request_data['order_phone'];
            $order->address1              = $request_data['order_address_line_1'];
            $order->address2              = $request_data['order_address_line_2'];
            $order->city                  = mb_convert_case(trim($request_data['order_city']), MB_CASE_UPPER, 'UTF-8');
            $order->postal_code           = $request_data['order_postal_code'];
            $order->order_status_id       = isset($request_data['pay_offline']) ? config('attendize.order_awaiting_payment') : config('attendize.order_complete');
            $order->amount                = $ticket_order['order_total'];
            $order->booking_fee           = $ticket_order['booking_fee'];
            $order->organiser_booking_fee = $ticket_order['organiser_booking_fee'];
            $order->account_id            = $event->account->id;
            $order->event_id              = $ticket_order['event_id'];
            $order->is_payment_received   = isset($request_data['pay_offline']) ? 0 : 1;
            if (isset($ticket_order['discount']) && is_object($ticket_order['discount'])) {
                $order->discount_id = $ticket_order['discount']->id;
            }
            $order->save();

            /*
             * Update the event sales volume
             */
            $event->increment('sales_volume', $order->amount);
            $event->increment('organiser_fees_volume', $order->organiser_booking_fee);

            /*
             * Update affiliates stats stats
             */
            if ($ticket_order['affiliate_referral']) {
                $affiliate = Affiliate::where('name', '=', $ticket_order['affiliate_referral'])
                    ->where('event_id', '=', $event_id)->first();
                $affiliate->increment('sales_volume', $order->amount + $order->organiser_booking_fee);
                $affiliate->increment('tickets_sold', $ticket_order['total_ticket_quantity']);
            }

            /*
             * Update the event stats
             */
            $event_stats = EventStats::firstOrNew([
                'event_id' => $event_id,
                'date'     => DB::raw('CURRENT_DATE'),
            ]);
            $event_stats->increment('tickets_sold', $ticket_order['total_ticket_quantity']);

            if ($ticket_order['order_requires_payment']) {
                $event_stats->increment('sales_volume', $order->amount);
                $event_stats->increment('organiser_fees_volume', $order->organiser_booking_fee);
            }

            /*
             * Add the attendees
             */
            foreach ($ticket_order['tickets'] as $attendee_details) {

                /*
                 * Update ticket's quantity sold
                 */
                $ticket = Ticket::findOrFail($attendee_details['ticket']['id']);

                /*
                 * Update some ticket info
                 */
                $ticket->increment('quantity_sold', $attendee_details['qty']);
                $ticket->increment('sales_volume', ($attendee_details['ticket']['price'] * $attendee_details['qty']));
                $ticket->increment('organiser_fees_volume',
                    ($attendee_details['ticket']['organiser_booking_fee'] * $attendee_details['qty']));


                /*
                 * Insert order items (for use in generating invoices)
                 */
                $orderItem                   = new OrderItem();
                $orderItem->title            = $attendee_details['ticket']['title'];
                $orderItem->quantity         = $attendee_details['qty'];
                $orderItem->order_id         = $order->id;
                $orderItem->unit_price       = $attendee_details['ticket']['price'];
                $orderItem->unit_booking_fee = $attendee_details['ticket']['booking_fee'] + $attendee_details['ticket']['organiser_booking_fee'];
                $orderItem->save();

                $attendee                  = new Attendee();
                $attendee->gender          = $request_data["ticket_holder_gender"][$attendee_details['attendee_id']][$attendee_details['ticket']['id']];
                $attendee->first_name      = mb_convert_case(trim(strip_tags($request_data["ticket_holder_first_name"][$attendee_details['attendee_id']][$attendee_details['ticket']['id']])), MB_CASE_TITLE, 'UTF-8');
                $attendee->last_name       = mb_convert_case(trim(strip_tags($request_data["ticket_holder_last_name"][$attendee_details['attendee_id']][$attendee_details['ticket']['id']])), MB_CASE_UPPER, 'UTF-8');
                $attendee->email           = $request_data["ticket_holder_email"][$attendee_details['attendee_id']][$attendee_details['ticket']['id']];
                $attendee->phone           = $request_data['ticket_holder_phone'][$attendee_details['attendee_id']][$attendee_details['ticket']['id']];
                $attendee->address1        = $request_data['ticket_holder_address_line_1'][$attendee_details['attendee_id']][$attendee_details['ticket']['id']];
                $attendee->address2        = $request_data['ticket_holder_address_line_2'][$attendee_details['attendee_id']][$attendee_details['ticket']['id']];
                $attendee->city            = mb_convert_case(trim($request_data["ticket_holder_city"][$attendee_details['attendee_id']][$attendee_details['ticket']['id']]), MB_CASE_UPPER, 'UTF-8');
                $attendee->postal_code     = $request_data['ticket_holder_postal_code'][$attendee_details['attendee_id']][$attendee_details['ticket']['id']];
                $attendee->event_id        = $event_id;
                $attendee->order_id        = $order->id;
                $attendee->ticket_id       = $attendee_details['ticket']['id'];
                $attendee->account_id      = $event->account->id;
                $attendee->reference_index = $attendee_increment;
                $attendee->save();

                foreach ($attendee_details['options'] as $option) {
                    $attendee->options()->attach($option['id']);

                    $details = TicketOptionsDetails::findOrFail($option['id']);
                    if($details->ticket_options_details_generic){
                        $details->ticket_options_details_generic->increment('quantity_sold');
                    }



                    $orderItemOption = new OrderItemOption();
                    $orderItemOption->title = $option['title'];
                    $orderItemOption->order_item_id = $orderItem->id;
                    $orderItemOption->price = $option['price'];
                    $orderItemOption->save();

                    $ticket->increment('sales_volume', $option['price']);
                }


                /*
                 * Save the attendee's questions
                 */
                foreach ($attendee_details['ticket']->questions as $question) {


                    $ticket_answer = isset($ticket_questions[$attendee_details['ticket']->id][$attendee_details['attendee_id']][$question->id]) ? $ticket_questions[$attendee_details['ticket']->id][$attendee_details['attendee_id']][$question->id] : null;

                    if (is_null($ticket_answer)) {
                        continue;
                    }

                    /*
                     * If there are multiple answers to a question then join them with a comma
                     * and treat them as a single answer.
                     */
                    $ticket_answer = is_array($ticket_answer) ? implode(', ', $ticket_answer) : $ticket_answer;

                    if (!empty($ticket_answer)) {
                        QuestionAnswer::create([
                            'answer_text' => $ticket_answer,
                            'attendee_id' => $attendee->id,
                            'event_id'    => $event->id,
                            'account_id'  => $event->account->id,
                            'question_id' => $question->id
                        ]);

                    }
                }

                /* Keep track of total number of attendees */
                $attendee_increment++;
            }

            /*
             * Remove any tickets and options the user has reserved
             */
            ReservedTickets::where('session_id', '=', session()->getId())->delete();
            ReservedOptionsGeneric::where('session_id', '=', session()->getId())->delete();

            /*
             * Kill the session
             */
            session()->forget('ticket_order_' . $event->id);
            session()->forget('ticket_order_' . $event->id. '.transaction_id');
            session()->forget('ticket_order_' . $event->id. '.order_reference');
            

            /*
             * Queue up some tasks - Emails to be sent, PDFs etc.
             */
            Log::info('Firing the event');
            event(new OrderCompletedEvent($order));


        } catch (Exception $e) {

            Log::error($e);
            DB::rollBack();

            return response()->json([
                'status'  => 'error',
                'message' => __('controllers_eventcheckoutcontroller.problem_processing_order')
            ]);

        }

        DB::commit();

        if ($return_json) {
            return response()->json([
                'status'      => 'success',
                'redirectUrl' => route('showOrderDetails', [
                    'is_embedded'     => $this->is_embedded,
                    'order_reference' => $order->order_reference,
                ]),
            ]);
        }

        return response()->redirectToRoute('showOrderDetails', [
            'is_embedded'     => $this->is_embedded,
            'order_reference' => $order->order_reference,
        ]);


    }

    /**
     * Show the order details page
     *
     * @param Request $request
     * @param $order_reference
     * @return \Illuminate\View\View
     */
    public function showOrderDetails(Request $request, $order_reference)
    {
        $order = Order::where('order_reference', '=', $order_reference)->first();

        if (!$order) {
            abort(404);
        }

        $data = [
            'order'       => $order,
            'event'       => $order->event,
            'tickets'     => $order->event->tickets,
            'is_embedded' => $this->is_embedded,
        ];

        if ($this->is_embedded) {
            return view('Public.ViewEvent.Embedded.EventPageViewOrder', $data);
        }

        return view('Public.ViewEvent.EventPageViewOrder', $data);
    }

    /**
     * Shows the tickets for an order - either HTML or PDF
     *
     * @param Request $request
     * @param $order_reference
     * @return \Illuminate\View\View
     */
    public function showOrderTickets(Request $request, $order_reference)
    {
        $order = Order::where('order_reference', '=', $order_reference)->first();

        if (!$order) {
            abort(404);
        }

        $data = [
            'order'     => $order,
            'event'     => $order->event,
            'tickets'   => $order->event->tickets,
            'attendees' => $order->attendees,
            'css'       => file_get_contents(public_path('assets/stylesheet/ticket.css')),
            'image'     => base64_encode(file_get_contents(public_path($order->event->organiser->full_logo_path))),

        ];

        if ($request->get('download') == '1') {
            return PDF::html('Public.ViewEvent.Partials.PDFTicket', $data, 'Tickets');
        }
        return view('Public.ViewEvent.Partials.PDFTicket', $data);
    }

}
