@extends('Shared.Layouts.MasterWithoutMenus')

@section('title')
    @lang('installer_installer.title')
@stop

@section('head')
    <style>
        .modal-header {
            background-color: transparent !important;
            color: #666 !important;
            text-shadow: none !important;;
        }
        .alert-success {
            background-color: #dff0d8 !important;
            border-color: #d6e9c6  !important;
            color: #3c763d  !important;
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

                    <h1>@lang('installer_installer.setup')</h1>


                    <h3>@lang('installer_installer.php_version_check')</h3>
                    @if (version_compare(phpversion(), '5.5.9', '<'))
                        <div class="alert alert-warning">
                            @lang('installer_installer.warning_php')
                            <b>5.5.9.</b> @lang('installer_installer.your_version') <b>{{phpversion()}}</b>
                        </div>
                    @else
                        <div class="alert alert-success">
                            @lang('installer_installer.success_php') <b>5.5.9.</b> @lang('installer_installer.yours_php') <b>{{phpversion()}}</b>
                        </div>
                    @endif

                    <h3>@lang('installer_installer.files_folders_check')</h3>
                    @foreach($paths as $path)

                        @if(!File::isWritable($path))
                            <div class="alert alert-danger">
                                @lang('installer_installer.warning'): <b>{{$path}}</b> @lang('installer_installer.not_writable')
                            </div>
                        @else
                            <div class="alert alert-success">
                                @lang('installer_installer.success'): <b>{{$path}}</b> @lang('installer_installer.is_writable')
                            </div>
                        @endif

                    @endforeach

                    <h3>@lang('installer_installer.php_requirements_check')</h3>
                    @foreach($requirements as $requirement)

                        @if(!extension_loaded($requirement))
                            <div class="alert alert-danger">
                                @lang('installer_installer.error'): <b>{{$requirement}}</b> @lang('installer_installer.extension_not_loaded')
                            </div>
                        @else
                            <div class="alert alert-success">
                                @lang('installer_installer.success'): <b>{{$requirement}}</b> @lang('installer_installer.extension_is_loaded')
                            </div>
                        @endif

                    @endforeach

                    <h3>@lang('installer_installer.php_optional_requirements_check')</h3>

                    @foreach($optional_requirements as $optional_requirement)

                        @if(!extension_loaded($optional_requirement))
                            <div class="alert alert-warning">
                                @lang('installer_installer.warning'): <b>{{$optional_requirement}}</b> @lang('installer_installer.extension_not_loaded')
                            </div>
                        @else
                            <div class="alert alert-success">
                                @lang('installer_installer.success'): <b>{{$optional_requirement}}</b> @lang('installer_installer.extension_is_loaded')
                            </div>
                        @endif

                    @endforeach

                    {!! Form::open(array('url' => route('postInstaller'), 'class' => 'installer_form')) !!}

                    <h3>@lang('installer_installer.app_settings')</h3>

                    <div class="form-group">
                        {!! Form::label('app_url', __('installer_installer.application_url'), array('class'=>'required control-label ')) !!}
                        {!!  Form::text('app_url', Input::old('app_url'),
                                    array(
                                    'class'=>'form-control',
                                    'placeholder' => 'http://www.myticketsite.com'
                                    ))  !!}
                    </div>

                    <h3>@lang('installer_installer.database_settings')</h3>

                    <div class="form-group">
                        {!! Form::label('database_type', __('installer_installer.database_type'), array('class'=>'required control-label ')) !!}
                        {!!  Form::select('database_type', array(
                                  'pgsql' => "Postgres",
                                  'mysql' => "MySQL",
                                    ), Input::old('database_type'),
                                    array(
                                    'class'=>'form-control'
                                    ))  !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('database_host', __('installer_installer.database_host'), array('class'=>'control-label required')) !!}
                        {!!  Form::text('database_host', Input::old('database_host'),
                                    array(
                                    'class'=>'form-control ',
                                    'placeholder'=>''
                                    ))  !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('database_name', __('installer_installer.database_name'), array('class'=>'required control-label ')) !!}
                        {!!  Form::text('database_name', Input::old('database_name'),
                                    array(
                                    'class'=>'form-control'
                                    ))  !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('database_username', __('installer_installer.database_username'), array('class'=>'control-label required')) !!}
                        {!!  Form::text('database_username', Input::old('database_username'),
                                    array(
                                    'class'=>'form-control ',
                                    'placeholder'=>'',
                                    ))  !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('database_password', __('installer_installer.database_password'), array('class'=>'control-label ')) !!}
                        {!!  Form::text('database_password', Input::old('database_password'),
                                    array(
                                    'class'=>'form-control ',
                                    'placeholder'=>'',
                                    ))  !!}
                    </div>

                    <div class="form-group">
                        <script>
                            $(function () {
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-Token': "{{csrf_token()}}"
                                    }
                                });

                                $('.test_db').on('click', function (e) {

                                    var url = $(this).attr('href');

                                    $.post(url, $(".installer_form").serialize(), function (data) {
                                        if (data.status === 'success') {
                                            alert('Success! Database settings are working!');
                                        } else {
                                            alert('Unable to connect. Please check your settings.')
                                        }
                                    }, 'json').fail(function (data) {
                                        var returned = $.parseJSON(data.responseText);
                                        console.log(returned.error);
                                        alert('Unable to connect. Please check your settings.\n\n' + 'Error Type: ' + returned.error.type + '\n' + 'Error Message: ' + returned.error.message);
                                    });

                                    e.preventDefault();
                                });
                            });
                        </script>
                        <a href="{{route('postInstaller',['test' => 'db'])}}" class="test_db">
                            @lang('installer_installer.test_database_section')
                        </a>
                    </div>

                    <h3>@lang('installer_installer.email_settings')</h3>

                    <div class="form-group">
                        {!! Form::label('mail_from_address', __('installer_installer.mail_from_address'), array('class'=>' control-label required')) !!}
                        {!!  Form::text('mail_from_address', Input::old('mail_from_address'),
                                    array(
                                    'class'=>'form-control'
                                    ))  !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('mail_from_name', __('installer_installer.mail_from_name'), array('class'=>' control-label required')) !!}
                        {!!  Form::text('mail_from_name', Input::old('mail_from_name'),
                                    array(
                                    'class'=>'form-control'
                                    ))  !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('mail_driver', __('installer_installer.mail_driver'), array('class'=>' control-label required')) !!}
                        {!!  Form::text('mail_driver', Input::old('mail_driver'),
                                    array(
                                    'class'=>'form-control ',
                                    'placeholder' => 'mail'
                                    ))  !!}
                        <div class="help-block">
                            @lang('installer_installer.to_use_phps')
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('mail_port', __('installer_installer.mail_port'), array('class'=>' control-label ')) !!}
                        {!!  Form::text('mail_port', Input::old('mail_port'),
                                    array(
                                    'class'=>'form-control'
                                    ))  !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('mail_encryption', __('installer_installer.mail_encryption'), array('class'=>' control-label ')) !!}
                        {!!  Form::text('mail_encryption', Input::old('mail_encryption'),
                                    array(
                                    'class'=>'form-control'
                                    ))  !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('mail_host', __('installer_installer.mail_host'), array('class'=>' control-label ')) !!}
                        {!!  Form::text('mail_host', Input::old('mail_host'),
                                    array(
                                    'class'=>'form-control'
                                    ))  !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('mail_username', __('installer_installer.mail_username'), array('class'=>' control-label ')) !!}
                        {!!  Form::text('mail_username', Input::old('mail_username'),
                                    array(
                                    'class'=>'form-control'
                                    ))  !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('mail_password', __('installer_installer.mail_password'), array('class'=>' control-label ')) !!}
                        {!!  Form::text('mail_password', Input::old('mail_password'),
                                    array(
                                    'class'=>'form-control'
                                    ))  !!}
                    </div>

                    <div class="well">
                        <p>
                            @lang('installer_installer.installation', ['file' => '<b>'.base_path('.env').'</b>'])
                        </p>
                        <p>
                            @lang('installer_installer.log_file', ['log' => '<b>'.storage_path('logs').'</b>'])
                        </p>
                        <p>
                            @lang('installer_installer.shared_hosting')
                        </p>
                        <p>
                            @lang('installer_installer.still_need_help')
                        </p>
                        <p>
                            @lang('installer_installer.please_also')
                        </p>
                    </div>

                    {!! Form::submit(__('installer_installer.install'), ['class'=>" btn-block btn btn-success"]) !!}
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@stop
