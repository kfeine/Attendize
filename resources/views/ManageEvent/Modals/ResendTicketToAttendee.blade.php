<div role="dialog"  class="modal fade" style="display: none;">
   {!! Form::open(array('url' => route('postResendTicketToAttendee', array('attendee_id' => $attendee->id)), 'class' => 'ajax reset closeModalAfter')) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">
                    <i class="ico-envelope"></i>
                    @lang('manageevent_modals_resendtickettoattendee.title', ['fullname' => $attendee->full_name])
                </h3>
            </div>
            <div class="modal-body">
                <div class="help-block">
                    @lang('manageevent_modals_resendtickettoattendee.help', ['email' => '<b>'.$attendee->email.'</b>'])
                </div>
            </div> <!-- /end modal body-->
            <div class="modal-footer">
               {!! Form::button(__('manageevent_modals_resendtickettoattendee.cancel'), ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
               {!! Form::submit(__('manageevent_modals_resendtickettoattendee.send'), ['class'=>"btn btn-success"]) !!}
            </div>
        </div><!-- /end modal content-->
        {!! Form::close() !!}
    </div>
</div>
