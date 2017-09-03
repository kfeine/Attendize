<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventDiscountCodeRequest;
use App\Models\Event;
use App\Models\DiscountCode;
use Illuminate\Http\Request;

class EventDiscountCodeController extends MyBaseController
{
    /**
     * Show the event discount codes page
     *
     * @param Request $request
     * @param $event_id
     * @return mixed
     */
    public function showEventDiscountCodes(Request $request, $event_id)
    {
        $event = Event::scope()->findOrFail($event_id);

        $data = [
            'event'           => $event,
            'discount_codes'  => $event->discount_codes(),
        ];

        return view('ManageEvent.DiscountCodes', $data);
    }

    /**
     * Show the form for creating a new discount code.
     *
     * @return \Illuminate\Http\Response
     */
    public function showCreateEventDiscountCode(Request $request, $event_id)
    {
        $event = Event::scope()->findOrFail($event_id);

        return view('ManageEvent.Modals.CreateDiscountCode', [
            'event'          => $event,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @access public
     * @param  StoreEventDiscountCodeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postCreateEventDiscountCode(StoreEventDiscountCodeRequest $request, $event_id)
    {
        // Get the event or display a 'not found' warning.
        $event = Event::findOrFail($event_id);

        // Create discount code.
        //$question = DiscountCode::createNew(false, false, true);
        $discount_code = DiscountCode::createNew();
        $discount_code->title = $request->get('title');
        $discount_code->code  = $request->get('code');
        $discount_code->save();

        $event->discount_codes()->attach($discount_code->id);

        session()->flash('message', 'Successfully Created Question');

        return response()->json([
            'status'      => 'success',
            'message'     => 'Refreshing..',
            'redirectUrl' => '',
        ]);
    }


    /**
     * Show the Edit Discount Code Modal
     *
     * @param Request $request
     * @param $event_id
     * @param $discount_code
     * @return mixed
     */
    // public function showEditEventDiscountCode(Request $request, $event_id, $discount_code_id)
    // {
    //     $discount_code = DiscountCode::scope()->findOrFail($discount_code_id);
    //     $event = Event::scope()->findOrFail($event_id);
    //
    //     $data = [
    //         'event'           => $event,
    //         'discount_codes'  => $discount_code,
    //     ];
    //
    //     return view('ManageEvent.Modals.EditDiscountCode', $data);
    // }
}
