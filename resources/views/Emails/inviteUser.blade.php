@extends('Emails.Layouts.Master')

@section('message_content')

<p>@lang('emails_inviteuser.hi')</p>
<p>
    @lang('emails_inviteuser.message1', ['appname' => config('attendize.app_name'), 'by' => $inviter->first_name.' '.$inviter->last_name])
</p>

<p>
    @lang('emails_inviteuser.message2')<br><br>
    
    @lang('emails_inviteuser.username') <b>{{$user->email}}</b> <br>
    @lang('emails_inviteuser.password') <b>{{$temp_password}}</b>
</p>

<p>
    @lang('emails_inviteuser.message3') 
</p>

<div style="padding: 5px; border: 1px solid #ccc;" >
   {{route('login')}}
</div>
<br><br>
<p>
    @lang('emails_inviteuser.message4') 
</p>
<p>
    @lang('emails_inviteuser.thanks')
</p>

@stop

@section('footer')


@stop
