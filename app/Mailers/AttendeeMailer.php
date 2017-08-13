<?php

namespace App\Mailers;

use App\Models\Attendee;
use App\Models\Message;
use Carbon\Carbon;
use Log;
use Mail;
use App\Mail\MessageReceived;
use App\Mail\SendAttendeeInvite;


class AttendeeMailer extends Mailer
{

    public function sendAttendeeTicket($attendee)
    {

        Log::info("Sending ticket to: " . $attendee->email);

        $data = [
            'attendee' => $attendee,
        ];

        Mail::send('Mailers.TicketMailer.SendAttendeeTicket', $data, function ($message) use ($attendee) {
            $message->to($attendee->email);
            $message->subject('Your ticket for the event ' . $attendee->order->event->title);

            $file_name = $attendee->reference;
            $file_path = public_path(config('attendize.event_pdf_tickets_path')) . '/' . $file_name . '.pdf';

            $message->attach($file_path);
        });

    }

    /**
     * Sends the attendees a message
     *
     * @param Message $message_object
     */
    public function sendMessageToAttendees(Message $message_object)
    {
        $event = $message_object->event;

        $attendees = ($message_object->recipients == 'all')
            ? $event->attendees // all attendees
            : Attendee::where('ticket_id', '=', $message_object->recipients)->where('account_id', '=',
                $message_object->account_id)->get();

        foreach ($attendees as $attendee) {
            Mail::to($attendee->email, $attendee->full_name)
                ->send(new MessageReceived($attendee, $message_object));
        }

        $message_object->is_sent = 1;
        $message_object->sent_at = Carbon::now();
        $message_object->save();
    }

    public function SendAttendeeInvite($attendee)
    {

        Log::info("Sending invite to: " . $attendee->email);

        Mail::to($attendee->email)
          ->queue(new SendAttendeeInvite($attendee));
    }


}
