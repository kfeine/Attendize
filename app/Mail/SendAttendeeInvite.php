<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendAttendeeInvite extends Mailable
{
    use Queueable, SerializesModels;

    public $attendee;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Attendee $attendee)
    {
        $this->attendee = $attendee;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $file_name = $this->attendee->getReferenceAttribute();
        $file_path = public_path(config('attendize.event_pdf_tickets_path')) . '/' . $file_name . '.pdf';

        return $this->subject('Your ticket for the event ' . $this->attendee->order->event->title)
          ->attach($file_path)
          ->view('Mailers.TicketMailer.SendAttendeeInvite');
    }
}
