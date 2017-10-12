<div role="dialog"  class="modal fade" style="display: none;">
   {!! Form::open(array('url' => route('postCreateTicket', array('event_id' => $event->id)), 'class' => 'ajax')) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">
                    <i class="ico-ticket"></i>
                    @lang('manageevent_modals_createticket.create_ticket')</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('title', __('manageevent_modals_createticket.title'), array('class'=>'control-label required')) !!}
                            {!!  Form::text('title', Input::old('title'),
                                        array(
                                        'class'=>'form-control',
                                        'placeholder'=>__('manageevent_modals_createticket.placeholder_title')
                                        ))  !!}
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label('price', __('manageevent_modals_createticket.ticket_price'), array('class'=>'control-label required')) !!}
                                    {!!  Form::text('price', Input::old('price'),
                                                array(
                                                'class'=>'form-control',
                                                'placeholder'=>__('manageevent_modals_createticket.placeholder_price')
                                                ))  !!}


                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label('quantity_available', __('manageevent_modals_createticket.quantity'), array('class'=>' control-label')) !!}
                                    {!!  Form::text('quantity_available', Input::old('quantity_available'),
                                                array(
                                                'class'=>'form-control',
                                                'placeholder'=>'E.g: 100 (Leave blank for unlimited)'
                                                )
                                                )  !!}
                                </div>
                            </div>

                        </div>

                        <div class="form-group more-options">
                            {!! Form::label('description', __('manageevent_modals_createticket.description'), array('class'=>'control-label')) !!}
                            {!!  Form::text('description', Input::old('description'),
                                        array(
                                        'class'=>'form-control'
                                        ))  !!}
                        </div>

                        <div class="row more-options">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label('start_sale_date', __('manageevent_modals_createticket.start_sale'), array('class'=>' control-label')) !!}
                                    {!!  Form::text('start_sale_date', Input::old('start_sale_date'),
                                                    [
                                                'class'=>'form-control start hasDatepicker ',
                                                'data-field'=>'datetime',
                                                'data-startend'=>'start',
                                                'data-startendelem'=>'.end',
                                                'readonly'=>''

                                            ])  !!}
                                </div>
                            </div>

                            <div class="col-sm-6 ">
                                <div class="form-group">
                                    {!!  Form::label('end_sale_date', __('manageevent_modals_createticket.end_sale'),
                                                [
                                            'class'=>' control-label '
                                        ])  !!}
                                    {!!  Form::text('end_sale_date', Input::old('end_sale_date'),
                                            [
                                        'class'=>'form-control end hasDatepicker ',
                                        'data-field'=>'datetime',
                                        'data-startend'=>'end',
                                        'data-startendelem'=>'.start',
                                        'readonly'=>''
                                    ])  !!}
                                </div>
                            </div>
                        </div>

                        <div class="row more-options">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('min_per_person', __('manageevent_modals_createticket.minimum'), array('class'=>' control-label')) !!}
                                    {!! Form::selectRange('min_per_person', 1, 100, 1, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('max_per_person', __('manageevent_modals_createticket.maximum'), array('class'=>' control-label')) !!}
                                    {!! Form::selectRange('max_per_person', 1, 100, 30, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row more-options">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="custom-checkbox">
                                        {!! Form::checkbox('is_hidden', 1, false, ['id' => 'is_hidden']) !!}
                                        {!! Form::label('is_hidden', __('manageevent_modals_createticket.hide'), array('class'=>' control-label')) !!}
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-12">
                        <a href="javascript:void(0);" class="show-more-options">
                            @lang('manageevent_modals_createticket.more_options')
                        </a>
                    </div>

                </div>

            </div> <!-- /end modal body-->
            <div class="modal-footer">
               {!! Form::button(__('manageevent_modals_createticket.cancel'), ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
               {!! Form::submit(__('manageevent_modals_createticket.create'), ['class'=>"btn btn-success"]) !!}
            </div>
        </div><!-- /end modal content-->
       {!! Form::close() !!}
    </div>
</div>
