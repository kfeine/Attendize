<?php

namespace App\Http\Controllers;

use App\Jobs\GenerateInvoice;
use App\Models\Attendee;
use App\Models\Event;
use App\Models\EventStats;
use App\Models\Message;
use App\Models\Question;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Ticket;
use App\Models\TicketOptions;
use App\Models\TicketOptionsDetails;
use Auth;
use Config;
use DB;
use Excel;
use Illuminate\Http\Request;
use Log;
use Mail;
use Omnipay\Omnipay;
use PDF;
use Validator;

class EventAttendeesController extends MyBaseController
{
    /**
     * Show the attendees list
     *
     * @param Request $request
     * @param $event_id
     * @return View
     */
    public function showAttendees(Request $request, $event_id)
    {
        $allowed_sorts = ['first_name', 'email', 'ticket_id', 'order_reference', 'reference_index'];

        $searchQuery = $request->get('q');
        $sort_order  = $request->get('sort_order') == 'asc' ? 'asc' : 'desc';
        $sort_by     = (in_array($request->get('sort_by'), $allowed_sorts) ? $request->get('sort_by') : 'created_at');

        $event = Event::scope()->find($event_id);

        if ($searchQuery) {
            $attendees = $event->attendees()
                ->withoutCancelled()
                ->join('orders', 'orders.id', '=', 'attendees.order_id')
                ->where(function ($query) use ($searchQuery) {
                    $query->where('orders.order_reference', 'like', $searchQuery . '%')
                        ->orWhere('attendees.first_name', 'like', $searchQuery . '%')
                        ->orWhere('attendees.reference_index', 'like', $searchQuery . '%')
                        ->orWhereRaw("CONCAT(`orders`.`order_reference`,'-',`attendees`.`reference_index`) LIKE ?", [$searchQuery.'%'])
                        ->orWhere('attendees.email', 'like', $searchQuery . '%')
                        ->orWhere('attendees.last_name', 'like', $searchQuery . '%');
                })
                ->orderBy(($sort_by == 'order_reference' ? 'orders.' : 'attendees.') . $sort_by, $sort_order)
                ->select('attendees.*', 'orders.order_reference')
                ->paginate();
        } else {
            $attendees = $event->attendees()
                ->join('orders', 'orders.id', '=', 'attendees.order_id')
                ->withoutCancelled()
                ->orderBy(($sort_by == 'order_reference' ? 'orders.' : 'attendees.') . $sort_by, $sort_order)
                ->select('attendees.*', 'orders.order_reference')
                ->paginate();
        }

        $data = [
            'attendees'  => $attendees,
            'event'      => $event,
            'sort_by'    => $sort_by,
            'sort_order' => $sort_order,
            'q'          => $searchQuery ? $searchQuery : '',
        ];

        return view('ManageEvent.Attendees', $data);
    }


    /**
     * Show the printable attendee list
     *
     * @param $event_id
     * @return View
     */
    public function showPrintAttendees($event_id)
    {
        $data['event'] = Event::scope()->find($event_id);
        $data['attendees'] = $data['event']->attendees()->withoutCancelled()->orderBy('first_name')->get();

        return view('ManageEvent.PrintAttendees', $data);
    }

    /**
     * Show the 'Message Attendee' modal
     *
     * @param Request $request
     * @param $attendee_id
     * @return View
     */
    public function showMessageAttendee(Request $request, $attendee_id)
    {
        $attendee = Attendee::scope()->findOrFail($attendee_id);

        $data = [
            'attendee' => $attendee,
            'event'    => $attendee->event,
        ];

        return view('ManageEvent.Modals.MessageAttendee', $data);
    }

    /**
     * Downloads an export of attendees
     *
     * @param $event_id
     * @param string $export_as (xlsx, xls, csv, html)
     */
    public function showExportAttendees($event_id, $export_as = 'xls')
    {
        $this->generateExportAttendees($event_id, $export_as);
        return response()->file(storage_path('exports/attendees.' . $export_as));
    }

    /**
     * Generate an export of attendees
     *
     * @param $event_id
     * @param string $export_as (xlsx, xls, csv, html)
     */
    public function generateExportAttendees($event_id, $export_as = 'xls')
    {
        $tickets = Ticket::where('event_id', '=', $event_id)->get();

        $details = TicketOptionsDetails::where('tickets.event_id', '=', $event_id)
          ->join('ticket_options', 'ticket_options_details.ticket_options_id', "=", 'ticket_options.id')
          ->join('tickets', 'ticket_options.ticket_id', "=", 'tickets.id')
          ->select([
            'ticket_options_details.id',
            'ticket_options_details.title',
            'ticket_options.title',
          ])
          ->get();

        // options avec 1 seul choix possible
        $options_one_choice_titles = [];
        $options_one_choice = TicketOptions::where('tickets.event_id', '=', $event_id)
          ->where("ticket_options_type_id","=", 1)
          ->join('tickets', 'ticket_options.ticket_id', "=", 'tickets.id')
          ->select(['ticket_options.title'])
          ->get();
        foreach($options_one_choice as $option) {
            if (!in_array($option["title"], $options_one_choice_titles)) {
                $options_one_choice_titles[] = $option["title"];
            }
        }

        // options avec choix multiples
        $options_multiple_choices_titles = [];
        $options_multiple_choices = TicketOptions::where('tickets.event_id', '=', $event_id)
          ->where("ticket_options_type_id","=", 3)
          ->join('tickets', 'ticket_options.ticket_id', "=", 'tickets.id')
          ->leftJoin('ticket_options_details', 'ticket_options.id', "=", 'ticket_options_details.ticket_options_id')
          ->select([
            'ticket_options.title as option_title',
            'ticket_options_details.title as option_detail_title',
          ])
          ->get();

        foreach($options_multiple_choices as $option) {
            $complete_title = $option["option_title"]." ".$option["option_detail_title"];
            if (!in_array($complete_title, $options_multiple_choices_titles)) {
                $options_multiple_choices_titles[] = $complete_title;
            }
        }

        $questions = Question::where('tickets.event_id', '=', $event_id)
          ->where("questions.deleted_at","=", null)
          ->join('question_ticket', 'questions.id', "=", 'question_ticket.question_id')
          ->join('tickets', 'question_ticket.ticket_id', "=", 'tickets.id')
          ->select([
            'questions.id',
            'questions.title',
          ])
          ->groupBy('questions.id')
          ->get();

        $select = [
              'attendees.id',
              'attendees.gender',
              'attendees.first_name',
              'attendees.last_name',
              'attendees.email',
              'attendees.phone',
              'attendees.address1',
              'attendees.address2',
              'attendees.postal_code',
              'attendees.city',
              'attendees.custom_field',
              'orders.order_reference',
              'orders.created_at',
              DB::raw("(CASE WHEN orders.is_payment_received THEN 'YES' ELSE 'NO' END) AS is_payment_received"),
              'tickets.title',
        ];

        $title_row = [
            __('controllers_eventattendeescontroller.xls_id'),
            __('controllers_eventattendeescontroller.xls_gender'),
            __('controllers_eventattendeescontroller.xls_first_name'),
            __('controllers_eventattendeescontroller.xls_last_name'),
            __('controllers_eventattendeescontroller.xls_email'),
            __('controllers_eventattendeescontroller.xls_phone'),
            __('controllers_eventattendeescontroller.xls_address_1'),
            __('controllers_eventattendeescontroller.xls_address_2'),
            __('controllers_eventattendeescontroller.xls_postal_code'),
            __('controllers_eventattendeescontroller.xls_city'),
            __('controllers_eventattendeescontroller.xls_custom_field'),
            __('controllers_eventattendeescontroller.xls_order_ref'),
            __('controllers_eventattendeescontroller.xls_purchase_date'),
            __('controllers_eventattendeescontroller.xls_payment_received'),
            __('controllers_eventattendeescontroller.xls_tickets_title'),
        ];

        foreach($options_one_choice_titles as $option_title){
          $select[] = DB::raw("MAX(CASE WHEN ticket_options.title='".$option_title."' THEN ticket_options_details.title END) AS ".str_replace(' ','_',str_replace(array('(',')','-'),'',$option_title)));
          $title_row[] = $option_title;
        }
        foreach($options_multiple_choices_titles as $option_title){
          $select[] = DB::raw("MAX(CASE WHEN CONCAT(ticket_options.title, ' ', ticket_options_details.title)='".$option_title."' THEN 'Y' END) AS ".str_replace(' ','_',str_replace(array('(',')','-'),'',$option_title)));
          $title_row[] = $option_title;
        }

        foreach($questions as $question){
          $select[] = DB::raw("MAX(CASE WHEN question_answers.question_id = ".$question->id." THEN question_answers.answer_text ELSE '' END) AS question_".$question->id);
          $title_row[] = $question->title;
        }

        Excel::create('attendees', function ($excel) use ($event_id, $select, $title_row, $tickets) {

            $excel->setTitle(__('controllers_eventattendeescontroller.attendee_list'));

            // Chain the setters
            $excel->setCreator(config('attendize.app_name'))
                ->setCompany(config('attendize.app_name'));

            $excel->sheet('attendees_sheet_1', function ($sheet) use ($event_id, $select, $title_row, $tickets) {

                $data = Attendee::where('attendees.event_id', '=', $event_id)
                    ->where('attendees.is_cancelled', '=', 0)
                    ->where('attendees.account_id', '=', Auth::user()->account_id)
                    ->join('events', 'events.id', '=', 'attendees.event_id')
                    ->join('orders', 'orders.id', '=', 'attendees.order_id')
                    ->join('tickets', 'tickets.id', '=', 'attendees.ticket_id')
                    ->leftJoin('question_answers', 'question_answers.attendee_id', '=', 'attendees.id')
                    ->leftJoin('attendee_ticket_options_details', 'attendee_ticket_options_details.attendee_id', '=', 'attendees.id')
                    ->leftJoin('ticket_options_details', 'attendee_ticket_options_details.ticket_options_details_id', '=', 'ticket_options_details.id')
                    ->leftJoin('ticket_options', 'ticket_options.id', '=', 'ticket_options_details.ticket_options_id')
                    ->select($select)
                    ->groupBy('attendees.id')
                    ->get();

                $sheet->fromArray($data);
                $sheet->row(1, $title_row);

                // Set gray background on first row
                $sheet->row(1, function ($row) {
                    $row->setBackground('#f5f5f5');
                });
            });

            $excel->sheet('summary', function ($sheet) use ($event_id, $tickets) {
                // add total for each ticket
                foreach($tickets as $ticket) {
                    $sheet->appendRow(array($ticket->title, $ticket->attendees->count()));
                    foreach($ticket->options as $ticket_option) {
                        foreach($ticket_option->options as $ticket_option_detail) {
                            $total = DB::table('attendee_ticket_options_details')
                                 ->select(DB::raw('*'))
                                 ->where('ticket_options_details_id', '=', $ticket_option_detail->id)
                                 ->get();
                            $sheet->appendRow(array(' - '.$ticket_option_detail->title, $total->count()));
                        }
                    }
                }
            });

        })->store($export_as);
    }

    /**
     * Download PDF generated from latex
     *
     * @return Illuminate\Http\Response
     */
    public function exportBadges($event_id) {
        $this->generateExportAttendees($event_id, 'csv');
        shell_exec('cd ' . storage_path('exports/') . ' && ' . preg_replace("#\r|\n#","",shell_exec('which pdflatex')) . ' -quiet ' . resource_path('badges/badges.tex'));
        return response()->file(storage_path('exports/badges.pdf'));
    }

    /**
     * Show the 'Edit Attendee' modal
     *
     * @param Request $request
     * @param $event_id
     * @param $attendee_id
     * @return View
     */
    public function showEditAttendee(Request $request, $event_id, $attendee_id)
    {
        $attendee = Attendee::scope()->findOrFail($attendee_id);

        $data = [
            'attendee' => $attendee,
            'event'    => $attendee->event,
            'tickets'  => $attendee->event->tickets->pluck('title', 'id'),
        ];

        return view('ManageEvent.Modals.EditAttendee', $data);
    }

    /**
     * Updates an attendee
     *
     * @param Request $request
     * @param $event_id
     * @param $attendee_id
     * @return mixed
     */
    public function postEditAttendee(Request $request, $event_id, $attendee_id)
    {
        $rules = [
            'first_name' => 'required',
            'ticket_id'  => 'required|exists:tickets,id,account_id,' . Auth::user()->account_id,
            'email'      => 'required|email',
            'last_name' => 'required',
            'phone' => 'required',
            'address1' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
        ];

        $messages = [
            'ticket_id.exists'   => __('controllers_eventattendeescontroller.ticket_id_exists'),
            'ticket_id.required' => __('controllers_eventattendeescontroller.ticket_id_required')
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'status'   => 'error',
                'messages' => $validator->messages()->toArray(),
            ]);
        }

        $attendee               = Attendee::scope()->findOrFail($attendee_id);
        $attendee->first_name   = mb_convert_case(trim(strip_tags($request->get('first_name'))), MB_CASE_TITLE, 'UTF-8');
        $attendee->last_name    = mb_convert_case(trim(strip_tags($request->get('last_name'))), MB_CASE_UPPER, 'UTF-8');
        $attendee->email        = $request->get('email');
        $attendee->phone        = $request->get('phone');
        $attendee->address1     = $request->get('address1');
        $attendee->address2     = $request->get('address2');
        $attendee->city         = $request->get('city');
        $attendee->postal_code  = $request->get('postal_code');
        $attendee->ticket_id    = $request->get('ticket_id');
        $attendee->gender     = $request->get('gender');
        $attendee->custom_field = $request->get('custom_field');
        $attendee->update();

        session()->flash('message', __('controllers_eventattendeescontroller.update_success'));

        return response()->json([
            'status'      => 'success',
            'id'          => $attendee->id,
            'redirectUrl' => '',
        ]);
    }

    /**
     * Shows the 'Cancel Attendee' modal
     *
     * @param Request $request
     * @param $event_id
     * @param $attendee_id
     * @return View
     */
    public function showCancelAttendee(Request $request, $event_id, $attendee_id)
    {
        $attendee = Attendee::scope()->findOrFail($attendee_id);

        $data = [
            'attendee' => $attendee,
            'event'    => $attendee->event,
            'tickets'  => $attendee->event->tickets->pluck('title', 'id'),
        ];

        return view('ManageEvent.Modals.CancelAttendee', $data);
    }

    /**
     * Cancels an attendee
     *
     * @param Request $request
     * @param $event_id
     * @param $attendee_id
     * @return mixed
     */
    public function postCancelAttendee(Request $request, $event_id, $attendee_id)
    {
        $attendee = Attendee::scope()->findOrFail($attendee_id);
        $error_message = false; //Prevent "variable doesn't exist" error message

        if ($attendee->is_cancelled) {
            return response()->json([
                'status'  => 'success',
                'message' => __('controllers_eventattendeescontroller.already_cancelled'),
            ]);
        }

        $attendee->ticket->decrement('quantity_sold');

        if($attendee->order->amount != 0){
            $attendee->ticket->decrement('sales_volume', $attendee->ticket->price);
            $attendee->ticket->event->decrement('sales_volume', $attendee->ticket->price);
        }

        $attendee->is_cancelled = 1;
        $attendee->save();

        $eventStats = EventStats::where('event_id', $attendee->event_id)->where('date', $attendee->created_at->format('Y-m-d'))->first();
        if($eventStats){
            $eventStats->decrement('tickets_sold',  1);
            if($attendee->order->amount != 0){
                $eventStats->decrement('sales_volume',  $attendee->ticket->price);
            }
        }

        $data = [
            'attendee'   => $attendee,
            'email_logo' => $attendee->event->organiser->full_logo_path,
        ];

        if ($request->get('notify_attendee') == '1') {
            Mail::send('Emails.notifyCancelledAttendee', $data, function ($message) use ($attendee) {
                $message->to($attendee->email, $attendee->full_name)
                    ->from(config('attendize.outgoing_email_noreply'), $attendee->event->organiser->name)
                    ->replyTo($attendee->event->organiser->email, $attendee->event->organiser->name)
                    ->subject('Your ticket has been cancelled');
            });
        }

        if ($request->get('refund_attendee') == '1') {

            try {
                // This does not account for an increased/decreased ticket price
                // after the original purchase.
                $refund_amount = $attendee->ticket->price;
                $data['refund_amount'] = $refund_amount;

                $gateway = Omnipay::create($attendee->order->payment_gateway->name);

                // Only works for stripe
                $gateway->initialize($attendee->order->account->getGateway($attendee->order->payment_gateway->id)->config);

                $request = $gateway->refund([
                    'transactionReference' => $attendee->order->transaction_id,
                    'amount'               => $refund_amount,
                    'refundApplicationFee' => false,
                ]);

                $response = $request->send();

                if ($response->isSuccessful()) {

                    // Update the attendee and their order
                    $attendee->is_refunded                   = 1;
                    $attendee->order->is_partially_refunded  = 1;
                    $attendee->order->amount_refunded       += $refund_amount;

                    $attendee->order->save();
                    $attendee->save();

                    // Let the user know that they have received a refund.
                    Mail::send('Emails.notifyRefundedAttendee', $data, function ($message) use ($attendee) {
                        $message->to($attendee->email, $attendee->full_name)
                            ->from(config('attendize.outgoing_email_noreply'), $attendee->event->organiser->name)
                            ->replyTo($attendee->event->organiser->email, $attendee->event->organiser->name)
                            ->subject('You have received a refund from ' . $attendee->event->organiser->name);
                    });
                } else {
                    $error_message = $response->getMessage();
                }

            } catch (\Exception $e) {
                \Log::error($e);
                $error_message = __('controllers_eventattendeescontroller.problem_refund');

            }
        }

        if ($error_message) {
            return response()->json([
                'status'  => 'error',
                'message' => $error_message,
            ]);
        }

        session()->flash('message', __('controllers_eventattendeescontroller.cancel_success'));

        return response()->json([
            'status'      => 'success',
            'id'          => $attendee->id,
            'redirectUrl' => '',
        ]);
    }

    /**
     * Show the 'Message Attendee' modal
     *
     * @param Request $request
     * @param $attendee_id
     * @return View
     */
    public function showResendTicketToAttendee(Request $request, $attendee_id)
    {
        $attendee = Attendee::scope()->findOrFail($attendee_id);

        $data = [
            'attendee' => $attendee,
            'event'    => $attendee->event,
        ];

        return view('ManageEvent.Modals.ResendTicketToAttendee', $data);
    }

    /**
     * Send a message to an attendee
     *
     * @param Request $request
     * @param $attendee_id
     * @return mixed
     */
    public function postResendTicketToAttendee(Request $request, $attendee_id)
    {
        $attendee = Attendee::scope()->findOrFail($attendee_id);

        $this->dispatch(new SendAttendeeConfirmation($attendee));

        return response()->json([
            'status'  => 'success',
            'message' => __('controllers_eventattendeescontroller.ticket_resent'),
        ]);
    }
}
