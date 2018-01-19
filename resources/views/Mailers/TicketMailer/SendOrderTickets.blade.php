@extends('Emails.Layouts.Master')

@section('message_content')
@lang('mailers_ticketmailer_sendordertickets.hi')<br><br>


@lang('mailers_ticketmailer_sendordertickets.order', ['title' => '<b>'.$order->event->title.'</b>']).<br><br>

@lang('mailers_ticketmailer_sendordertickets.tickets', ['reference' => route('showOrderDetails', ['order_reference' => $order->order_reference])])

@if(!$order->is_payment_received)
<br><br>
<b>@lang('mailers_ticketmailer_sendordertickets.note', ['reference' => route('showOrderDetails', ['order_reference' => $order->order_reference])])
</b>
<br><br>
@endif
<h3>@lang('mailers_ticketmailer_sendordertickets.details')</h3>
@lang('mailers_ticketmailer_sendordertickets.reference') <b>{{$order->order_reference}}</b><br>
@lang('mailers_ticketmailer_sendordertickets.name') <b>{{$order->full_name}}</b><br>
@lang('mailers_ticketmailer_sendordertickets.date') <b>{{$order->created_at->toDayDateTimeString()}}</b><br>
@lang('mailers_ticketmailer_sendordertickets.email') <b>{{$order->email}}</b><br>
<a href="{!! route('downloadCalendarIcs', ['event_id' => $order->event->id]) !!}">@lang('mailers_ticketmailer_sendordertickets.calendar')</a>
<h3>@lang('mailers_ticketmailer_sendordertickets.items')</h3>
<div style="padding:10px; background: #F9F9F9; border: 1px solid #f1f1f1;">
    <table style="width:100%; margin:10px;">
        <tr>
            <td>
                <b>@lang('mailers_ticketmailer_sendordertickets.ticket')</b>
            </td>
            <td>
            <td>
                <b>@lang('mailers_ticketmailer_sendordertickets.total')</b>
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
                <b>@lang('mailers_ticketmailer_sendordertickets.subtotal')</b>
            </td>
            <td>
               {{money($order->amount + $order->order_fee, $order->event->currency)}}
            </td>
        </tr>
    </table>

    <br><br>
</div>
<br><br>
@lang('mailers_ticketmailer_sendordertickets.thanks')
@stop
