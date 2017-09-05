<div id="QuestionForm" role="dialog" class="modal fade" style="display: none;">
    {!!  Form::open(['url' => route('postCreateEventDiscountCode', ['event_id'=>$event->id]), 'id' => 'edit-discount-code-form', 'class' => 'ajax']) !!}

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">
                    <i class="ico-question"></i>
                    Create discount code</h3>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="discount-code-title" class="required">
                        Name
                    </label>
                    {!! Form::text('title', '', [
                        'id' => 'discount-code-title',
                        'class' => 'form-control',
                        'placeholder' => 'e.g. VIP reduction',
                    ]) !!}
                </div>
                <div class="form-group">
                    <label for="discount-code">
                        Code
                    </label>
                    {!! Form::text('code', '', [
                        'id' => 'discount-code-code',
                        'class' => 'form-control',
                        'placeholder' => 'e.g. ABCD1234',
                    ]) !!}
                </div>
                <div class="form-group">
                    <label for="price">
                        Price
                    </label>
                    {!! Form::text('price', '', [
                        'id' => 'discount-code-price',
                        'class' => 'form-control',
                        'placeholder' => 'e.g. -12.3',
                    ]) !!}
                </div>
            </div> <!-- /end modal body-->

            <div class="modal-footer">
                {!! Form::button('Cancel', ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
                {!! Form::submit('Save Discount Code', ['class'=>"btn btn-success"]) !!}
            </div>
        </div><!-- /end modal content-->
    </div>
    {!! Form::close() !!}
</div>
