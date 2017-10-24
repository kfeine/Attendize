@extends('Shared.Layouts.BlankSlate')

@section('blankslate-icon-class')
    ico-gift
@stop

@section('blankslate-title')
    @lang('manageevent_partials_discountblankslate.title')
@stop

@section('blankslate-text')
    @lang('manageevent_partials_discountblankslate.text')
@stop

@section('blankslate-body')
    <button data-invoke="modal" data-modal-id='CreateEventDiscount' data-href="{{route('showCreateEventDiscount', array('event_id'=>$event->id))}}" href='javascript:void(0);'  class=' btn btn-success mt5 btn-lg' type="button" >
        <i class="ico-gift"></i>
        @lang('manageevent_partials_discountblankslate.create_discount')
    </button>
@stop
