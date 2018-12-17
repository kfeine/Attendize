<?php

namespace App\Listeners;

use App\Events\OrderCompletedEvent;
use App\Jobs\GenerateInvoice;
use App\Jobs\SendOrderNotification;
use App\Jobs\SendOrderInvoice;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class OrderCompletedListener implements ShouldQueue
{

    use DispatchesJobs;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrderCompletedEvent  $event
     * @return void
     */
    public function handle(OrderCompletedEvent $event)
    {
        /**
         * Generate the PDF invoice and send email etc.
         */
        Log::info('Begin Processing Order: ' . $event->order->order_reference);
        $this->dispatchNow(new GenerateInvoice($event->order->order_reference));
        $this->dispatch(new SendOrderInvoice($event->order));
        $this->dispatch(new SendOrderNotification($event->order));

    }
}
