@lang('emails_attendeeticket.hi', ['firstname' => $attendee->first_name]),<br><br>

@lang('emails_attendeeticket.message1')<br><br>

@lang('emails_attendeeticket.message2', ['url' => route('showOrderDetails', ['order_reference' => $attendee->order->order_reference])])<br><br>

@lang('emails_attendeeticket.reference') <b>{{$attendee->order->order_reference}}</b>.<br>

@lang('emails_attendeeticket.thanks')<br>

