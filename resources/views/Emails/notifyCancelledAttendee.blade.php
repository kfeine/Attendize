@extends('Emails.Layouts.Master')

@section('message_content')

<p>@lang('emails_notifycancelledattendee.hi')</p>
<p>
    @lang('emails_notifycancelledattendee.message1', ['title' => '<b>'.$attendee->event->title.'</b>'])
</p>

<p>
    @lang('emails_notifycancelledattendee.message2', ['sender' => '<b>'.$attendee->event->organiser->name.'</b>', 'at' => '<a href="mailto:'.$attendee->event->organiser->email.'">'.$attendee->event->organiser->email.'</a>'])
</p>
@stop

@section('footer')

@stop
