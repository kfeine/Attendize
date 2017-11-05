<div role="dialog" class="modal fade" style="display: none;">
    {!!  Form::model($discount, ['url' => route('postEditEventDiscount', ['event_id' => $event->id, 'discount_id' => $discount->id]), 'id' => 'edit-discount-form', 'class' => 'ajax']) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">
                    <i class="ico-discount"></i>
                    @lang('manageevent_modals_editdiscount.edit')</h3>
            </div>
            <div class="modal-body">
                        <div class="form-group">
                            <label for="discount-title" class="required">
                                @lang('manageevent_modals_editdiscount.title')
                            </label>
                            {!! Form::text('title', $discount->title, [
                                'id' => 'discount-title',
                                'class' => 'form-control',
                                'placeholder' => __('manageevent_modals_editdiscount.placeholder_title'),
                            ]) !!}
                        </div>

                        <div class="form-group">
                            <label for="discount-code" class="required">
                                @lang('manageevent_modals_editdiscount.code')
                            </label>
                            {!! Form::text('code', $discount->code, [
                                'id' => 'discount-code',
                                'class' => 'form-control',
                                'placeholder' => __('manageevent_modals_editdiscount.placeholder_code'),
                            ]) !!}
                        </div>

                        <div class="form-group">
                            <label for="type" class="required">
                                @lang('manageevent_modals_creatediscount.type')
                            </label>
                            {!! Form::select('type', [
                                'amount'     => __('manageevent_modals_creatediscount.type_select_amount'),
                                'percentage' => __('manageevent_modals_creatediscount.type_select_percentage')
                            ],
                            $discount->type) !!}
                        </div>

                        <div class="form-group">
                            <label for="discount-price" class="required">
                                @lang('manageevent_modals_editdiscount.price')
                            </label>
                            {!! Form::text('price', $discount->price, [
                                'id' => 'discount-price',
                                'class' => 'form-control',
                                'placeholder' => __('manageevent_modals_editdiscount.placeholder_price'),
                            ]) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('quantity_available', __('manageevent_modals_editdiscount.quantity'), ['class'=>' control-label']) !!}
                            {!! Form::text('quantity_available', null, ['class' => 'form-control', 'placeholder' => __('manageevent_modals_editdiscount.placeholder_quantity')]) !!}
                        </div>
            </div> <!-- /end modal body-->
            <div class="modal-footer">
                {!! Form::button(__('manageevent_modals_editdiscount.cancel'), ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
                {!! Form::submit(__('manageevent_modals_editdiscount.save'), ['class'=>"btn btn-success"]) !!}
            </div>
        </div><!-- /end modal content-->
    </div>
    {!! Form::close() !!}
</div>
