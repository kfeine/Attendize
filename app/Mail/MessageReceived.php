<?php

namespace App\Mail;

use App\Models\Message;
use App\Models\Attendee;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MessageReceived extends Mailable
{
    use Queueable, SerializesModels;

    protected $attendee;
    protected $message_object;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Attendee $attendee, Message $message_object)
    {
        $this->attendee = $attendee;
        $this->message_object = $message_object;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      $data = [
          'attendee'        => $this->attendee,
          'event'           => $this->message_object->event,
          'message_content' => $this->message_object->message,
          'subject'         => $this->message_object->subject,
          'email_logo'      => $this->attendee->event->organiser->full_logo_path,
      ];

      return $this->from(config('attendize.outgoing_email_noreply'), $this->attendee->event->organiser->name)
        ->replyTo($this->attendee->event->organiser->email, $this->attendee->event->organiser->name)
        ->subject($this->message_object->subject)
        ->with($data)
        ->view('Emails.messageReceived');
    }
}
