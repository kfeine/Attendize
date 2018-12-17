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

    public function sendOrderInvoice($order)
    {

        Log::info("Sending ticket to: " . $order->email);

        $data = [
            'order' => $order,
        ];

        Mail::send('Mailers.TicketMailer.SendOrderInvoice', $data, function ($message) use ($order) {
            $message->subject(trans('ordermailer.orderticket_subject') . $order->event->title);
        });

        $file_path = public_path(config('attendize.event_pdf_invoices_path')) . '/' . $order->order_reference . '.pdf';
        if (!file_exists($file_path)) {
            Log::error("Could not send invoice to: " . $order->email . " as invoice file does not exist on disk");
            Mail::send('Emails.OrderNotification', $data, function ($message) use ($order) {
                $message->to($order->email);
                $message->subject(trans('ordermailer.orderticket_subject') . $order->event->title . ' [' . $order->order_reference . ']');
            });
        } else {
            Log::info("Sending invoice to: " . $order->email);
            Mail::send('Emails.OrderNotification', $data, function ($message) use ($order, $file_path) {
                $message->to($order->email);
                $message->subject(trans('ordermailer.orderticket_subject') . $order->event->title . ' [' . $order->order_reference . ']');
                $message->attach($file_path);
            });
        }
    }
}
