@extends('Shared.Layouts.Master')

@section('title')
@parent
@lang('manageevent_promote.title')
@stop

@section('top_nav')
    @include('ManageEvent.Partials.TopNav')
@stop


@section('menu')
    @include('ManageEvent.Partials.Sidebar')
@stop

@section('page_title')
<i class="ico-bullhorn mr5"></i>
@lang('manageevent_promote.title')
@stop


@section('content')
<div class='row'>
    <div class="col-md-12">
        <h1>
            @lang('manageevent_promote.promote')
            <pre>
                [PROMOTE PAGE]
            </pre>
        </h1>
    </div>
</div>
@stop
