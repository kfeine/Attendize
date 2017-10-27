@extends('Shared.Layouts.MasterWithoutMenus')

@section('title', __('auth_login.title'))

@section('content')
    {!! Form::open(array('url' => 'login')) !!}
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel">
                <div class="panel-body">
                    <div class="logo">
                        {!!HTML::image('assets/images/logo-dark.png')!!}
                    </div>

                    @if(Session::has('failed'))
                        <h4 class="text-danger mt0">@lang('auth_login.whoops') </h4>
                        <ul class="list-group">
                            <li class="list-group-item">@lang('auth_login.check')</li>
                        </ul>
                    @endif

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        {!! Form::label('email', __('auth_login.email'), ['class' => 'control-label']) !!}
                        {!! Form::text('email', null, ['class' => 'form-control', 'autofocus' => true]) !!}
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        {!! Form::label('password', __('auth_login.password'), ['class' => 'control-label']) !!}
                        {!! Form::password('password',  ['class' => 'form-control']) !!}
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : ''}}> @lang('auth_login.remember')
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-success">@lang('auth_login.login')</button>
                        <a class="btn btn-link" href="{{ url('/password/reset') }}">
                            @lang('auth_login.forgot')
                        </a>
                    </div>

                    @if(Utils::isAttendize())
                    <div class="signup">
                        <span>@lang('auth.login.no_account') <a class="semibold" href="{{ url('register') }}">@lang('auth_login.register')</a></span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop
