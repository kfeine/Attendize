<div role="dialog"  class="modal fade" style="display: none;">
    <style>
        .well.nopad {
            padding: 0px;
        }
        .modal-body .row{
            margin-top:2rem;
        }
    </style>

    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(array('url' => route('postOrderEdit', array('order_id' => $order->id)), 'class' => 'ajax reset closeModalAfter')) !!}
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">
                    <i class="ico-cart"></i>
                    @lang('manageevent_modals_editorder.order') <b>{{$order->order_reference}}</b></h3>
            </div>

            <div class="modal-body">
                <h3>@lang('manageevent_modals_editorder.details')</h3>
                <div class="row">
                    <div class="col-xs-12">
                        <label for="first_name" class="form-control-label">@lang('manageevent_modals_editorder.firstname')</label>
                        <input type="text" name="first_name" class="form-control" value="{{ $order->first_name }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <label for="last_name" class="form-control-label">@lang('manageevent_modals_editorder.lastname')</label>
                        <input type="text" name="last_name" class="form-control" value="{{ $order->last_name }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <label for="email" class="form-control-label">@lang('manageevent_modals_editorder.email')</label>
                        <input type="text" name="email" class="form-control" value="{{ $order->email }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <label for="custom_field" class="form-control-label">@lang('manageevent_modals_editorder.custom_field')</label>
                        <textarea name="custom_field" class="form-control" rows="8">{{ $order->custom_field }}</textarea>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                {!! Form::button(__('manageevent_modals_editorder.close'), ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
                {!! Form::submit(__('manageevent_modals_editorder.update'), ['class'=>"btn btn-success"]) !!}
            </div>
            {!! Form::close() !!}
        </div><!-- /end modal content-->
    </div>
</div>
