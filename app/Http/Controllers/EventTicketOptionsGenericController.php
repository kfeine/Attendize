<?php

namespace App\Http\Controllers;

use App\Models\TicketOptionsDetailsGeneric;
use App\Models\Event;
use Illuminate\Http\Request;

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
            'message'     => __('controllers_eventticketoptionscontroller.refreshing'),
            'redirectUrl' => '',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TicketOptionsDetailsGeneric  $ticketOptionsDetailsGeneric
     * @return \Illuminate\Http\Response
     */
    public function show(TicketOptionsDetailsGeneric $ticketOptionsDetailsGeneric)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TicketOptionsDetailsGeneric  $ticketOptionsDetailsGeneric
     * @return \Illuminate\Http\Response
     */
    public function edit(TicketOptionsDetailsGeneric $ticketOptionsDetailsGeneric)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TicketOptionsDetailsGeneric  $ticketOptionsDetailsGeneric
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TicketOptionsDetailsGeneric $ticketOptionsDetailsGeneric)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TicketOptionsDetailsGeneric  $ticketOptionsDetailsGeneric
     * @return \Illuminate\Http\Response
     */
    public function destroy(TicketOptionsDetailsGeneric $ticketOptionsDetailsGeneric)
    {
        //
    }
}
