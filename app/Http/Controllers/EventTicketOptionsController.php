<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\TicketOptions;
use App\Models\TicketOptionsDetails;
use App\Models\TicketOptionsType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Log;

/*
  Attendize.com   - Event Management & Ticketing
 */

class EventTicketOptionsController extends MyBaseController
{

    /**
     * Show the create ticket option modal
     *
     * @param $event_id
     * @param $ticket_id
     * @return \Illuminate\Contracts\View\View
     */
    public function showCreateTicketOption($event_id, $ticket_id)
    {
        $event = Event::scope()->findOrFail($event_id);
        $ticket = Ticket::scope()->findOrFail($ticket_id);

        return view('ManageEvent.Modals.CreateTicketOption', [
            'event' => $event,
            'ticket' => $ticket,
            'ticket_options_types' => TicketOptionsType::all(),
        ]);
    }

    /**
     * Creates an option
     *
     * @param Request $request
     * @param $event_id
     * @param $ticket_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postCreateTicketOption(Request $request, $event_id, $ticket_id)
    {
        // Get the event or display a 'not found' warning.
        $event = Event::findOrFail($event_id);
        $ticket = Ticket::findOrFail($ticket_id);
        $ticket_options_type = TicketOptionsType::findOrFail($request->get('ticket_options_type_id'));

        if (!$request->has('details')) {
            return response()->json([
                'status'  => 'error',
                'message' => __('controllers_eventticketoptionscontroller.no_options_selected'),
            ]);
        }

        $optionBlock = TicketOptions::createNew(false, false, true);

        if (!$optionBlock->validate($request->all())) {
            return response()->json([
                'status'   => 'error',
                'messages' => $optionBlock->errors(),
            ]);
        }

        $optionBlock->title = $request->get('title');
        $optionBlock->description = $request->get('description');
        $optionBlock->is_required = ($request->get('is_required') == 'yes');
        $optionBlock->ticket_options_type_id = $ticket_options_type->id;
        $ticket->options()->save($optionBlock);


        // Get details
        $optionDetails_ids = $request->get('details');

        foreach ($optionDetails_ids as $optionDetails_id) {
            $optionDetails = new TicketOptionsDetails();

            $optionDetails->title = $request->get('details_'. $optionDetails_id .'_title');;
            $optionDetails->price = $request->get('details_'. $optionDetails_id .'_price');
            $optionDetails->is_forced = ($request->get('details_'. $optionDetails_id .'_is_forced') == 'yes');
            $optionDetails->default_value = ($request->get('details_'. $optionDetails_id .'_default_value') == 'yes');

            $optionBlock->options()->save($optionDetails);
        }


        session()->flash('message', __('controllers_eventticketoptionscontroller.create_success'));

        return response()->json([
            'status'      => 'success',
            'message'     => __('controllers_eventticketoptionscontroller.refreshing'),
            'redirectUrl' => '',
        ]);
    }

    /**
     * Show the edit ticket option modal
     *
     * @param $event_id
     * @param $ticket_id
     * @param $option_id
     * @return mixed
     */
    public function showEditOption($event_id, $ticket_id, $option_id)
    {
        $event = Event::scope()->findOrFail($event_id);
        $ticket = Ticket::scope()->findOrFail($ticket_id);
        $option = TicketOptions::scope()->findOrFail($option_id);
        $details = $option->options;
        $optionType = TicketOptionsType::all();

        $data = [
            'event'  => $event,
            'ticket' => $ticket,
            'option' => $option,
            'details' => $details,
            'ticket_options_types' => $optionType,
        ];

        return view('ManageEvent.Modals.EditTicketOptions', $data);
    }

    /**
     * Edit a ticket
     *
     * @param Request $request
     * @param $event_id
     * @param $ticket_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postEditOption(Request $request, $event_id, $ticket_id, $option_id)
    {
        $event = Event::findOrFail($event_id);
        $ticket = Ticket::findOrFail($ticket_id);
        $optionBlock = TicketOptions::findOrFail($option_id);
        $ticket_options_type = TicketOptionsType::findOrFail($request->get('ticket_options_type_id'));


        if (!$request->has('details')) {
            return response()->json([
                'status'  => 'error',
                'message' => __('controllers_eventticketoptionscontroller.no_options_selected'),
            ]);
        }

        if (!$optionBlock->validate($request->all())) {
            return response()->json([
                'status'   => 'error',
                'messages' => $optionBlock->errors(),
            ]);
        }

        $optionBlock->title = $request->get('title');
        $optionBlock->description = $request->get('description');
        $optionBlock->is_required = ($request->get('is_required') == 'yes');
        $optionBlock->ticket_options_type_id = $ticket_options_type->id;
        $optionBlock->save();


        //detail ids du formulare
        $optionDetails_ids = $request->get('details');

        foreach($optionBlock->options as $detail){
            if(!in_array($detail->id, $optionDetails_ids))  {
              //si ce n'est pas dans la liste, supprimer de la base
              $detail->delete();
            }
        }

        foreach ($optionDetails_ids as $optionDetails_id) {
            $optionDetails = TicketOptionsDetails::find($optionDetails_id);

            if(!$optionDetails){
                $optionDetails = new TicketOptionsDetails();
            }

            $optionDetails->title = $request->get('details_'. $optionDetails_id .'_title');
            $optionDetails->price = $request->get('details_'. $optionDetails_id .'_price');
            $optionDetails->is_forced = ($request->get('details_'. $optionDetails_id .'_is_forced') == 'yes');
            $optionDetails->default_value = ($request->get('details_'. $optionDetails_id .'_default_value') == 'yes');
            $optionDetails->ticket_options_id = $optionBlock->id;

            $optionDetails->save();
        }

        return response()->json([
            'status'      => 'success',
            'id'          => $optionBlock->id,
            'message'     => __('controllers_eventticketoptionscontroller.refreshing'),
            'redirectUrl' => ""
        ]);
    }

    /**
     * Delete an option
     *
     * @param Request $request
     * @param $event_id
     * @param $ticket_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDeleteTicketOption(Request $request, $event_id, $ticket_id)
    {
        $option_id = $request->get('option_id');
        $option = TicketOptions::scope()->find($option_id);

        if ($option->delete()) {

            session()->flash('message', __('controllers_eventticketoptionscontroller.option_deleted'));

            return response()->json([
                'status'      => 'success',
                'message'     => __('controllers_eventticketoptionscontroller.refreshing'),
                'redirectUrl' => '',
            ]);
        }

        return response()->json([
            'status'  => 'error',
            'id'      => $option->id,
            'message' => __('controllers_eventticketoptionscontroller.cant_be_deleted'),
        ]);
    }

    /**
     * Toggle the enabled status of option
     *
     * @param Request $request
     * @param $event_id
     * @param $ticket_id
     * @param $option_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postEnableOption(Request $request, $event_id, $ticket_id, $option_id)
    {
        $option = TicketOptions::scope()->find($option_id);

        $option->is_enabled = ($option->is_enabled == 1) ? 0 : 1;

        if ($option->save()) {
            return response()->json([
                'status'  => 'success',
                'message' => __('controllers_eventticketoptionscontroller.update_success'),
                'id'      => $option->id,
            ]);
        }

        return response()->json([
            'status'  => 'error',
            'id'      => $option->id,
            'message' => __('controllers_eventticketoptionscontroller.error'),
        ]);
    }

    /**
     * Toggle the enabled status of option detail
     *
     * @param Request $request
     * @param $event_id
     * @param $ticket_id
     * @param $option_id
     * @param $option_detail_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postEnableTicketOptionDetail(Request $request, $event_id, $ticket_id, $option_id, $option_detail_id)
    {
        $option_detail = TicketOptionsDetails::find($option_detail_id);

        $option_detail->is_enabled = ($option_detail->is_enabled == 1) ? 0 : 1;

        if ($option_detail->save()) {
            return response()->json([
                'status'  => 'success',
                'message' => __('controllers_eventticketoptionscontroller.update_success'),
                'id'      => $option_detail->id,
            ]);
        }

        return response()->json([
            'status'  => 'error',
            'id'      => $option_detail->id,
            'message' => __('controllers_eventticketoptionscontroller.error'),
        ]);
    }
}
