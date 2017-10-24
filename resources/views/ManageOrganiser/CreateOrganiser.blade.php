@extends('Shared.Layouts.MasterWithoutMenus')

@section('title')
    @lang('manageorganiser_createorganiser.title')
@stop

@section('head')
    <style>
        .modal-header {
            background-color: transparent !important;
            color: #666 !important;
            text-shadow: none !important;;
        }
    </style>
@stop

@section('content')
    <div class="row">
        <div class="col-md-7 col-md-offset-2">
            <div class="panel">
                <div class="panel-body">
                    <div class="logo">
                        {!!HTML::image('assets/images/logo-dark.png')!!}
                    </div>
                    <h2>@lang('manageorganiser_createorganiser.title')</h2>

                    {!! Form::open(array('url' => route('postCreateOrganiser'), 'class' => 'ajax')) !!}
                    @if(@$_GET['first_run'] == '1')
                        <div class="alert alert-info">
                            @lang('manageorganiser_createorganiser.alert')
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('name', __('manageorganiser_createorganiser.name'), array('class'=>'required control-label ')) !!}
                                {!!  Form::text('name', Input::old('name'),
                                            array(
                                            'class'=>'form-control'
                                            ))  !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('email', __('manageorganiser_createorganiser.email'), array('class'=>'control-label required')) !!}
                                {!!  Form::text('email', Input::old('email'),
                                            array(
                                            'class'=>'form-control ',
                                            'placeholder'=>''
                                            ))  !!}
                            </div>
                        </div>
                    </div>




                    <div class="form-group">
                        {!! Form::label('about', __('manageorganiser_createorganiser.description'), array('class'=>'control-label ')) !!}
                        {!!  Form::textarea('about', Input::old('about'),
                                    array(
                                    'class'=>'form-control ',
                                    'placeholder'=>'',
                                    'rows' => 4
                                    ))  !!}
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('facebook', __('manageorganiser_createorganiser.facebook'), array('class'=>'control-label ')) !!}

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
                                {!! Form::label('twitter', __('manageorganiser_createorganiser.twitter'), array('class'=>'control-label ')) !!}

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

                    <div class="form-group">
                        {!! Form::label('organiser_logo', __('manageorganiser_createorganiser.logo'), array('class'=>'control-label ')) !!}
                        {!! Form::styledFile('organiser_logo') !!}
                    </div>

                    {!! Form::submit(__('manageorganiser_createorganiser.title'), ['class'=>" btn-block btn btn-success"]) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
