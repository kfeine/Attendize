<?php

namespace App\Http\Controllers;

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
