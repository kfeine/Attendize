<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreEventDiscountCodeRequest;
use App\Models\Event;
use App\Models\DiscountCode;
use Illuminate\Http\Request;

use App\Models\Attendee;
use Excel;
use JavaScript;

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

            //: $event->tickets()->orderBy($sort_by, 'asc')->paginate();
        $data = [
            'event'           => $event,
            'discount_codes'  => $event->discount_codes(),
        ];
        //$discount_codes = $event->discount_codes()->get();
        $discount_codes = $event->discount_codes()->orderBy('title', 'asc')->paginate();

        //return view('ManageEvent.DiscountCodes', $data);
        return view('ManageEvent.DiscountCodes', compact('event', 'discount_codes'));
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
        // createNew($account_id = false, $user_id = false, $ignore_user_id = false)
        $discount_code = DiscountCode::createNew(false, false, true);
        $discount_code->title = $request->get('title');
        $discount_code->code  = 'hello';
        $discount_code->price = -12.3;
        $discount_code->is_enabled = true;
        $discount_code->event_id = $event_id;
        $discount_code->save();

        //$event->discount_codes()->attach($discount_code->id);

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
