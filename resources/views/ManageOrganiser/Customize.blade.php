@extends('Shared.Layouts.Master')

@section('title')
    @parent
    @lang('manageorganiser_customize.title')
@stop

@section('page_title')
  @lang('manageorganiser_customize.name_events', ['name' => $organiser->name])
@stop

@section('top_nav')
    @include('ManageOrganiser.Partials.TopNav')
@stop

@section('head')
    <style>
        .page-header {
            display: none;
        }
    </style>
    <script>
        $(function () {
            $('.colorpicker').minicolors({
                changeDelay: 500,
                change: function () {
                    var replaced = replaceUrlParam('{{route('showOrganiserHome', ['organiser_id'=>$organiser->id])}}', 'preview_styles', encodeURIComponent($('#OrganiserPageDesign form').serialize()));
                    document.getElementById('previewIframe').src = replaced;
                }
            });

        });
    </script>
@stop

@section('menu')
    @include('ManageOrganiser.Partials.Sidebar')
@stop

@section('page_header')

@stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#organiserSettings" data-toggle="tab">@lang('manageorganiser_customize.settings')</a>
                </li>
                <li>
                    <a href="#OrganiserPageDesign" data-toggle="tab">@lang('manageorganiser_customize.page_design')</a>
                </li>
            </ul>
            <div class="tab-content panel">
                <div class="tab-pane active" id="organiserSettings">
                    {!! Form::model($organiser, array('url' => route('postEditOrganiser', ['organiser_id' => $organiser->id]), 'class' => 'ajax')) !!}

                    <div class="form-group">
                        {!! Form::label('enable_organiser_page', __('manageorganiser_customize.enable_page'), array('class'=>'control-label required')) !!}
                        {!!  Form::select('enable_organiser_page', [
                        '1' => __('manageorganiser_customize.make_visible'),
                        '0' => __('manageorganiser_customize.hide_page')],Input::old('enable_organiser_page'),
                                                    array(
                                                    'class'=>'form-control'
                                                    ))  !!}
                        <div class="help-block">
                            @lang('manageorganiser_customize.help')
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('name', __('manageorganiser_customize.name'), array('class'=>'required control-label ')) !!}
                        {!!  Form::text('name', Input::old('name'),
                                                array(
                                                'class'=>'form-control'
                                                ))  !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('email', __('manageorganiser_customize.email'), array('class'=>'control-label required')) !!}
                        {!!  Form::text('email', Input::old('email'),
                                                array(
                                                'class'=>'form-control ',
                                                'placeholder'=>''
                                                ))  !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('about', __('manageorganiser_customize.description'), array('class'=>'control-label ')) !!}
                        {!!  Form::textarea('about', Input::old('about'),
                                                array(
                                                'class'=>'form-control ',
                                                'placeholder'=>'',
                                                'rows' => 4
                                                ))  !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('google_analytics_code', __('manageorganiser_customize.google'), array('class'=>'control-label')) !!}
                        {!!  Form::text('google_analytics_code', Input::old('google_analytics_code'),
                                                array(
                                                'class'=>'form-control',
                                                'placeholder' => 'UA-XXXXX-X',
                                                ))
                        !!}
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('facebook', __('manageorganiser_customize.facebook'), array('class'=>'control-label ')) !!}

                                <div class="input-group">
                                    <span style="background-color: #eee;" class="input-group-addon">facebook.com/</span>
                                    {!!  Form::text('facebook', Input::old('facebook'),
                                                    array(
                                                    'class'=>'form-control ',
                                                    'placeholder'=>'Username'
                                                    ))  !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('twitter', __('manageorganiser_customize.twitter'), array('class'=>'control-label ')) !!}

                                <div class="input-group">
                                    <span style="background-color: #eee;" class="input-group-addon">twitter.com/</span>
                                    {!!  Form::text('twitter', Input::old('twitter'),
                                             array(
                                             'class'=>'form-control ',
                                             'placeholder'=>'Username'
                                             ))  !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(is_file($organiser->logo_path))
                        <div class="form-group">
                            {!! Form::label('current_logo', __('manageorganiser_customize.current_logo'), array('class'=>'control-label ')) !!}

                            <div class="thumbnail">
                                {!!HTML::image($organiser->logo_path)!!}
                                {!! Form::label('remove_current_image', __('manageorganiser_customize.delete_logo'), array('class'=>'control-label ')) !!}
                                {!! Form::checkbox('remove_current_image') !!}
                            </div>
                        </div>
                    @endif
                    <div class="form-group">
                        {!!  Form::labelWithHelp('organiser_logo', __('manageorganiser_customize.logo'), array('class'=>'control-label '),
                            __('manageorganiser_customize.help_logo'))  !!}
                        {!!Form::styledFile('organiser_logo')!!}
                    </div>
                    <div class="modal-footer">
                        {!! Form::submit(__('manageorganiser_customize.save'), ['class'=>"btn btn-success"]) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="tab-pane scale_iframe" id="OrganiserPageDesign">
                    {!! Form::model($organiser, array('url' => route('postEditOrganiserPageDesign', ['event_id' => $organiser->id]), 'class' => 'ajax ')) !!}

                    <div class="row">

                        <div class="col-md-6">
                            <h4>@lang('manageorganiser_customize.design')</h4>

                            <div class="form-group">
                                {!! Form::label('page_header_bg_color', __('manageorganiser_customize.header'), ['class'=>'control-label required ']) !!}
                                {!!  Form::input('text', 'page_header_bg_color', Input::old('page_header_bg_color'),
                                                            [
                                                            'class'=>'form-control colorpicker',
                                                            'placeholder'=>'#000000'
                                                            ])  !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('page_text_color', __('manageorganiser_customize.text_color'), ['class'=>'control-label required ']) !!}
                                {!!  Form::input('text', 'page_text_color', Input::old('page_text_color'),
                                                            [
                                                            'class'=>'form-control colorpicker',
                                                            'placeholder'=>'#FFFFFF'
                                                            ])  !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('page_bg_color', __('manageorganiser_customize.background'), ['class'=>'control-label required ']) !!}
                                {!!  Form::input('text', 'page_bg_color', Input::old('page_bg_color'),
                                                            [
                                                            'class'=>'form-control colorpicker',
                                                            'placeholder'=>'#EEEEEE'
                                                            ])  !!}
                            </div>
                            <div class="form-group">

                            </div>
                        </div>
                        <div class="col-md-6">
                            <h4>@lang('manageorganiser_customize.preview')</h4>
                            <div class="preview iframe_wrap"
                                 style="overflow:hidden; height: 500px; border: 1px solid #ccc; overflow: hidden;">
                                <iframe id="previewIframe"
                                        src="{{ route('showOrganiserHome', ['organiser_id' => $organiser->id]) }}"
                                        frameborder="0" style="overflow:hidden;height:100%;width:100%" width="100%"
                                        height="100%"></iframe>
                            </div>
                        </div>


                    </div>

                    <div class="panel-footer mt15 text-right">
                        {!! Form::submit(__('manageorganiser_customize.save'), ['class'=>"btn btn-success"]) !!}
                    </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
@stop
