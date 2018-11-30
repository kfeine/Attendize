@extends('Shared.Layouts.BlankSlate')

@section('blankslate-icon-class')
    ico-ticket
@stop

@section('blankslate-title')
    @lang('manageevent_partials_ticketsblankslate.title')
@stop

@section('blankslate-text')
    @lang('manageevent_partials_ticketsblankslate.text')
@stop

@section('blankslate-body')
    <button data-modal-id='CreateTicket' data-href="{{route('showCreateTicket', array('event_id'=>$event->id))}}"  class='loadModal btn btn-success mt5 btn-lg' type="button" >
        <i class="ico-ticket"></i>
        @lang('manageevent_partials_ticketsblankslate.create')
    </button>
@stop
