@extends('Shared.Layouts.BlankSlate')


@section('blankslate-icon-class')
    ico-users
@stop

@section('blankslate-title')
    @lang('manageevent_partials_attendeesblankslate.title')
@stop

@section('blankslate-text')
    @lang('manageevent_partials_attendeesblankslate.text')
@stop

@section('blankslate-body')
<button data-invoke="modal" data-modal-id='InviteAttendee' data-href="{{route('showInviteAttendee', array('event_id'=>$event->id))}}" href='javascript:void(0);'  class=' btn btn-success mt5 btn-lg' type="button" >
    <i class="ico-user-plus"></i>
    @lang('manageevent_partials_attendeesblankslate.invite_attendee')
</button>
@stop
