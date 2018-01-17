<?php

namespace App\Mailers;

use App\Models\Order;
use Log;
use Mail;

class OrderMailer
{
    public function sendOrderNotification(Order $order)
    {
        $data = [
            'order' => $order
        ];

        Mail::send('Emails.OrderNotification', $data, function ($message) use ($order) {
            $message->to($order->event->organiser->emails);
            $message->subject(trans('ordermailer.ordernotification_subject') . $order->event->title . ' [' . $order->order_reference . ']');
        });

    }

    public function sendOrderTickets($order)
    {

        Log::info("Sending ticket to: " . $order->email);

        $data = [
            'order' => $order,
        ];

        Mail::send('Mailers.TicketMailer.SendOrderTickets', $data, function ($message) use ($order) {
            $message->to($order->email);
            $message->subject(trans('ordermailer.orderticket_subject') . $order->event->title);
        });

    }

}
