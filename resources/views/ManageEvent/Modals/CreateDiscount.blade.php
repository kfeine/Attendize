<div id="QuestionForm" role="dialog" class="modal fade" style="display: none;">
    {!!  Form::open(['url' => route('postCreateEventDiscount', ['event_id'=>$event->id]), 'id' => 'edit-discount-form', 'class' => 'ajax']) !!}

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">
                    <i class="ico-gift"></i>
                    @lang('manageevent_modals_creatediscount.discount')</h3>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="discount-title" class="required">
                        @lang('manageevent_modals_creatediscount.name')
                    </label>
                    {!! Form::text('title', '', [
                        'id' => 'discount-title',
                        'class' => 'form-control',
                        'placeholder' => __('manageevent_modals_creatediscount.eg_reduction'),
                    ]) !!}
                </div>
                <div class="form-group">
                    <label for="discount">
                        @lang('manageevent_modals_creatediscount.code')
                    </label>
                    {!! Form::text('code', '', [
                        'id' => 'discount-code',
                        'class' => 'form-control',
                        'placeholder' => __('manageevent_modals_creatediscount.eg_code'),
                    ]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('quantity_available', __('manageevent_modals_creatediscount.quantity'), array('class'=>' control-label')) !!}
                    {!! Form::text('quantity_available', Input::old('quantity_available'),
                                array(
                                'class'=>'form-control',
                                'placeholder'=>'E.g: 100 (Leave blank for unlimited)'
                                )
                                ) !!}
                </div>
                <div class="form-group">
                    <label for="price">
                        @lang('manageevent_modals_creatediscount.price')
                    </label>
                    {!! Form::text('price', '', [
                        'id' => 'discount-price',
                        'class' => 'form-control',
                        'placeholder' => __('manageevent_modals_creatediscount.eg_price'),
                    ]) !!}
                </div>
            </div> <!-- /end modal body-->

            <div class="modal-footer">
                {!! Form::button(__('manageevent_modals_creatediscount.cancel'), ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
                {!! Form::submit(__('manageevent_modals_creatediscount.submit'), ['class'=>"btn btn-success"]) !!}
            </div>
        </div><!-- /end modal content-->
    </div>
    {!! Form::close() !!}
</div>
