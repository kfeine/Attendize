<?php

namespace App\Handlers;

use App\Mailers\OrderMailer;
use Attendee;
use Order;

//use PDF;

class QueueHandler
{
    protected $orderMailer;

    public function __construct(OrderMailer $orderMailer)
    {
        $this->orderMailer = $orderMailer;
    }

    public function handleOrder($job, $data)
    {
        echo "Starting Job {$job->getJobId()}\n";

        $order = Order::findOrfail($data['order_id']);

        /*
         * Steps :
         *   1 Notify event organiser
         *   2 Order Confirmation email to buyer
         *   3 Generate /  Send Tickets
         */

        $data = [
            'order'     => $order,
            'event'     => $order->event,
            'tickets'   => $order->event->tickets,
            'attendees' => $order->attendees,
        ];

        $pdf_file = storage_path() . '/' . $order->order_reference;
        exit($pdf_file);

        PDF::setOutputMode('F'); // force to file
        PDF::html('Public.ViewEvent.Partials.PDFTicket', $data, $pdf_file);

        //1
        $this->orderMailer->sendOrderNotification($order);
        //2
        $this->orderMailer->sendOrderInvoice($order);

        $job->delete();
    }
}
