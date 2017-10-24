@extends('Shared.Layouts.Master')

@section('title')
@parent

@lang('manageevent_widgets.title')
@stop

@section('top_nav')
@include('ManageEvent.Partials.TopNav')
@stop

@section('menu')
@include('ManageEvent.Partials.Sidebar')
@stop

@section('page_title')
<i class='ico-code mr5'></i>
@lang('manageevent_widgets.surveys')
@stop

@section('head')

@stop

@section('page_header')
<style>
    .page-header {display: none;}
</style>
@stop


@section('content')
<div class="row">


    <div class="col-md-12">

        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4>@lang('manageevent_widgets.code')</h4>
                            <textarea rows="7" onfocus="this.select();"
                                      class="form-control">{{$event->embed_html_code}}</textarea>
                    </div>
                    <div class="col-md-6">
                        <h4>@lang('manageevent_widgets.instructions')</h4>

                        <p>
                            @lang('manageevent_widgets.text_instructions')
                        </p>

                        <h5>
                            <b>@lang('manageevent_widgets.embed_preview')</b>
                        </h5>

                        <div class="preview_embed" style="border:1px solid #ddd; padding: 5px;">
                            {!! $event->embed_html_code !!}
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@stop
