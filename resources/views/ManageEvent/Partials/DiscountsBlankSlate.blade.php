@extends('Shared.Layouts.BlankSlate')

@section('blankslate-icon-class')
    ico-gift
@stop

@section('blankslate-title')
    No Discounts Yet
@stop

@section('blankslate-text')
    Create your first discount by clicking the button below.
@stop

@section('blankslate-body')
    <button data-invoke="modal" data-modal-id='CreateEventDiscount' data-href="{{route('showCreateEventDiscount', array('event_id'=>$event->id))}}" href='javascript:void(0);'  class=' btn btn-success mt5 btn-lg' type="button" >
        <i class="ico-gift"></i>
        Create Discount
    </button>
@stop
