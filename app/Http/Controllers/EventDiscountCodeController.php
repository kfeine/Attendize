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
        $discount_code->code  = $request->get('code');
        $discount_code->price = $request->get('price');
        $discount_code->is_enabled = true;
        $discount_code->event_id = $event_id;
        $discount_code->save();

        //$event->discount_codes()->attach($discount_code->id);

        session()->flash('message', 'Successfully created discount code');

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
    public function showEditEventDiscountCode(Request $request, $event_id, $discount_code_id)
    {
        $discount_code = DiscountCode::scope()->findOrFail($discount_code_id);
        $event = Event::scope()->findOrFail($event_id);

        $data = [
            'event'           => $event,
            'discount_code'  => $discount_code,
        ];

        return view('ManageEvent.Modals.EditDiscountCode', $data);
    }


    /**
     * Edit a discount_code
     *
     * @param Request $request
     * @param $event_id
     * @param $discount_code_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postEditEventDiscountCode(Request $request, $event_id, $discount_code_id)
    {
        // Get the event or display a 'not found' warning.
        $event = Event::scope()->findOrFail($event_id);

        // Create discount_code.
        $discount_code = DiscountCode::scope()->findOrFail($discount_code_id);
        $discount_code->title = $request->get('title');
        $discount_code->code = $request->get('code');
        $discount_code->price = $request->get('price');
        $discount_code->save();

        session()->flash('message', 'Successfully edited discount code');

        return response()->json([
            'status'      => 'success',
            'message'     => 'Refreshing..',
            'redirectUrl' => '',
        ]);

    }


    /**
     * Toggle the enabled status of discount_code
     *
     * @param Request $request
     * @param $event_id
     * @param $discount_code_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postEnableDiscountCode(Request $request, $event_id, $discount_code_id)
    {
        $discount_code = DiscountCode::scope()->find($discount_code_id);

        $discount_code->is_enabled = ($discount_code->is_enabled == 1) ? 0 : 1;

        if ($discount_code->save()) {
            return response()->json([
                'status'  => 'success',
                'message' => 'DiscountCode Successfully Updated',
                'id'      => $discount_code->id,
            ]);
        }

        return response()->json([
            'status'  => 'error',
            'id'      => $discount_code->id,
            'message' => 'Whoops! Looks like something went wrong. Please try again.',
        ]);
    }


    /**
     * Delete a discount_code
     *
     * @param Request $request
     * @param $event_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDeleteEventDiscountCode(Request $request, $event_id)
    {
        $discount_code_id = $request->get('discount_code_id');

        $discount_code = DiscountCode::scope()->find($discount_code_id);

        if ($discount_code->delete()) {

            session()->flash('message', 'Discount code successfully deleted');

            return response()->json([
                'status'      => 'success',
                'message'     => 'Refreshing..',
                'redirectUrl' => '',
            ]);
        }

        return response()->json([
            'status'  => 'error',
            'id'      => $discount_code->id,
            'message' => 'This discount code can\'t be deleted.',
        ]);
    }

}
