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
                            <h3>@lang('public_viewevent_partials_eventticketssection.attendee') 1</h3>
                        </div>
                        <!-- start modal body -->
                        <div class="modal-body">
                            <div class="form-group">
                                {{ Form::label('Formule', null, ['class' => "control-label"]) }}
                                {{ Form::select('attendee_1_ticket', $tickets->pluck('title_with_price', 'id')->all(), null, ['class' => "form-control", 'onChange' => 'changeTicket(this, 1)']) }}
                                @foreach ($tickets as $ticket)
                                    <small class="ticket-options ticket-options-{{$ticket->id}} hide form-text">{{$ticket->description}}</small>
                                @endforeach
                            </div>
                            <div class="p0 well bgcolor-white order_overview">
                                <h5>@lang('public_viewevent_partials_eventticketssection.options')</h5>
                                <hr/>
                                @include('Public.ViewEvent.Partials.TicketOptions', ['tickets' => $tickets, 'numAttendee' => 1])
                            </div>
                        </div>
                        <!-- end modal body -->
                    </div>
                </div>
            </div>
            <input id="add-attendee-button" class="btn btn-success" onClick="addAttendee()" value="@lang('public_viewevent_partials_eventticketssection.add_attendee')">
            {!! Form::submit(__('public_viewevent_partials_eventticketssection.register'), ['class' => 'btn btn-lg btn-primary pull-right', 'id' => 'checkout-button']) !!}
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
                                {{ Form::label('attendee_`+number+`_ticket', "Formule", ['class' => "control-label"]) }}
                                {{ Form::select('attendee_`+number+`_ticket', $tickets->pluck('title_with_price', 'id')->all(), null, ['class' => "form-control", 'onChange' => 'changeTicket(this, `+number+`)']) }}
                                @foreach ($tickets as $ticket)
                                    <small class="ticket-options ticket-options-{{$ticket->id}} hide form-text">{{$ticket->description}}</small>
                                @endforeach
                            </div>
                            <div class="p0 well bgcolor-white order_overview">
                                <h5>@lang('public_viewevent_partials_eventticketssection.options')</h5>
                                <hr/>
                                @include('Public.ViewEvent.Partials.TicketOptions', ['tickets' => $tickets, 'numAttendee' => "`+number+`"])
                            </div>
                        </div>
                        <!-- end modal body -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" onClick="removeAttendee(`+number+`)">Supprimer le participant</button>
                        </div>
                    </div>`; 
  }
</script>
