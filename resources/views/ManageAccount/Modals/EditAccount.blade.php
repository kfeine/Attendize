<div role="dialog"  class="modal fade" style="display: none;">
    <style>
        .account_settings .modal-body {
            border: 0;
            margin-bottom: -35px;
            border: 0;
            padding: 0;
        }

        .account_settings .panel-footer {
            margin: -15px;
            margin-top: 20px;
        }

        .account_settings .panel {
            margin-bottom: 0;
            border: 0;
        }
    </style>
    <div class="modal-dialog account_settings">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">
                    <i class="ico-cogs"></i>
                    @lang('manageaccount_modals_editaccount.account')</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <!-- tab -->
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#general_account" data-toggle="tab">@lang('manageaccount_modals_editaccount.general')</a></li>
                            <li><a href="#payment_account" data-toggle="tab">@lang('manageaccount_modals_editaccount.payment')</a></li>
                            <li><a href="#users_account" data-toggle="tab">@lang('manageaccount_modals_editaccount.users')</a></li>
                            <li><a href="#about" data-toggle="tab">@lang('manageaccount_modals_editaccount.about')</a></li>
                        </ul>
                        <div class="tab-content panel">
                            <div class="tab-pane active" id="general_account">
                                {!! Form::model($account, array('url' => route('postEditAccount'), 'class' => 'ajax ')) !!}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('first_name', __('manageaccount_modals_editaccount.firstname'), array('class'=>'control-label required')) !!}
                                            {!!  Form::text('first_name', Input::old('first_name'),
                                        array(
                                        'class'=>'form-control'
                                        ))  !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('last_name', __('manageaccount_modals_editaccount.lastname'), array('class'=>'control-label required')) !!}
                                            {!!  Form::text('last_name', Input::old('last_name'),
                                        array(
                                        'class'=>'form-control'
                                        ))  !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('email', __('manageaccount_modals_editaccount.email'), array('class'=>'control-label required')) !!}
                                            {!!  Form::text('email', Input::old('email'),
                                        array(
                                        'class'=>'form-control'
                                        ))  !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('timezone_id', __('manageaccount_modals_editaccount.timezone'), array('class'=>'control-label required')) !!}
                                            {!! Form::select('timezone_id', $timezones, $account->timezone_id, ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('currency_id', __('manageaccount_modals_editaccount.currency'), array('class'=>'control-label required')) !!}
                                            {!! Form::select('currency_id', $currencies, $account->currency_id, ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel-footer">
                                            {!! Form::submit(__('manageaccount_modals_editaccount.save'), ['class' => 'btn btn-success pull-right']) !!}
                                        </div>
                                    </div>
                                </div>

                                {!! Form::close() !!}
                            </div>
                            <div class="tab-pane " id="payment_account">

                               @include('ManageAccount.Partials.PaymentGatewayOptions')

                            </div>
                            <div class="tab-pane" id="users_account">
                                {!! Form::open(array('url' => route('postInviteUser'), 'class' => 'ajax ')) !!}

                                <div class="table-responsive">
                                    <table class="table table-bordered">

                                        <tbody>
                                        @foreach($account->users as $user)
                                            <tr>
                                                <td>
                                                    {{$user->first_name}} {{$user->last_name}}
                                                </td>
                                                <td>
                                                    {{$user->email}}
                                                </td>
                                                <td>
                                                    {!! $user->is_parent ? '<span class="label label-info">'.__('manageaccount_modals_editaccount.owner').'</span>' : '' !!}
                                                </td>

                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="3">
                                                <div class="input-group">
                                                    {!! Form::text('email', '',  ['class' => 'form-control', 'placeholder' => __('manageaccount_modals_editaccount.email_address')]) !!}
                                                    <span class="input-group-btn">
                                                          {!!Form::submit(__('manageaccount_modals_editaccount.add_user'), ['class' => 'btn btn-primary'])!!}
                                                    </span>
                                                </div>
                                                <span class="help-block">
                                                    @lang('manageaccount_modals_editaccount.help')
                                                </span>
                                            </td>

                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                                {!! Form::close() !!}
                            </div>
                            <div class="tab-pane " id="about">
                                <h4>
                                    @lang('manageaccount_modals_editaccount.version')
                                </h4>
                                <p>
                                    @if($version_info['is_outdated'])
                                        @lang('manageaccount_modals_editaccount.outdated', ['installed' => '<b>'.$version_info['installed'].'</b>', 'latest' => '<b>'.$version_info['latest'].'</b>'])
                                    @else
                                        @lang('manageaccount_modals_editaccount.uptodate', ['installed' => '<b>'.$version_info['installed'].'</b>'])
                                    @endif
                                </p>

                                <h4>
                                    @lang('manageaccount_modals_editaccount.licence_information')
                                </h4>
                                <p>
                                    @lang('manageaccount_modals_editaccount.information').
                                </p>
                                <h4>
                                    @lang('manageaccount_modals_editaccount.opensource')
                                </h4>
                                <p>
                                    @lang('manageaccount_modals_editaccount.opensource_message')
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
