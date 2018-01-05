@if(!$event->is_live)
<section id="goLiveBar">
    <div class="container">
                @if(!$event->is_live)
                @lang('public_viewevent_partials_eventheadersection.visibility') - <a style="background-color: green; border-color: green;" class="btn btn-success btn-xs" href="{{route('MakeEventLive' , ['event_id' => $event->id])}}" >@lang('public_viewevent_partials_eventheadersection.publish_event')</a>
                @endif
    </div>
</section>
@endif
<section id="intro" class="content">
    <div class="container">
        <div class="col-md-9">
            <a href="{{route('showEventPagePreview', ['event_id'=>$event->id])}}"><h1 property="name">{{$event->title}}</h1></a>
            <div class="event_venue">
                <span property="location" typeof="Place">
                    {{$event->venue_name}}
                    <meta property="address" content="{{ urldecode($event->venue_name) }}">
                </span>
                //
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
            </div>
        </div>
    </div>
</section>
