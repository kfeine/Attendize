@extends('Emails.Layouts.Master')

@section('message_content')
@lang('mailers_ticketmailer_sendattendeeinvite.hi', ['firstname' => $attendee->first_name])<br><br>

@lang('mailers_ticketmailer_sendattendeeinvite.invited', ['title' => '<b>'.$attendee->order->event->title.'</b>']).<br/>
@lang('mailers_ticketmailer_sendattendeeinvite.ticket')

<br><br>
@lang('mailers_ticketmailer_sendattendeeinvite.regards')
@stop
