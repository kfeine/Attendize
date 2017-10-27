@extends('Shared.Layouts.BlankSlate')

@section('blankslate-icon-class')
    ico-question2
@stop

@section('blankslate-title')
    @lang('manageevent_partials_surveyblankslate.title')
@stop

@section('blankslate-text')
    @lang('manageevent_partials_surveyblankslate.text')
@stop

@section('blankslate-body')
    <button data-invoke="modal" data-modal-id='CreateQuestion' data-href="{{route('showCreateEventQuestion', array('event_id'=>$event->id))}}" href='javascript:void(0);'  class=' btn btn-success mt5 btn-lg' type="button" >
        <i class="ico-question"></i>
        @lang('manageevent_partials_surveyblankslate.create')
    </button>
@stop
