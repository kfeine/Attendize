@extends('Emails.Layouts.Master')

@section('message_content')

<p>@lang('emails_confirmemail.hi')</p>
<p>
    @lang('emails_confirmemail.message1', ['appname' => config('attendize.app_name')])
</p>

<p>
    @lang('emails_confirmemail.message2') 
</p>

<div style="padding: 5px; border: 1px solid #ccc;">
   {{route('confirmEmail', ['confirmation_code' => $confirmation_code])}}
</div>
<br><br>
<p>
   @lang('emails_confirmemail.message3') 
</p>
<p>
    @lang('emails_confirmemail.thanks')
</p>

@stop

@section('footer')


@stop
