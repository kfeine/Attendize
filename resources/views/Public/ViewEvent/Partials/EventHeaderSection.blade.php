@if(!$event->is_live)
<section id="goLiveBar">
    <div class="container">
                @if(!$event->is_live)
                @lang('public_viewevent_partials_eventheadersection.visibility') - <a style="background-color: green; border-color: green;" class="btn btn-success btn-xs" href="{{route('MakeEventLive' , ['event_id' => $event->id])}}" >@lang('public_viewevent_partials_eventheadersection.publish_event')</a>
                @endif
    </div>
</section>
@endif
<section id="organiserHead" class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div onclick="window.location='{{$event->event_url}}#organiser'" class="event_organizer">
                    <b>{{$event->organiser->name}}</b> @lang('public_viewevent_partials_eventheadersection.presents')
                </div>
            </div>
        </div>
    </div>
</section>
<section id="intro" class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 property="name">{{$event->title}}</h1>
            <div class="event_venue">
                <span property="startDate" content="{{ $event->start_date->toIso8601String() }}">
                    @if($event->start_date->month == $event->end_date->month) 
                        {{ $event->start_date->formatLocalized('%d') }} 
                    @else 
                        {{ $event->start_date->formatLocalized('%A %d %B %Y') }} 
                    @endif 
                </span>
                -
                <span property="endDate" content="{{ $event->end_date->toIso8601String() }}">
                     {{ $event->end_date->formatLocalized('%d %B %Y') }}
                </span>
                @
                <span property="location" typeof="Place">
                    <b property="name">{{$event->venue_name}}</b>
                    <meta property="address" content="{{ urldecode($event->venue_name) }}">
                </span>
            </div>

            <div class="event_buttons">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <a class="btn btn-event-link btn-lg" href="{{{$event->event_url}}}#tickets">@lang('public_viewevent_partials_eventheadersection.tickets')</a>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <a class="btn btn-event-link btn-lg" href="{{{$event->event_url}}}#details">@lang('public_viewevent_partials_eventheadersection.details')</a>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <a class="btn btn-event-link btn-lg" href="{{{$event->event_url}}}#location">@lang('public_viewevent_partials_eventheadersection.location')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
