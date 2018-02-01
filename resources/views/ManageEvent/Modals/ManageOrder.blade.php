<div role="dialog"  class="modal fade" style="display: none;">
    <style>
        .well.nopad {
            padding: 0px;
        }
    </style>

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">
                    <i class="ico-cart"></i>
                    @lang('manageevent_modals_manageorder.order') <b>{{$order->order_reference}}</b></h3>
            </div>
            <div class="modal-body">

                @if($order->is_refunded || $order->is_partially_refunded)
                 <div class="alert alert-info">
                   @lang('manageevent_modals_manageorder.refunded', ['refunded' => money($order->amount_refunded, $order->event->currency)])
                </div>
                @endif

                @if(!$order->is_payment_received)
                    <div class="alert alert-danger">
                        @lang('manageevent_modals_manageorder.awaiting_payment')
                    </div>
                    <a data-id="{{ $order->id }}" data-route="{{ route('postMarkPaymentReceived', ['order_id' => $order->id]) }}" class="btn btn-success btn-sm markPaymentReceived" href="javascript:void(0);">@lang('manageevent_modals_manageorder.mark_payment_received')</a>
                @else
                    <div class="alert alert-success">
                        @lang('manageevent_modals_manageorder.payment_received')
                    </div>
                    <a data-id="{{ $order->id }}" data-route="{{ route('postMarkPaymentNotReceived', ['order_id' => $order->id]) }}" class="btn btn-danger btn-sm markPaymentNotReceived" href="javascript:void(0);">@lang('manageevent_modals_manageorder.mark_payment_not_received')</a>
                @endif
                <a href="javascript:void(0);" data-modal-id="cancel-order-{{ $order->id }}" data-href="{{ route('showCancelOrder', ['order_id'=>$order->id]) }}" title="Cancel Order" class="btn btn-sm btn-danger loadModal">@lang('manageevent_modals_manageorder.refund')</a>

                <h3>@lang('manageevent_modals_manageorder.overview')</h3>
                <style>
                    .order_overview b {
                        text-transform: uppercase;
                    }
                    .order_overview .col-sm-4 {
                        margin-bottom: 10px;
                    }
                </style>
                <div class="p0 well bgcolor-white order_overview">
                    <div class="row">
                        <div class="col-sm-6 col-xs-6">
                            <b>@lang('manageevent_modals_manageorder.firstname')</b><br> {{$order->first_name}}
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <b>@lang('manageevent_modals_manageorder.lastname')</b><br> {{$order->last_name}}
                        </div>

                        <div class="col-sm-6 col-xs-6">
                            <b>@lang('manageevent_modals_manageorder.amount')</b><br>{{money($order->total_amount, $order->event->currency)}}
                        </div>

                        <div class="col-sm-6 col-xs-6">
                            <b>@lang('manageevent_modals_manageorder.reference')</b><br> {{$order->order_reference}}
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <b>@lang('manageevent_modals_manageorder.date')</b><br> {{$order->created_at->toDateTimeString()}}
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <b>@lang('manageevent_modals_manageorder.email')</b><br> {{$order->email}}
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <b>@lang('manageevent_modals_manageorder.address1')</b><br> {{$order->address1}}
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <b>@lang('manageevent_modals_manageorder.address2')</b><br> {{$order->address2}}
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <b>@lang('manageevent_modals_manageorder.city')</b><br> {{$order->city}}
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <b>@lang('manageevent_modals_manageorder.postcode')</b><br> {{$order->postal_code}}
                        </div>

                        @if($order->transaction_id)
                        <div class="col-sm-6 col-xs-6">
                            <b>@lang('manageevent_modals_manageorder.id')</b><br> {{$order->transaction_id}}
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <b>@lang('manageevent_modals_manageorder.gateway')</b><br> <a href="{{ $order->payment_gateway->provider_url }}" target="_blank">{{$order->payment_gateway->provider_name}}</a>
                        </div>
                        @endif

                    </div>
                </div>

                <h3>@lang('manageevent_modals_manageorder.items')</h3>
                <div class="well nopad bgcolor-white p0">
                    <div class="table-responsive">
                        <table class="table table-hover" >
                            <thead>
                            <th>
                                @lang('manageevent_modals_manageorder.ticket')
                            </th>
                            <th>
                                @lang('manageevent_modals_manageorder.quantity')
                            </th>
                            <th>
                                @lang('manageevent_modals_manageorder.price')
                            </th>
                            <th>
                                @lang('manageevent_modals_manageorder.fee')
                            </th>
                            <th>
                                @lang('manageevent_modals_manageorder.total')
                            </th>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $order_item)
                                <tr>
                                    <td>
                                        <strong>{{$order_item->title}}</strong>
                                    </td>
                                    <td>
                                        {{$order_item->quantity}}
                                    </td>
                                    <td>
                                        @if((int)ceil($order_item->unit_price) == 0)
                                        -
                                        @else
                                       {{money($order_item->unit_price, $order->event->currency)}}
                                        @endif

                                    </td>
                                    <td>
                                        @if((int)ceil($order_item->unit_price) == 0)
                                        -
                                        @else
                                        {{money($order_item->unit_booking_fee, $order->event->currency)}}
                                        @endif

                                    </td>
                                    <td>
                                        @if((int)ceil($order_item->unit_price) == 0)
                                        -
                                        @else
                                        {{money(($order_item->unit_price + $order_item->unit_booking_fee) * ($order_item->quantity), $order->event->currency)}}
                                        @endif

                                    </td>
                                </tr>
                                @foreach($order_item->orderItemOptions as $option)
                                    <tr>
                                        <td>
                                           + {{$option->title}}
                                        </td>
                                        <td>
                                            @if((int)ceil($option->price) == 0)
                                            -
                                            @else
                                            {{money($option->price, $order->event->currency)}}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                @endforeach
                                @if($order->discount)
                                <tr>
                                    <td>
                                        {{$order->discount->title}}
                                    </td>
                                    <td>
                                        1
                                    </td>
                                    <td>
                                        @if($order->discount->type == "amount")
                                        {{ money($order->discount->price, $order->event->currency) }}
                                        @else
                                        {{ $order->discount->price }} %
                                        @endif
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                        @if($order->discount->type == "amount")
                                        {{ money($order->discount->price, $order->event->currency) }}
                                        @else
                                        {{ $order->discount->price }} %
                                        @endif
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td>
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                        <b>@lang('manageevent_modals_manageorder.subtotal')</b>
                                    </td>
                                    <td colspan="2">
                                        {{money($order->total_amount, $order->event->currency)}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>

                <h3>
                    @lang('manageevent_modals_manageorder.attendees')
                </h3>
                <div class="well nopad bgcolor-white p0">

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tbody>
                                @foreach($order->attendees as $attendee)
                                <tr>
                                    <td>
                                        @if($attendee->is_cancelled)
                                        <span class="label label-warning">
                                            @lang('manageevent_modals_manageorder.cancelled')
                                        </span>
                                        @endif
                                        @if($attendee->is_refunded)
                                            <span class="label label-danger">
                                                @lang('manageevent_modals_manageorder.refunded')
                                            </span>
                                        @endif
                                        {{$attendee->first_name}}
                                        {{$attendee->last_name}}
                                    </td>
                                    <td>
                                        {{$attendee->email}}
                                    </td>
                                    <td>
                                        {{{$attendee->ticket->title}}}
                                        {{{$order->order_reference}}}-{{{$attendee->reference_index}}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- /end modal body-->

            <div class="modal-footer">
                <a href="javascript:void(0);" data-modal-id="edit-order-{{ $order->id }}" data-href="{{route('showEditOrder', ['order_id'=>$order->id])}}" title="Edit Order" class="btn btn-info loadModal">
                    @lang('manageevent_modals_manageorder.edit')
                </a>
                <a class="btn btn-primary" target="_blank" href="{{route('showOrderTickets', ['order_reference' => $order->order_reference])}}?download=1">@lang('manageevent_modals_manageorder.print')</a>
                <span class="pauseTicketSales btn btn-success" data-id="{{$order->id}}" data-route="{{route('resendOrder', ['order_id'=>$order->id])}}">@lang('manageevent_modals_manageorder.resend')</span>
               {!! Form::button(__('manageevent_modals_manageorder.close'), ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
            </div>
        </div><!-- /end modal content-->
    </div>
</div>
