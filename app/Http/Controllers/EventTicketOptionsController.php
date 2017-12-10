<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\TicketOptions;
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
        return view('ManageEvent.Modals.CreateTicketOption', [
            'event' => Event::scope()->find($event_id),
            'ticket' => Ticket::scope()->find($ticket_id),
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
        $ticket = Ticket::findOrFail($ticket_id);

        $option = TicketOptions::createNew(false, false, true);

        if (!$option->validate($request->all())) {
            return response()->json([
                'status'   => 'error',
                'messages' => $option->errors(),
            ]);
        }

        $option->title = $request->get('title');
        $option->description = $request->get('description');
        $option->price = $request->get('price');
        if ($request->get('multiple')) {
            $option->multiple = $request->get('multiple');
        } else {
            $option->multiple = 0;
        }
        $option->is_enabled = true;

        $ticket->options()->save($option);

        session()->flash('message', 'Successfully Created Option');

        return response()->json([
            'status'      => 'success',
            'message'     => 'Refreshing..',
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
        $data = [
            'event'  => Event::scope()->find($event_id),
            'ticket' => Ticket::scope()->find($ticket_id),
            'option' => TicketOptions::scope()->find($option_id),
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
        $option = TicketOptions::scope()->findOrFail($option_id);

        if (!$option->validate($request->all())) {
            return response()->json([
                'status'   => 'error',
                'messages' => $option->errors(),
            ]);
        }

        $option->title = $request->get('title');
        $option->price = $request->get('price');
        Log::info($request->get('multiple'));
        if ($request->get('multiple')) {
            $option->multiple = $request->get('multiple');
        } else {
            $option->multiple = 0;
        }
        $option->description = $request->get('description');

        $option->save();

        return response()->json([
            'status'      => 'success',
            'id'          => $option->id,
            'message'     => 'Refreshing...',
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

            session()->flash('message', '__Option Successfully Deleted');

            return response()->json([
                'status'      => 'success',
                'message'     => 'Refreshing..',
                'redirectUrl' => '',
            ]);
        }

        return response()->json([
            'status'  => 'error',
            'id'      => $option->id,
            'message' => '__This option can\'t be deleted.',
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
                'message' => 'Option Successfully Updated',
                'id'      => $option->id,
            ]);
        }

        return response()->json([
            'status'  => 'error',
            'id'      => $option->id,
            'message' => 'Whoops! Looks like something went wrong. Please try again.',
        ]);
    }
}
