<div role="dialog"  class="modal fade" style="display: none;">
   {!! Form::open(array('url' => route('postMessageOrder', array('attendee_id' => $order->id)), 'class' => 'ajax reset closeModalAfter')) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">
                    <i class="ico-envelope"></i>
                    @lang('manageevent_modals_messageorder.message') {{{$order->full_name}}}
                    <br>
                    <span style="font-size: 17px;">
                        @lang('manageevent_modals_messageorder.order') #{{$order->order_reference}}
                    </span>
                </h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('subject', __('manageevent_modals_messageorder.subject'), array('class'=>'control-label required')) !!}
                            {!!  Form::text('subject', Input::old('subject'),
                                        array(
                                        'class'=>'form-control'
                                        ))  !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('message', __('manageevent_modals_messageorder.content'), array('class'=>'control-label required')) !!}
                            {!!  Form::textarea('message', Input::old('message'),
                                        array(
                                        'class'=>'form-control',
                                        'rows' => '5'
                                        ))  !!}
                        </div>

                        <div class="form-group">
                            <div class="checkbox custom-checkbox">
                                <input type="checkbox" name="send_copy" id="send_copy" value="1">
                                <label for="send_copy">@lang('manageevent_modals_messageorder.send_copy', ['email' => '<b>'.$order->event->organiser->email.'</b>'])</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="help-block">
                    @lang('manageevent_modals_messageorder.help', ['email' => '<b>'.$order->event->organiser->email.'</b>'])
                </div>

            </div> <!-- /end modal body-->
            <div class="modal-footer">
               {!! Form::button(__('manageevent_modals_messageorder.cancel'), ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
               {!! Form::submit(__('manageevent_modals_messageorder.send'), ['class'=>"btn btn-success"]) !!}
            </div>
        </div><!-- /end modal content-->
       {!! Form::close() !!}
    </div>
</div>
