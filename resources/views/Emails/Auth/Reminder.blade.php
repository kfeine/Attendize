@extends('Emails.Layouts.Master')

@section('message_content')
    <div>
        @lang('emails_auth_reminder.hello')<br><br>
        @lang('emails_auth_reminder.message') {{ route('showResetPassword', ['token' => $token]) }}.
        <br><br><br>
        @lang('emails_auth_reminder.thanks')<br>
        @lang('emails_auth_reminder.signature')
    </div>
@stop
