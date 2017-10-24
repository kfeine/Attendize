@extends('Shared.Layouts.MasterWithoutMenus')

@section('title')
@lang('auth_passwords_reset.title')
@stop

@section('content')
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                {!! Form::open(array('url' => '/password/reset', 'class' => 'panel')) !!}

                <div class="logo">
                   {!!HTML::image('assets/images/logo-dark.png')!!}
                </div>
                <h2>Reset Password</h2>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    {!! Form::label('email', __('auth_passwords_reset.email'), ['class' => 'control-label']) !!}
                    {!! Form::text('email', null, ['class' => 'form-control', 'autofocus' => true]) !!}
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    {!! Form::label('password', __('auth_passwords_reset.password'), ['class' => 'control-label']) !!}
                    {!! Form::password('password',  ['class' => 'form-control']) !!}
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    {!! Form::label('password_confirmation', __('auth_passwords_reset.confirm'), ['class' => 'control-label']) !!}
                    {!! Form::password('password_confirmation',  ['class' => 'form-control']) !!}
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
                {!! Form::hidden('token',  $token) !!}
                <div class="form-group nm">
                    <button type="submit" class="btn btn-block btn-success">@lang('auth_passwords_reset.submit')</button>
                </div>
                <div class="signup">
                  <a class="semibold" href="{{route('login')}}">
                      <i class="ico ico-arrow-left"></i> @lang('auth_passwords_reset.back')
                  </a>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
