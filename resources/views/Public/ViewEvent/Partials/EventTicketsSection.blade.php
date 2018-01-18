<section id="tickets" class="content">
<div class="container">
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
                <div class="col-md-6 form_attendee" id="attendee1">
                    <div class="modal-content">
                        {!! Form::hidden('attendees[]', "1") !!}
                        <div class="modal-header text-center">
                            <h3>@lang('public_viewevent_partials_eventticketssection.attendee') 1</h3>
                        </div>
                        <!-- start modal body -->
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label("attendee_1_gender", __('public_viewevent_partials_eventticketssection.gender'), ['class' => "required"]) !!}
                                        {!! Form::select(
                                            "attendee_1_gender",
                                            array('M' => __('public_viewevent_partials_eventticketssection.gender_male'), 'W' => __('public_viewevent_partials_eventticketssection.gender_female')),
                                            null,
                                            ['required' => 'required', 'class' => "required attendee_1_gender attendee_gender form-control"]
                                        ) !!}
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        {!! Form::label("attendee_1_last_name", __('public_viewevent_partials_eventticketssection.last_name'), ['class' => "required"]) !!}
                                        {!! Form::text("attendee_1_last_name", null, ['required' => 'required', 'class' => "required attendee_1_last_name attendee_last_name form-control"]) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label("attendee_1_first_name", __('public_viewevent_partials_eventticketssection.first_name'), ['class' => "required"]) !!}
                                        {!! Form::text("attendee_1_first_name", null, ['required' => 'required', 'class' => "required attendee_1_first_name attendee_first_name form-control"]) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label("attendee_1_email", __('public_viewevent_partials_eventticketssection.email')) !!}
                                        {!! Form::text("attendee_1_email", null, ['class' => "attendee_1_email attendee_email form-control"]) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('attendee_1_ticket', 'Formule', null, ['class' => "control-label"]) }}
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

            <div class="row" id="discount">
                <div class="col-md-6">
                    <div class="col-md-6">
                        <span class="ticket-title semibold" property="name">
                            @lang('public_viewevent_partials_eventticketssection.discount')
                        </span>
                        <p class="ticket-descripton mb0 text-muted" property="description">
                            @lang('public_viewevent_partials_eventticketssection.discount_description')
                        </p>
                    </div>
                    <div class="col-md-6">
                        {!! Form::hidden('discount-code', '') !!}
                        <input type="text" name="discount-code" style="text-align: center" class="form-control">
                    </div>
                </div>
            </div>

            {!! Form::submit(__('public_viewevent_partials_eventticketssection.register'), ['class' => 'btn btn-lg btn-primary pull-right', 'id' => 'checkout-button']) !!}
            {!! Form::hidden('is_embedded', $is_embedded) !!}
            {!! Form::close() !!}

        @else

            <div class="alert alert-boring">
               @lang('public_viewevent_partials_eventticketssection.unavailable')
            </div>

        @endif

    @endif

</div>
</section>

<script>
  function getFormAttendeeTicket(number){

      return `<div class="col-md-6 form_attendee" id='attendee`+number+`'> <div class='modal-content'>
                        {!! Form::hidden('attendees[]', "`+number+`") !!}
                        <div class="modal-header text-center">
                            <h3>Participant `+number+`</h3>
                        </div>
                        <!-- start modal body -->
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label("attendee_`+number+`_gender", __('public_viewevent_partials_eventticketssection.gender'), ['class' => "required"]) !!}
                                        {!! Form::select(
                                            "attendee_`+number+`_gender",
                                            array('M' => __('public_viewevent_partials_eventticketssection.gender_male'), 'W' => __('public_viewevent_partials_eventticketssection.gender_female')),
                                            null,
                                            ['required' => 'required', 'class' => "required attendee_`+number+`_gender attendee_gender form-control"]
                                        ) !!}
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        {!! Form::label("attendee_`+number+`_last_name", __('public_viewevent_partials_eventticketssection.last_name'), ['class' => "required"]) !!}
                                        {!! Form::text("attendee_`+number+`_last_name", null, ['required' => 'required', 'class' => "required attendee_`+number+`_last_name attendee_last_name form-control"]) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label("attendee_`+number+`_first_name", __('public_viewevent_partials_eventticketssection.first_name'), ['class' => "required"]) !!}
                                        {!! Form::text("attendee_`+number+`_first_name", null, ['required' => 'required', 'class' => "required attendee_`+number+`_first_name attendee_first_name form-control"]) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label("attendee_`+number+`_email", __('public_viewevent_partials_eventticketssection.email')) !!}
                                        {!! Form::text("attendee_`+number+`_email", null, ['class' => "attendee_`+number+`_email attendee_email form-control"]) !!}
                                    </div>
                                </div>
                            </div>
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
