@extends('Emails.Layouts.Master')

@section('message_content')

    <p>@lang('emails_notifyrefundedattendee.hi')</p>
    <p>
        @lang('emails_notifyrefundedattendee.message1', ['for' => '<b>'.'$attendee->event->title.'</b>'])
        <b>@lang('emails_notifyrefundedattendee.message2', ['amount' => $refund_amount ])</b>
    </p>

    <p>
        @lang('emails_notifyrefundedattendee.message3', ['sender' => '<b>'.$attendee->event->organiser->name.'</b>', 'at' => '<a href="mailto:'.$attendee->event->organiser->email.'">'.$attendee->event->organiser->email.'</a>'])
    </p>
@stop

@section('footer')

@stop
