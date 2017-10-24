@extends('Emails.Layouts.Master')

@section('message_content')
@lang('mailers_ticketmailer_sendattendeeticket.hi', ['firstname' => $attendee->first_name])<br><br>

@lang('mailers_ticketmailer_sendattendeeticket.ticket', ['title' => '<b>'.$attendee->order->event->title.'</b>']).<br/>

<br><br>
@lang('mailers_ticketmailer_sendattendeeticket.thanks')
@stop
