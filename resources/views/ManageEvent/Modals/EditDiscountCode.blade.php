<div role="dialog" class="modal fade" style="display: none;">
    {!!  Form::model($discount_code, ['url' => route('postEditEventDiscountCode', ['event_id' => $event->id, 'discount_code_id' => $discount_code->id]), 'id' => 'edit-discount-code-form', 'class' => 'ajax']) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">
                    <i class="ico-discount_code"></i>
                    Edit Discount Code</h3>
            </div>
            <div class="modal-body">
                        <div class="form-group">
                            <label for="discount-code-title" class="required">
                                Title
                            </label>
                            {!! Form::text('title', $discount_code->title, [
                                'id' => 'discount-code-title',
                                'class' => 'form-control',
                                'placeholder' => 'e.g.: VIP discount',
                            ]) !!}
                        </div>

                        <div class="form-group">
                            <label for="discount-code-code" class="required">
                                Code
                            </label>
                            {!! Form::text('code', $discount_code->code, [
                                'id' => 'discount-code-code',
                                'class' => 'form-control',
                                'placeholder' => 'e.g.: ABCD1234',
                            ]) !!}
                        </div>

                        <div class="form-group">
                            <label for="discount-code-price" class="required">
                                Price
                            </label>
                            {!! Form::text('price', $discount_code->price, [
                                'id' => 'discount-code-price',
                                'class' => 'form-control',
                                'placeholder' => 'e.g.: -12',
                            ]) !!}
                        </div>
            </div> <!-- /end modal body-->
            <div class="modal-footer">
                {!! Form::button('Cancel', ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
                {!! Form::submit('Save discount code', ['class'=>"btn btn-success"]) !!}
            </div>
        </div><!-- /end modal content-->
    </div>
    {!! Form::close() !!}
</div>
