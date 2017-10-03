@extends('Shared.Layouts.MasterWithoutMenus')

@section('title')
@lang('auth_passwords_email.title')
@stop

@section('content')
    <div class="row">
        <div class="col-md-4 col-md-offset-4">

            {!! Form::open(array('url' => 'password/email', 'class' => 'panel')) !!}

            <div class="panel-body">

                <div class="logo">
                   {!!HTML::image('assets/images/logo-dark.png')!!}
                </div>
                <h2>@lang('auth_passwords_email.title')</h2>

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif


                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    {!! Form::label('email', __('auth_passwords_email.email')) !!}
                    {!! Form::text('email', null, ['class' => 'form-control', 'autofocus' => true]) !!}
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group nm">
                    <button type="submit" class="btn btn-block btn-success">@lang('auth_passwords_email.submit')</button>
                </div>
                <div class="signup">
                    <a class="semibold" href="{{route('login')}}">
                        <i class="ico ico-arrow-left"></i> @lang('auth_passwords_email.back')
                    </a>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop
