<div role="dialog"  class="modal fade " style="display: none;">
    {!! Form::model($ticket, ['url' => route('postEditTicket', ['ticket_id' => $ticket->id, 'event_id' => $event->id]), 'class' => 'ajax']) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">
                    <i class="ico-ticket"></i>
                    @lang('manageevent_modals_editticket.edit') <em>{{$ticket->title}}</em></h3>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::label('title', __('manageevent_modals_editticket.title'), ['class'=>'control-label required']) !!}
                    {!!  Form::text('title', null,['class'=>'form-control', 'placeholder'=>__('manageevent_modals_editticket.placeholder_title')]) !!}
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('price', __('manageevent_modals_editticket.price'), ['class'=>'control-label required']) !!}
                            {!!  Form::text('price', null,['class' => 'form-control', 'placeholder' => __('manageevent_modals_editticket.placeholder_price')]) !!}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('quantity_available', __('manageevent_modals_editticket.quantity'), ['class'=>' control-label']) !!}
                            {!!  Form::text('quantity_available', null, ['class' => 'form-control', 'placeholder' => __('manageevent_modals_editticket.placeholder_quantity')]) !!}
                        </div>
                    </div>
                </div>

                <div class="form-group more-options">
                    {!! Form::label('description', __('manageevent_modals_editticket.description'), ['class'=>'control-label']) !!}
                    {!!  Form::text('description', null,['class'=>'form-control']) !!}
                </div>

                <div class="row more-options">
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('start_sale_date', __('manageevent_modals_editticket.start'), ['class'=>' control-label']) !!}

                            {!!  Form::text('start_sale_date', $ticket->getFormattedDate('start_sale_date'),
                                [
                                    'class' => 'form-control start hasDatepicker',
                                    'data-field' => 'datetime',
                                    'data-startend' => 'start',
                                    'data-startendelem' => '.end',
                                    'readonly' => ''
                                ]) !!}
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            {!!  Form::label('end_sale_date', __('manageevent_modals_editticket.end'),
                                        [
                                    'class'=>' control-label '
                                ])  !!}
                            {!!  Form::text('end_sale_date', $ticket->getFormattedDate('end_sale_date'),
                                [
                                    'class' => 'form-control end hasDatepicker',
                                    'data-field' => 'datetime',
                                    'data-startend' => 'end',
                                    'data-startendelem' => '.start',
                                    'readonly' => ''
                                ])  !!}
                        </div>
                    </div>
                </div>

                <div class="row more-options">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('min_per_person', __('manageevent_modals_editticket.minimum'), ['class'=>' control-label']) !!}
                           {!! Form::selectRange('min_per_person', 1, 100, null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('max_per_person', __('manageevent_modals_editticket.maximum'), ['class'=>' control-label']) !!}
                           {!! Form::selectRange('max_per_person', 1, 100, null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="row more-options">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="custom-checkbox">
                                {!! Form::checkbox('is_hidden', null, null, ['id' => 'is_hidden']) !!}
                                {!! Form::label('is_hidden', __('manageevent_modals_editticket.hide'), array('class'=>' control-label')) !!}
                            </div>

                        </div>
                    </div>
                </div>
                <a href="javascript:void(0);" class="show-more-options">
                    @lang('manageevent_modals_editticket.more_options')
                </a>
            </div> <!-- /end modal body-->
            <div class="modal-footer">
               {!! Form::button(__('manageevent_modals_editticket.close'), ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
                {!! Form::submit(__('manageevent_modals_editticket.save'), ['class'=>"btn btn-success"]) !!}
            </div>
        </div><!-- /end modal content-->
       {!! Form::close() !!}
    </div>
</div>
