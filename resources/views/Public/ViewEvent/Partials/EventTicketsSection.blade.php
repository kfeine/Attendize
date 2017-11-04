<section id="tickets" class="container">
    <div class="row">
        <h1 class='section_head'>
            @lang('public_viewevent_partials_eventticketssection.title')
        </h1>
    </div>

    @if($event->start_date->isPast())
        <div class="alert alert-boring">
             {{($event->end_date->isFuture() ? __('public_viewevent_partials_eventticketssection.has_started') : __('public_viewevent_partials_eventticketssection.has_ended'))}}.
        </div>
    @else

        @if($tickets->count() > 0)

            {!! Form::open(['url' => route('postValidateTickets', ['event_id' => $event->id]), 'class' => 'ajax']) !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <div class="tickets_table_wrap">
                            <table class="table">
                                <?php
                                $is_free_event = true;
                                ?>
                                @foreach($tickets as $ticket)
                                    <tr class="ticket" property="offers" typeof="Offer">
                                        <td>
                                            <span class="ticket-title semibold" property="name">
                                                {{$ticket->title}}
                                            </span>
                                            <p class="ticket-descripton mb0 text-muted" property="description">
                                                {{$ticket->description}}
                                            </p>
                                        </td>
                                        <td style="width:180px; text-align: right;">
                                            <div class="ticket-pricing" style="margin-right: 20px;">
                                                @if($ticket->is_free)
                                                    @lang('public_viewevent_partials_eventticketssection.free')
                                                    <meta property="price" content="0">
                                                @else
                                                    <?php
                                                    $is_free_event = false;
                                                    ?>
                                                    <span title='{{money($ticket->price, $event->currency)}} Ticket Price + {{money($ticket->total_booking_fee, $event->currency)}} Booking Fees'>{{money($ticket->total_price, $event->currency)}} </span>
                                                    <meta property="priceCurrency"
                                                          content="{{ $event->currency->code }}">
                                                    <meta property="price"
                                                          content="{{ number_format($ticket->price, 2, '.', '') }}">
                                                @endif
                                            </div>
                                        </td>
                                        <td style="width:85px;">
                                            @if($ticket->is_paused)

                                                <span class="text-danger">
                                                   @lang('public_viewevent_partials_eventticketssection.not_sale') 
                                                </span>

                                            @else

                                                @if($ticket->sale_status === config('attendize.ticket_status_sold_out'))
                                                    <span class="text-danger" property="availability"
                                                          content="http://schema.org/SoldOut">
                                                       @lang('public_viewevent_partials_eventticketssection.sold_out') 
                                                    </span>
                                                @elseif($ticket->sale_status === config('attendize.ticket_status_before_sale_date'))
                                                    <span class="text-danger">
                                                       @lang('public_viewevent_partials_eventticketssection.not_started') 
                                                    </span>
                                                @elseif($ticket->sale_status === config('attendize.ticket_status_after_sale_date'))
                                                    <span class="text-danger">
                                                       @lang('public_viewevent_partials_eventticketssection.ended') 
                                                    </span>
                                                @else
                                                    {!! Form::hidden('tickets[]', $ticket->id) !!}
                                                    <meta property="availability" content="http://schema.org/InStock">
                                                    <select name="ticket_{{$ticket->id}}" class="form-control"
                                                            style="text-align: center">
                                                        @if ($tickets->count() > 1)
                                                            <option value="0">0</option>
                                                        @endif
                                                        @for($i=$ticket->min_per_person; $i<=$ticket->max_per_person; $i++)
                                                            <option value="{{$i}}">{{$i}}</option>
                                                        @endfor
                                                    </select>
                                                @endif

                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                                <tr class="discout-cocode">
                                        <td>
                                            <span class="ticket-title semibold" property="name">
                                                @lang('public_viewevent_partials_eventticketssection.discount')
                                            </span>
                                            <p class="ticket-descripton mb0 text-muted" property="description">
                                                @lang('public_viewevent_partials_eventticketssection.discount_description')
                                            </p>
                                        </td>
                                        <td style="width:180px; text-align: right;">
                                            <div class="ticket-pricing" style="margin-right: 20px;">
                                            </div>
                                        </td>
                                        <td style="width:85px;">
                                            {!! Form::hidden('discount-code', '') !!}
                                            <input type="text" name="discount-code" style="text-align: center" class="form-control">
                                        </td>
                                </tr>

                                <tr class="checkout">
                                    <td colspan="3">
                                        @if(!$is_free_event)
                                            <div class="hidden-xs pull-left">
                                                <img class=""
                                                     src="{{asset('assets/images/public/EventPage/credit-card-logos.png')}}"/>
                                                @if($event->enable_offline_payments)

                                                    <div class="help-block" style="font-size: 11px;">
                                                       @lang('public_viewevent_partials_eventticketssection.offline') 
                                                    </div>
                                                @endif

                                            </div>

                                        @endif
                                        {!!Form::submit(__('public_viewevent_partials_eventticketssection.register'), ['class' => 'btn btn-lg btn-primary pull-right'])!!}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::hidden('is_embedded', $is_embedded) !!}
            {!! Form::close() !!}

        @else

            <div class="alert alert-boring">
               @lang('public_viewevent_partials_eventticketssection.unavailable') 
            </div>

        @endif

    @endif

</section>
