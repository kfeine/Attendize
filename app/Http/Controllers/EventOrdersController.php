<?php

namespace App\Http\Controllers;


use App\Jobs\SendOrderInvoice;
use App\Models\Attendee;
use App\Models\Event;
use App\Models\EventStats;
use App\Models\Order;
use DB;
use Excel;
use Illuminate\Http\Request;
use Log;
use Mail;
use Omnipay;
use Validator;

class EventOrdersController extends MyBaseController
{

    /**
     * Show event orders page
     *
     * @param Request $request
     * @param string $event_id
     * @return mixed
     */
    public function showOrders(Request $request, $event_id = '')
    {
        $allowed_sorts = ['first_name', 'email', 'order_reference', 'order_status_id', 'created_at', 'payment_gateway_id'];

        $searchQuery = $request->get('q');
        $sort_by     = (in_array($request->get('sort_by'), $allowed_sorts) ? $request->get('sort_by') : 'created_at');
        $sort_order  = $request->get('sort_order') == 'asc' ? 'asc' : 'desc';

        $event = Event::scope()->find($event_id);

        if ($searchQuery) {
            /*
             * Strip the hash from the start of the search term in case people search for
             * order references like '#EDGC67'
             */
            if ($searchQuery[0] === '#') {
                $searchQuery = str_replace('#', '', $searchQuery);
            }

            $orders = $event->orders()
                ->where(function ($query) use ($searchQuery) {
                    $query->where('order_reference', 'like', $searchQuery . '%')
                        ->orWhere('first_name', 'like', $searchQuery . '%')
                        ->orWhere('city', 'like', $searchQuery . '%')
                        ->orWhere('email', 'like', $searchQuery . '%')
                        ->orWhere('last_name', 'like', $searchQuery . '%');
                })
                ->orderBy($sort_by, $sort_order)
                ->paginate();
        } else {
            $orders = $event->orders()->orderBy($sort_by, $sort_order)->paginate();
        }

        $data = [
            'orders'     => $orders,
            'event'      => $event,
            'sort_by'    => $sort_by,
            'sort_order' => $sort_order,
            'q'          => $searchQuery ? $searchQuery : '',
        ];

        return view('ManageEvent.Orders', $data);
    }

    /**
     * Shows  'Manage Order' modal
     *
     * @param Request $request
     * @param $order_id
     * @return mixed
     */
    public function manageOrder(Request $request, $order_id)
    {
        $data = [
            'order' => Order::scope()->find($order_id),
        ];

        return view('ManageEvent.Modals.ManageOrder', $data);
    }

    /**
     * Shows 'Edit Order' modal
     *
     * @param Request $request
     * @param $order_id
     * @return mixed
     */
    public function showEditOrder(Request $request, $order_id)
    {
        $order = Order::scope()->find($order_id);

        $data = [
            'order'     => $order,
            'event'     => $order->event(),
            'attendees' => $order->attendees()->withoutCancelled()->get(),
            'modal_id'  => $request->get('modal_id'),
        ];

        return view('ManageEvent.Modals.EditOrder', $data);
    }

    /**
     * Shows 'Cancel Order' modal
     *
     * @param Request $request
     * @param $order_id
     * @return mixed
     */
    public function showCancelOrder(Request $request, $order_id)
    {
        $order = Order::scope()->find($order_id);

        $data = [
            'order'     => $order,
            'event'     => $order->event(),
            'attendees' => $order->attendees()->withoutCancelled()->get(),
            'modal_id'  => $request->get('modal_id'),
        ];

        return view('ManageEvent.Modals.CancelOrder', $data);
    }

    /**
     * Resend an entire order
     *
     * @param $order_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function resendOrder($order_id)
    {
        $order = Order::scope()->find($order_id);

        $this->dispatch(new SendOrderInvoice($order));

        return response()->json([
            'status'      => 'success',
            'redirectUrl' => '',
        ]);
    }

    /**
     * Edits an order
     *
     * @param Request $request
     * @param $order_id
     * @return mixed
     */
    public function postEditOrder(Request $request, $order_id)
    {
        $rules = [
            'first_name'  => ['required'],
            'last_name'   => ['required'],
            'email'       => ['required', 'email'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'   => 'error',
                'messages' => $validator->messages()->toArray(),
            ]);
        }

        $order              = Order::scope()->findOrFail($order_id);
        $order->first_name  = mb_convert_case(trim($request->get('first_name')), MB_CASE_TITLE, 'UTF-8');
        $order->last_name   = mb_convert_case(trim($request->get('last_name')), MB_CASE_UPPER, 'UTF-8');
        $order->email       = $request->get('email');
        $order->custom_field = $request->get('custom_field');
        $order->update();


        \Session::flash('message', __('controllers_eventorderscontroller.order_updated'));

        return response()->json([
            'status'      => 'success',
            'redirectUrl' => '',
        ]);
    }

    /**
     * Cancels an order
     *
     * @param Request $request
     * @param $order_id
     * @return mixed
     */
    public function postCancelOrder(Request $request, $order_id)
    {
        $rules = [
            'refund_amount' => ['numeric'],
        ];
        $messages = [
            'refund_amount.integer' => __('controllers_eventorderscontroller.only_numbers'),
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'status'   => 'error',
                'messages' => $validator->messages()->toArray(),
            ]);
        }

        $order = Order::scope()->findOrFail($order_id);

        $refund_order  = ($request->get('refund_order') === 'on') ? true : false;
        $is_free       = $order->amount == 0;
        $refund_type   = $request->get('refund_type');
        $refund_amount = round(floatval($request->get('refund_amount')), 2);
        $attendees     = $request->get('attendees');
        $error_message = false;

        if ($refund_order && $order->payment_gateway->can_refund && !$is_free) {
            if (!$order->transaction_id) {
                $error_message = __('controllers_eventorderscontroller.refund_error');
            }

            if ($order->is_refunded) {
                $error_message = __('controllers_eventorderscontroller.refund_already');
            } elseif ($order->organiser_amount == 0) {
                $error_message = __('controllers_eventorderscontroller.refund_nothing');
            } elseif ($refund_type !== 'full' && $refund_amount > round(($order->organiser_amount - $order->amount_refunded),
                    2)
            ) {
                $error_message =  __('controllers_eventorderscontroller.refund_max'). (money($order->organiser_amount - $order->amount_refunded,
                        $order->event->currency));
            }
            if (!$error_message) {
                try {
                    $gateway = Omnipay::create($order->payment_gateway->name);

                    $gateway->initialize($order->account->getGateway($order->payment_gateway->id)->config);

                    if ($refund_type === 'full') { /* Full refund */
                        $refund_amount = $order->organiser_amount - $order->amount_refunded;
                    }

                    $request = $gateway->refund([
                        'transactionReference' => $order->transaction_id,
                        'amount'               => $refund_amount,
                        'refundApplicationFee' => floatval($order->booking_fee) > 0 ? true : false,
                    ]);

                    $response = $request->send();

                    if ($response->isSuccessful()) {
                        /* Update the event sales volume*/
                        $order->event->decrement('sales_volume', $refund_amount);
                        $order->amount_refunded = round(($order->amount_refunded + $refund_amount), 2);

                        if (($order->organiser_amount - $order->amount_refunded) == 0) {
                            $order->is_refunded = 1;
                            $order->order_status_id = config('attendize.order_refunded');
                        } else {
                            $order->is_partially_refunded = 1;
                            $order->order_status_id = config('attendize.order_partially_refunded');
                        }
                    } else {
                        $error_message = $response->getMessage();
                    }

                    $order->save();
                } catch (\Exeption $e) {
                    Log::error($e);
                    $error_message = __('controllers_eventorderscontroller.problem');
                }
            }

            if ($error_message) {
                return response()->json([
                    'status'  => 'success',
                    'message' => $error_message,
                ]);
            }
        }

        /*
         * Cancel the attendees
         */
        if ($attendees) {
            foreach ($attendees as $attendee_id) {
                $attendee = Attendee::scope()->where('id', '=', $attendee_id)->first();
                $attendee->is_cancelled = 1;

                $attendee->ticket->decrement('quantity_sold');

                if(!$is_free){
                    $attendee->ticket->decrement('sales_volume', $attendee->ticket->price);
                    $order->event->decrement('sales_volume', $attendee->ticket->price); 
                    
                    $order->decrement('amount', $attendee->ticket->price);
                    foreach($attendee->options as $option){
                        $attendee->ticket->decrement('sales_volume', $option->price);
                        $order->event->decrement('sales_volume', $option->price); 
                        $order->decrement('amount', $option->price);
                    }
                }

                $eventStats = EventStats::where('event_id', $attendee->event_id)->where('date', $attendee->created_at->format('Y-m-d'))->first();
                if($eventStats){
                    $eventStats->decrement('tickets_sold',  1);

                    if(!$is_free){
                        $eventStats->decrement('sales_volume',  $attendee->ticket->price);
                    }
                }

                $attendee->save();
            }

            $all_attendees_canceled = 1;
            foreach($order->attendees as $attendee){
                if(!$attendee->is_cancelled){
                    $all_attendees_canceled = 0; 
                } 
            }

            if($all_attendees_canceled == 1){
                $order->order_status_id = config('attendize.order_cancelled');
                $order->save();
            }

        }

        \Session::flash('message',
            (!$refund_amount && !$attendees) ? __('controllers_eventorderscontroller.nothing_to_do') : __('controllers_eventorderscontroller.success') . ($refund_order ? __('controllers_eventorderscontroller.refunded_order') : ' ') . ($attendees && $refund_order ? ' & ' : '') . ($attendees ? __('controllers_eventorderscontroller.cancelled_attendee') : ''));

        return response()->json([
            'status'      => 'success',
            'redirectUrl' => '',
        ]);
    }

    /**
     * Exports order to popular file types
     *
     * @param $event_id
     * @param string $export_as Accepted: xls, xlsx, csv, pdf, html
     */
    public function showExportOrders($event_id, $export_as = 'xls')
    {
        $event = Event::scope()->findOrFail($event_id);

        Excel::create('orders-as-of-' . date('d-m-Y-g.i.a'), function ($excel) use ($event) {

            $excel->setTitle(__('controllers_eventorderscontroller.orders_for') . $event->title);

            // Chain the setters
            $excel->setCreator(config('attendize.app_name'))
                ->setCompany(config('attendize.app_name'));

            $excel->sheet('orders_sheet_1', function ($sheet) use ($event) {
                if (env('APP_LANG') === "fr") {
                    $data = Order::where('orders.event_id', '=', $event->id)
                        ->where('orders.event_id', '=', $event->id)
                        ->select([
                            'orders.first_name',
                            'orders.last_name',
                            'orders.email',
                            'orders.phone',
                            'orders.address1',
                            'orders.address2',
                            'orders.city',
                            'orders.postal_code',
                            'orders.order_reference',
                            \DB::raw("(CASE
                                        WHEN orders.payment_gateway_id IS NULL THEN '1'
                                        ELSE '0' END)
                                        AS `orders.payment_gateway_id`"),
                            'orders.transaction_id',
                            \DB::raw('replace(orders.amount, ".", ",")'),
                            \DB::raw("(CASE
                                        WHEN orders.order_status_id = 1 THEN 'Completed'
                                        WHEN orders.order_status_id = 2 THEN 'Fully refunded'
                                        WHEN orders.order_status_id = 3 THEN 'Partially refunded'
                                        WHEN orders.order_status_id = 4 THEN 'Cancelled'
                                        WHEN orders.order_status_id = 5 THEN 'Awaiting payment'
                                        ELSE 'Unknown' END)
                                        AS `orders.order_status_id`"),
                            'orders.transaction_id',
                            'orders.amount_refunded',
                            'orders.created_at',
                            'orders.custom_field',
                        ])->get();
                } else {
                    $data = Order::where('orders.event_id', '=', $event->id)
                        ->where('orders.event_id', '=', $event->id)
                        ->select([
                            'orders.first_name',
                            'orders.last_name',
                            'orders.email',
                            'orders.phone',
                            'orders.address1',
                            'orders.address2',
                            'orders.postal_code',
                            'orders.city',
                            'orders.order_reference',
                            \DB::raw("(CASE
                                        WHEN orders.payment_gateway_id IS NULL THEN '1'
                                        ELSE '0' END)
                                        AS `orders.payment_gateway_id`"),
                            'orders.transaction_id',
                            'orders.amount',
                            \DB::raw("(CASE
                                        WHEN orders.order_status_id = 1 THEN 'Completed'
                                        WHEN orders.order_status_id = 2 THEN 'Fully refunded'
                                        WHEN orders.order_status_id = 3 THEN 'Partially refunded'
                                        WHEN orders.order_status_id = 4 THEN 'Cancelled'
                                        WHEN orders.order_status_id = 5 THEN 'Awaiting payment'
                                        ELSE 'Unknown' END)
                                        AS `orders.order_status_id`"),
                            'orders.amount_refunded',
                            'orders.created_at',
                            'orders.custom_field',
                        ])->get();
                }

                $sheet->fromArray($data);

                // Add headings to first row
                $sheet->row(1, [
                    'First Name',
                    'Last Name',
                    'Email',
                    'Phone',
                    'Address line 1',
                    'Address line 2',
                    'Postal code',
                    'City',
                    'Order Reference',
                    'Chèque',
                    'ID Scellius',
                    'Amount',
                    'Status',
                    'Amount Refunded',
                    'Order Date',
                    'Custom Field'
                ]);

                // Set gray background on first row
                $sheet->row(1, function ($row) {
                    $row->setBackground('#f5f5f5');
                });
            });
        })->export($export_as);
    }

    /**
     * shows 'Message Order Creator' modal
     *
     * @param Request $request
     * @param $order_id
     * @return mixed
     */
    public function showMessageOrder(Request $request, $order_id)
    {
        $order = Order::scope()->findOrFail($order_id);

        $data = [
            'order' => $order,
            'event' => $order->event,
        ];

        return view('ManageEvent.Modals.MessageOrder', $data);
    }

    /**
     * Sends message to order creator
     *
     * @param Request $request
     * @param $order_id
     * @return mixed
     */
    public function postMessageOrder(Request $request, $order_id)
    {
        $rules = [
            'subject' => 'required|max:250',
            'message' => 'required|max:5000',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'   => 'error',
                'messages' => $validator->messages()->toArray(),
            ]);
        }

        $order = Attendee::scope()->findOrFail($order_id);

        $data = [
            'order'           => $order,
            'message_content' => $request->get('message'),
            'subject'         => $request->get('subject'),
            'event'           => $order->event,
            'email_logo'      => $order->event->organiser->full_logo_path,
        ];

        Mail::send('Emails.messageReceived', $data, function ($message) use ($order, $data) {
            $message->to($order->email, $order->full_name)
                ->from(config('attendize.outgoing_email_noreply'), $order->event->organiser->name)
                ->replyTo($order->event->organiser->email, $order->event->organiser->name)
                ->subject($data['subject']);
        });

        /* Send a copy to the Organiser with a different subject */
        if ($request->get('send_copy') == '1') {
            Mail::send('Emails.messageReceived', $data, function ($message) use ($order, $data) {
                $message->to($order->event->organiser->emails)
                    ->from(config('attendize.outgoing_email_noreply'), $order->event->organiser->name)
                    ->replyTo($order->event->organiser->email, $order->event->organiser->name)
                    ->subject($data['subject'] . ' [Organiser copy]');
            });
        }

        return response()->json([
            'status'  => 'success',
            'message' => __('controllers_eventorderscontroller.message_sent'),
        ]);
    }

    /**
     * Mark an order as payment received
     *
     * @param Request $request
     * @param $order_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postMarkPaymentReceived(Request $request, $order_id)
    {
        $order = Order::scope()->findOrFail($order_id);

        $order->is_payment_received = 1;
        $order->order_status_id = 1;

        $order->save();

        session()->flash('message', __('controllers_eventorderscontroller.payment_status_update_success'));

        return response()->json([
            'status' => 'success',
        ]);
    }

    /**
     * Mark an order as payment not received
     *
     * @param Request $request
     * @param $order_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postMarkPaymentNotReceived(Request $request, $order_id)
    {
        $order = Order::scope()->findOrFail($order_id);

        $order->is_payment_received = 0;
        $order->order_status_id     = config('attendize.order_awaiting_payment');

        $order->save();

        session()->flash('message', __('controllers_eventorderscontroller.order_payment_update_success'));

        return response()->json([
            'status' => 'success',
        ]);
    }
}
