@extends('Emails.Layouts.Master')

@section('message_content')
@lang('emails_ordernotification.hi')<br><br>

@lang('emails_ordernotification.message1', ['title' => '<b>'.$order->event->title.'</b>'])<br><br>

@if(!$order->is_payment_received)
    <b>@lang('emails_ordernotification.not_received')</b>
    <br><br>
@endif


@lang('emails_ordernotification.summary')
<br><br>
@lang('emails_ordernotification.reference') <b>{{$order->order_reference}}</b><br>
@lang('emails_ordernotification.name') <b>{{$order->full_name}}</b><br>
@lang('emails_ordernotification.date') <b>{{$order->created_at->toDayDateTimeString()}}</b><br>
@lang('emails_ordernotification.email') <b>{{$order->email}}</b><br>


<h3>@lang('emails_ordernotification.items')</h3>
<div style="padding:10px; background: #F9F9F9; border: 1px solid #f1f1f1;">

    <table style="width:100%; margin:10px;">
        <tr>
            <th>
                @lang('emails_ordernotification.ticket')
            </th>
            <th>
                @lang('emails_ordernotification.quantity')
            </th>
            <th>
                @lang('emails_ordernotification.price')
            </th>
            <th>
                @lang('emails_ordernotification.booking')
            </th>
            <th>
                @lang('emails_ordernotification.total')
            </th>
        </tr>
        @foreach($order->orderItems as $order_item)
        <tr>
            <td>
                {{$order_item->title}}
            </td>
            <td>
                {{$order_item->quantity}}
            </td>
            <td>
                @if((int)ceil($order_item->unit_price) == 0)
                @lang('emails_ordernotification.free')
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
                @lang('emails_ordernotification.free')
                @else
                {{money(($order_item->unit_price + $order_item->unit_booking_fee) * ($order_item->quantity), $order->event->currency)}}
                @endif

            </td>
        </tr>
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
                <b>@lang('emails_ordernotification.subtotal')</b>
            </td>
            <td colspan="2">
                {{money($order->total_amount, $order->event->currency)}}
            </td>
        </tr>
    </table>


    <br><br>
    @lang('emails_ordernotification.message2', ['at' => route('showEventOrders', ['event_id' => $order->event->id, 'q'=>$order->order_reference])])
    <br><br>
</div>
<br><br>
@lang('emails_ordernotification.thanks')
@stop
