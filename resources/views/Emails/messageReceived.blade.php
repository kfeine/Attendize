@extends('Emails.Layouts.Master')

@section('message_content')

<p>@lang('emails_messagereceived.hi')</p>
<p>@lang('emails_messagereceived.message1', ['from' => '<b>'.(isset($sender_name) ? $sender_name : $event->organiser->name).'</b>', 'event' => '<b>'.$event->title.'</b>']).</p>
<p style="padding: 10px; margin:10px; border: 1px solid #f3f3f3;">
    {{nl2br($message_content)}}
</p>

<p>
    @lang('emails_messagereceived.message2', ['sender' => '<b>'.(isset($sender_name) ? $sender_name : $event->organiser->name).'</b>', 'at' => '<a href="mailto:'.(isset($sender_email) ? $sender_email : $event->organiser->email).'">'.(isset($sender_email) ? $sender_email : $event->organiser->email).'</a>'])
</p>
@stop

@section('footer')


@stop
