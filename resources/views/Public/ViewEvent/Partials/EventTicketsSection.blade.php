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
            <div class="row content-form">
                <div class="col-md-6" id="attendee1">
                    <div class="modal-content">
                        {!! Form::hidden('attendees[]', "1") !!}
                        <div class="modal-header text-center">
                            <h3>Participant 1</h3>
                        </div>
                        <!-- start modal body -->
                        <div class="modal-body">
                            <div class="form-group">
                                {{ Form::label('attendee_1_forfait', null, ['class' => "control-label"]) }}
                                {{ Form::select('attendee_1_forfait', $tickets->pluck('title_with_price', 'id')->all(), null, ['class' => "form-control", 'onChange' => 'changeTicket(this, 1)']) }}
                                @foreach ($tickets as $ticket)
                                    <small class="ticket-options ticket-options-{{$ticket->id}} hide form-text">{{$ticket->description}}</small>
                                @endforeach
                            </div> 
                            @foreach ($tickets as $ticket)
                                <div class="ticket-options ticket-options-{{$ticket->id}} hide form-group">
                                            <table>
                                                @foreach($ticket->options as $option)
                                                    <tr>
                                                        <td>
                                                            <span class="option-title semibold" property="name">
                                                                {{$option->title}}
                                                            </span>
                                                            <p class="option-descripton mb0 text-muted" property="description">
                                                                {{$option->description}}
                                                            </p>
                                                        </td>
                                                        <td style="width:180px; text-align: right;">
                                                            <div class="option-pricing" style="margin-right: 20px;">
                                                                @if($option->is_free)
                                                                    "__gratuit"
                                                                    <meta property="price" content="0">
                                                                @else
                                                                    <?php
                                                                    $is_free_event = false;
                                                                    ?>
                                                                    <span title='{{money($option->price, $event->currency)}} Option Price'>{{money($option->price, $event->currency)}} </span>
                                                                    <meta property="priceCurrency"
                                                                          content="{{ $event->currency->code }}">
                                                                    <meta property="price"
                                                                          content="{{ number_format($option->price, 2, '.', '') }}">
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td style="width:85px;">
                                                            @if(!$option->is_enabled)

                                                                <span class="text-danger">
                                                                   "__pas en vente" 
                                                                </span>

                                                            @else
                                                                {!! Form::hidden('attendee_1_options_'.$ticket->id.'[]', $option->id) !!}
                                                                {!! Form::checkbox('attendee_1_option_'.$ticket->id.'_'.$option->id, 1, null, ['id' => 'option_'.$ticket->id.'_'.$option->id]) !!}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </table>
                                </div>
                            @endforeach
                        </div>
                        <!-- end modal body -->
                    </div>
                </div>
            </div>
               <input class="btn btn-success" onClick="addAttendee()" value="Ajouter un participant">
            {!! Form::hidden('is_embedded', $is_embedded) !!}
            {!! Form::close() !!}

        @else

            <div class="alert alert-boring">
               @lang('public_viewevent_partials_eventticketssection.unavailable') 
            </div>

        @endif

    @endif

</section>

<script>
  function getFormAttendeeTicket(number){
                
      return `<div class="col-md-6" id='attendee`+number+`'> <div class='modal-content'>
                        {!! Form::hidden('attendees[]', "`+number+`") !!}
                        <div class="modal-header text-center">
                            <h3>Participant `+number+`</h3>
                        </div>
                        <!-- start modal body -->
                        <div class="modal-body">
                            <div class="form-group">
                                {{ Form::label('attendee_`+number+`_forfait', null, ['class' => "control-label"]) }}
                                {{ Form::select('attendee_`+number+`_forfait', $tickets->pluck('title_with_price', 'id')->all(), null, ['class' => "form-control", 'onChange' => 'changeTicket(this, `+number+`)']) }}
                                @foreach ($tickets as $ticket)
                                    <small class="ticket-options ticket-options-{{$ticket->id}} hide form-text">{{$ticket->description}}</small>
                                @endforeach
                            </div> 
                            @foreach ($tickets as $ticket)
                                <div class="ticket-options ticket-options-{{$ticket->id}} hide form-group">
                                            <table>
                                                @foreach($ticket->options as $option)
                                                    <tr>
                                                        <td>
                                                            <span class="option-title semibold" property="name">
                                                                {{$option->title}}
                                                            </span>
                                                            <p class="option-descripton mb0 text-muted" property="description">
                                                                {{$option->description}}
                                                            </p>
                                                        </td>
                                                        <td style="width:180px; text-align: right;">
                                                            <div class="option-pricing" style="margin-right: 20px;">
                                                                @if($option->is_free)
                                                                    "__gratuit"
                                                                    <meta property="price" content="0">
                                                                @else
                                                                    <?php
                                                                    $is_free_event = false;
                                                                    ?>
                                                                    <span title='{{money($option->price, $event->currency)}} Option Price'>{{money($option->price, $event->currency)}} </span>
                                                                    <meta property="priceCurrency"
                                                                          content="{{ $event->currency->code }}">
                                                                    <meta property="price"
                                                                          content="{{ number_format($option->price, 2, '.', '') }}">
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td style="width:85px;">
                                                            @if(!$option->is_enabled)

                                                                <span class="text-danger">
                                                                   "__pas en vente" 
                                                                </span>

                                                            @else
                                                                {!! Form::hidden('attendee_`+number+`_options_'.$ticket->id.'[]', $option->id) !!}
                                                                {!! Form::checkbox('attendee_`+number+`_option_'.$ticket->id.'_'.$option->id, 1, null, ['id' => 'option_'.$ticket->id.'_'.$option->id]) !!}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </table>
                                </div>
                            @endforeach
                        </div>
                        <!-- end modal body -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" onClick="removeAttendee(`+number+`)">Supprimer le participant</button>
                        </div>
                    </div>`; 
  }
</script>
