<div role="dialog"  class="modal fade " style="display: none;">
   {!! Form::open(array('url' => route('postInviteAttendee', array('event_id' => $event->id)), 'class' => 'ajax')) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">
                    <i class="ico-user"></i>
                    @lang('manageevent_modals_inviteattendee.invite')</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                   {!! Form::label('ticket_id', __('manageevent_modals_inviteattendee.ticket'), array('class'=>'control-label required')) !!}
                                   {!! Form::select('ticket_id', $tickets, null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                {!! Form::label('first_name', __('manageevent_modals_inviteattendee.firstname'), array('class'=>'control-label required')) !!}

                                {!!  Form::text('first_name', Input::old('first_name'),
                                            array(
                                            'class'=>'form-control'
                                            ))  !!}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                {!! Form::label('last_name', __('manageevent_modals_inviteattendee.lastname'), array('class'=>'control-label')) !!}

                                {!!  Form::text('last_name', Input::old('last_name'),
                                            array(
                                            'class'=>'form-control'
                                            ))  !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('email', __('manageevent_modals_inviteattendee.email'), array('class'=>'control-label required')) !!}

                            {!!  Form::text('email', Input::old('email'),
                                                array(
                                                'class'=>'form-control'
                                                ))  !!}
                        </div>

                        <div class="form-group">
                            <div class="checkbox custom-checkbox">
                                <input type="checkbox" name="email_ticket" id="email_ticket" value="1" />
                                <label for="email_ticket">@lang('manageevent_modals_inviteattendee.ticket')</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- /end modal body-->
            <div class="modal-footer">
               {!! Form::button(__('manageevent_modals_inviteattendee.cancel'), ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
               {!! Form::submit(__('manageevent_modals_inviteattendee.submit'), ['class'=>"btn btn-success"]) !!}
            </div>
        </div><!-- /end modal content-->
       {!! Form::close() !!}
    </div>
</div>
