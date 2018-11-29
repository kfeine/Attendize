@extends('Emails.Layouts.Master')

@section('message_content')
@lang('emails_orderconfirmation.hi')<br><br>

@lang('emails_orderconfirmation.message1', [
  'title' => '<b>'.$order->event->title.'</b>'
])
<br><br>

@lang('emails_orderconfirmation.message2', [
  'reference' => route('showOrderDetails', ['order_reference' => $order->order_reference])
])


<h3>@lang('emails_orderconfirmation.details')</h3>
@lang('emails_orderconfirmation.reference') <b>{{$order->order_reference}}</b><br>
@lang('emails_orderconfirmation.name') <b>{{$order->full_name}}</b><br>
@lang('emails_orderconfirmation.date') <b>{{$order->created_at->toDayDateTimeString()}}</b><br>
@lang('emails_orderconfirmation.email') <b>{{$order->email}}</b><br>

<h3>@lang('emails_orderconfirmation.items')</h3>
<div style="padding:10px; background: #F9F9F9; border: 1px solid #f1f1f1;">
    <table style="width:100%; margin:10px;">
        <tr>
            <td>
                <b>@lang('emails_orderconfirmation.ticket')</b>
            </td>
            <td>
                <b>@lang('emails_orderconfirmation.total')</b>
            </td>
        </tr>
        @foreach($order->orderItems as $order_item)
        <tr>
            <td>
                {{$order_item->title}}
            </td>
            <td>
                @if((int)ceil($order_item->unit_price) == 0)
                -
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
                <b>@lang('emails_orderconfirmation.subtotal')</b>
            </td>
            <td>
               {{money($order->amount + $order->order_fee, $order->event->currency)}}
            </td>
        </tr>
    </table>

    <br><br>
</div>
<br><br>
@lang('emails_orderconfirmation.thanks')<br><br>

<i>@lang('emails_common.privacypolicy')</i><br>
@stop
