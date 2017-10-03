@extends('Shared.Layouts.MasterWithoutMenus')

@section('title')
@lang('auth_register.title')
@stop

@section('content')
    <div class="row">
        <div class="col-md-7 col-md-offset-2">
            {!! Form::open(array('url' => '/register', 'class' => 'panel')) !!}
            <div class="panel-body">
                <div class="logo">
                   {!! HTML::image('assets/images/logo-dark.png') !!}
                </div>
                <h2>@lang('auth_register.register')</h2>

                @if(Input::get('first_run'))
                    <div class="alert alert-info">
                       @lang('auth_register.first_run') 
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group {{ ($errors->has('first_name')) ? 'has-error' : '' }}">
                            {!! Form::label('first_name', __('auth_register.first_name'), ['class' => 'control-label required']) !!}
                            {!! Form::text('first_name', null, ['class' => 'form-control']) !!}
                            @if($errors->has('first_name'))
                                <p class="help-block">{{ $errors->first('first_name') }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group {{ ($errors->has('last_name')) ? 'has-error' : '' }}">
                            {!! Form::label('last_name', __('auth_register.last_name'), ['class' => 'control-label']) !!}
                            {!! Form::text('last_name', null, ['class' => 'form-control']) !!}
                            @if($errors->has('last_name'))
                                <p class="help-block">{{ $errors->first('last_name') }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-group {{ ($errors->has('email')) ? 'has-error' : '' }}">
                    {!! Form::label('email', __('auth_register.email'), ['class' => 'control-label required']) !!}
                    {!! Form::text('email', null, ['class' => 'form-control']) !!}
                    @if($errors->has('email'))
                        <p class="help-block">{{ $errors->first('email') }}</p>
                    @endif
                </div>
                <div class="form-group {{ ($errors->has('password')) ? 'has-error' : '' }}">
                    {!! Form::label('password', __('auth_register.password'), ['class' => 'control-label required']) !!}
                    {!! Form::password('password',  ['class' => 'form-control']) !!}
                    @if($errors->has('password'))
                        <p class="help-block">{{ $errors->first('password') }}</p>
                    @endif
                </div>
                <div class="form-group {{ ($errors->has('password_confirmation')) ? 'has-error' : '' }}">
                    {!! Form::label('password_confirmation', __('auth_register.confirmation'), ['class' => 'control-label required']) !!}
                    {!! Form::password('password_confirmation',  ['class' => 'form-control']) !!}
                </div>

                <div class="form-group ">
                   {!! Form::submit(__('auth_register.register'), array('class'=>"btn btn-block btn-success")) !!}
                </div>

                @if($is_attendize)
                    <div class="signup">
                        <span>@lang('auth_register.already') <a class="semibold" href="/login">@lang('auth_register.signin')</a></span>
                    </div>
                @endif
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
