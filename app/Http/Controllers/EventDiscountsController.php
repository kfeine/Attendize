<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreEventDiscountRequest;
use App\Models\Event;
use App\Models\Discount;
use Illuminate\Http\Request;

use App\Models\Attendee;
use Excel;
use JavaScript;

class EventDiscountsController extends MyBaseController
{
    /**
     * Show the event discount page
     *
     * @param Request $request
     * @param $event_id
     * @return mixed
     */
    public function showEventDiscounts(Request $request, $event_id)
    {
        $event = Event::scope()->findOrFail($event_id);

        $data = [
            'event'      => $event,
            'discounts'  => $event->discounts(),
        ];
        $discounts = $event->discounts()->orderBy('title', 'asc')->paginate();

        //return view('ManageEvent.Discounts', $data);
        return view('ManageEvent.Discounts', compact('event', 'discounts'));
    }

    /**
     * Show the form for creating a new discount.
     *
     * @return \Illuminate\Http\Response
     */
    public function showCreateEventDiscount(Request $request, $event_id)
    {
        $event = Event::scope()->findOrFail($event_id);

        return view('ManageEvent.Modals.CreateDiscount', [
            'event'          => $event,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @access public
     * @param  StoreEventDiscountRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postCreateEventDiscount(StoreEventDiscountRequest $request, $event_id)
    {
        // Get the event or display a 'not found' warning.
        $event = Event::findOrFail($event_id);

        // Create discount.
        // createNew($account_id = false, $user_id = false, $ignore_user_id = false)
        $discount = Discount::createNew(false, false, true);
        $discount->title = $request->get('title');
        $discount->code  = $request->get('code');
        $discount->price = $request->get('price');
        $discount->is_enabled = true;
        $discount->event_id = $event_id;
        $discount->save();

        //$event->discounts()->attach($discount->id);

        session()->flash('message', 'Successfully created discount');

        return response()->json([
            'status'      => 'success',
            'message'     => 'Refreshing..',
            'redirectUrl' => '',
        ]);
    }


    /**
     * Show the Edit Discount Modal
     *
     * @param Request $request
     * @param $event_id
     * @param $discount
     * @return mixed
     */
    public function showEditEventDiscount(Request $request, $event_id, $discount_id)
    {
        $discount = Discount::scope()->findOrFail($discount_id);
        $event = Event::scope()->findOrFail($event_id);

        $data = [
            'event'           => $event,
            'discount'  => $discount,
        ];

        return view('ManageEvent.Modals.EditDiscount', $data);
    }


    /**
     * Edit a discount
     *
     * @param Request $request
     * @param $event_id
     * @param $discount_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postEditEventDiscount(Request $request, $event_id, $discount_id)
    {
        // Get the event or display a 'not found' warning.
        $event = Event::scope()->findOrFail($event_id);

        // Create discount.
        $discount = Discount::scope()->findOrFail($discount_id);
        $discount->title = $request->get('title');
        $discount->code = $request->get('code');
        $discount->price = $request->get('price');
        $discount->save();

        session()->flash('message', 'Successfully edited discount');

        return response()->json([
            'status'      => 'success',
            'message'     => 'Refreshing..',
            'redirectUrl' => '',
        ]);

    }


    /**
     * Toggle the enabled status of discount
     *
     * @param Request $request
     * @param $event_id
     * @param $discount_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postEnableDiscount(Request $request, $event_id, $discount_id)
    {
        $discount = Discount::scope()->find($discount_id);

        $discount->is_enabled = ($discount->is_enabled == 1) ? 0 : 1;

        if ($discount->save()) {
            return response()->json([
                'status'  => 'success',
                'message' => 'Discount Successfully Updated',
                'id'      => $discount->id,
            ]);
        }

        return response()->json([
            'status'  => 'error',
            'id'      => $discount->id,
            'message' => 'Whoops! Looks like something went wrong. Please try again.',
        ]);
    }


    /**
     * Delete a discount
     *
     * @param Request $request
     * @param $event_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDeleteEventDiscount(Request $request, $event_id)
    {
        $discount_id = $request->get('discount_id');

        $discount = Discount::scope()->find($discount_id);

        if ($discount->delete()) {

            session()->flash('message', 'Discount successfully deleted');

            return response()->json([
                'status'      => 'success',
                'message'     => 'Refreshing..',
                'redirectUrl' => '',
            ]);
        }

        return response()->json([
            'status'  => 'error',
            'id'      => $discount->id,
            'message' => 'This discount can\'t be deleted.',
        ]);
    }

}
