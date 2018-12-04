<div role="dialog"  class="modal fade" style="display: none;">
   {!! Form::open(array('url' => route('options_generic.store', array('event_id' => $event->id)), 'class' => 'ajax')) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">
                    <i class="ico-ticket"></i>
                    @lang('manageevent_modals_createoptionsgeneric.create_option')</h3>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::label('title', __('manageevent_modals_createoptionsgeneric.title'), array('class'=>'control-label required')) !!}
                    {!! Form::text('title', Input::old('title'),
                                array(
                                'class'=>'form-control',
                                'placeholder'=>__('manageevent_modals_createoptionsgeneric.title')
                                )) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('quantity_available', __('manageevent_modals_createoptionsgeneric.quantity'), array('class'=>' control-label')) !!}
                    {!!  Form::text('quantity_available', Input::old('quantity_available'),
                        array(
                        'class'=>'form-control',
                        'placeholder'=>__('manageevent_modals_createoptionsgeneric.quantity_placeholder'),
                        ))  !!}
                </div>
            </div> <!-- /end modal body-->
            <div class="modal-footer">
               {!! Form::button(__('manageevent_modals_createoptionsgeneric.close'), ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
               {!! Form::submit(__('manageevent_modals_createoptionsgeneric.create'), ['class'=>"btn btn-success"]) !!}
            </div>
        </div><!-- /end modal content-->
       {!! Form::close() !!}
    </div>
</div>
