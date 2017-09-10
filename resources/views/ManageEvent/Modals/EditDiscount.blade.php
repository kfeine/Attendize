<div role="dialog" class="modal fade" style="display: none;">
    {!!  Form::model($discount, ['url' => route('postEditEventDiscount', ['event_id' => $event->id, 'discount_id' => $discount->id]), 'id' => 'edit-discount-form', 'class' => 'ajax']) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">
                    <i class="ico-discount"></i>
                    Edit Discount</h3>
            </div>
            <div class="modal-body">
                        <div class="form-group">
                            <label for="discount-title" class="required">
                                Title
                            </label>
                            {!! Form::text('title', $discount->title, [
                                'id' => 'discount-title',
                                'class' => 'form-control',
                                'placeholder' => 'e.g.: VIP discount',
                            ]) !!}
                        </div>

                        <div class="form-group">
                            <label for="discount-code" class="required">
                                Code
                            </label>
                            {!! Form::text('code', $discount->code, [
                                'id' => 'discount-code',
                                'class' => 'form-control',
                                'placeholder' => 'e.g.: ABCD1234',
                            ]) !!}
                        </div>

                        <div class="form-group">
                            <label for="discount-price" class="required">
                                Price
                            </label>
                            {!! Form::text('price', $discount->price, [
                                'id' => 'discount-price',
                                'class' => 'form-control',
                                'placeholder' => 'e.g.: -12',
                            ]) !!}
                        </div>
            </div> <!-- /end modal body-->
            <div class="modal-footer">
                {!! Form::button('Cancel', ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
                {!! Form::submit('Save discount', ['class'=>"btn btn-success"]) !!}
            </div>
        </div><!-- /end modal content-->
    </div>
    {!! Form::close() !!}
</div>
