<div role="dialog"  class="modal fade" style="display: none;">
   {!! Form::open(array('url' => route('postCreateTicketOption', array('event_id' => $event->id, 'ticket_id' => $ticket->id)), 'class' => 'ajax')) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">
                    <i class="ico-ticket"></i>
                    @lang('manageevent_modals_createticketoption.create_option')</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('title', __('manageevent_modals_createticketoption.name'), array('class'=>'control-label required')) !!}
                            {!! Form::text('title', Input::old('title'),
                                        array(
                                        'class'=>'form-control',
                                        'placeholder'=>__('manageevent_modals_createticketoption.name')
                                        )) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', __('manageevent_modals_createticketoption.description'), array('class'=>'control-label required')) !!}
                            {!! Form::text('description', Input::old('description'),
                                        array(
                                        'class'=>'form-control'
                                        )) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::checkbox('multiple', 1, false) !!}
                            {!! Form::label('multiple', __('manageevent_modals_createticketoption.multiple'), array('class'=>'control-label required')) !!}
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label('price', __('manageevent_modals_createticketoption.price'), array('class'=>'control-label required')) !!}
                                    {!! Form::text('price', Input::old('price'),
                                                array(
                                                'class'=>'form-control',
                                                'placeholder'=>__('manageevent_modals_createticketoption.price')
                                                )) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- /end modal body-->
            <div class="modal-footer">
               {!! Form::button(__('manageevent_modals_createticketoption.close'), ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
               {!! Form::submit(__('manageevent_modals_createticketoption.create'), ['class'=>"btn btn-success"]) !!}
            </div>
        </div><!-- /end modal content-->
       {!! Form::close() !!}
    </div>
</div>
