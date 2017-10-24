@extends('Shared.Layouts.MasterWithoutMenus')

@section('title')
    @lang('public_viewevent_eventnotlivepage.title')
@stop

@section('content')
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel">
                <div class="panel-body">
                    <h4 style="text-align: center;">@lang('public_viewevent_eventnotlivepage.message')</h4>
                </div>
            </div>
        </div>
    </div>
@stop
