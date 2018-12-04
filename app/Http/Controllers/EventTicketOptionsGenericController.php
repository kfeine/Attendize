<?php

namespace App\Http\Controllers;

use App\Models\TicketOptionsDetailsGeneric;
use App\Models\Event;
use Illuminate\Http\Request;
use Log;

class EventTicketOptionsGenericController extends MyBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $event_id)
    {
        // Find event or return 404 error.
        $event = Event::scope()->find($event_id);
        if ($event === null) {
            abort(404);
        }

        // Get options generic for event.
        $options = TicketOptionsDetailsGeneric::where('event_id', $event_id)->paginate();

        // Return view.
        return view('ManageEvent.OptionsGeneric', compact('options', 'event'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($event_id)
    {
        return view('ManageEvent.Modals.CreateOptionsGeneric', [
            'event' => Event::scope()->find($event_id),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param $event_id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $event_id)
    {
        $event = Event::findOrFail($event_id);

        $option = new TicketOptionsDetailsGeneric;
        $option->event_id = $event->id;

        $option->title = $request->get('title');
        $option->quantity_available = !$request->get('quantity_available') ? null : $request->get('quantity_available');

        $option->save();

        session()->flash('message', __('controllers_eventticketoptionsgenericcontroller.create_success'));

        return response()->json([
            'status'      => 'success',
            'message'     => __('controllers_eventticketoptionsgenericcontroller.refreshing'),
            'redirectUrl' => '',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TicketOptionsDetailsGeneric  $ticketOptionsDetailsGeneric
     * @return \Illuminate\Http\Response
     */
    public function edit($event_id, TicketOptionsDetailsGeneric $ticketOptionsDetailsGeneric)
    {
        $event = Event::scope()->findOrFail($event_id);

        $data = [
            'event'  => $event,
            'option' => $ticketOptionsDetailsGeneric,
        ];

        return view('ManageEvent.Modals.EditOptionsGeneric', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TicketOptionsDetailsGeneric  $ticketOptionsDetailsGeneric
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $event_id, TicketOptionsDetailsGeneric $ticketOptionsDetailsGeneric)
    {
        $option = $ticketOptionsDetailsGeneric;

        /*
         * Override some validation rules
         */
        $validation_rules['quantity_available'] = [
            'integer',
            'min:' . ($option->quantity_sold + $option->quantity_reserved)
        ];
        $validation_messages['quantity_available.min'] = __('controllers_eventticketoptionsgenericcontroller.quantity_min');

        $option->rules = $validation_rules + $option->rules;
        $option->validation_messages = $validation_messages + $option->messages();

        if (!$option->validate($request->all())) {
            return response()->json([
                'status'   => 'error',
                'messages' => $option->errors(),
            ]);
        }

        $option->title = $request->get('title');
        $option->quantity_available = !$request->get('quantity_available') ? null : $request->get('quantity_available');

        $option->save();

        return response()->json([
            'status'      => 'success',
            'id'          => $option->id,
            'message'     => __('controllers_eventticketoptionsgenericcontroller.refreshing'),
            'redirectUrl' => route('options_generic.index', [
                'event_id' => $event_id,
            ]),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TicketOptionsDetailsGeneric  $ticketOptionsDetailsGeneric
     * @return \Illuminate\Http\Response
     */
    public function destroy($event_id, TicketOptionsDetailsGeneric $ticketOptionsDetailsGeneric)
    {
        $option = $ticketOptionsDetailsGeneric;
        /*
         * Don't allow deletion of tickets which have been sold already.
         */
        if ($option->quantity_sold > 0) {
            return response()->json([
                'status'  => 'error',
                'message' => __('controllers_eventticketoptionsgenericcontroller.delete_sold'),
                'id'      => $option->id,
                'redirectUrl' => route('options_generic.index', [
                  'event_id' => $event_id,
                ]),
            ]);
        }

        if ($option->delete()) {
            return response()->json([
                'status'  => 'success',
                'message' => __('controllers_eventticketoptionsgenericcontroller.delete_success'),
                'id'      => $option->id,
                'redirectUrl' => route('options_generic.index', [
                    'event_id' => $event_id,
                ]),
            ]);
        }

        Log::error('Option Generic Failed to delete', [
            'option' => $option,
        ]);

        return response()->json([
            'status'  => 'error',
            'id'      => $option->id,
            'message' => __('controllers_eventticketoptionsgenericcontroller.error'),
        ]);
    }
}
