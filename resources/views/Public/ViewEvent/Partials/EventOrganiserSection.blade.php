<section id="organiser" class="content">
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="event_organiser_details" property="organizer" typeof="Organization">
                <p>
                    <button onclick="$(function(){ $('.contact_form').slideToggle(); });" type="button" class="btn btn-primary">
                        <i class="ico-envelop"></i>&nbsp; @lang('public_viewevent_partials_eventorganisersection.contact')
                    </button>
                </p>
                <div class="contact_form well well-sm">
                    {!! Form::open(array('url' => route('postContactOrganiser', array('event_id' => $event->id)), 'class' => 'reset ajax')) !!}
                    <h3>@lang('public_viewevent_partials_eventorganisersection.contact') <i>{{$event->organiser->name}}</i></h3>
                    <div class="form-group">
                        {!! Form::label(__('public_viewevent_partials_eventorganisersection.name')) !!}
                        {!! Form::text('name', null,
                            array('required',
                                  'class'=>'form-control',
                                  'placeholder'=>__('public_viewevent_partials_eventorganisersection.name'))) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label(__('public_viewevent_partials_eventorganisersection.email')) !!}
                        {!! Form::text('email', null,
                            array('required',
                                  'class'=>'form-control',
                                  'placeholder'=>__('public_viewevent_partials_eventorganisersection.email')
                            )
                        ) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label(__('message')) !!}
                        {!! Form::textarea('message', null,
                            array('required',
                                  'class'=>'form-control',
                                  'placeholder'=>__('public_viewevent_partials_eventorganisersection.message'))) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::submit(__('public_viewevent_partials_eventorganisersection.send'),
                          array('class'=>'btn btn-primary')) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
</section>

