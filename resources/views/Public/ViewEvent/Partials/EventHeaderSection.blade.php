@if(!$event->is_live)
<section id="goLiveBar">
    <div class="container">
                @if(!$event->is_live)
                This event is not visible to the public - <a style="background-color: green; border-color: green;" class="btn btn-success btn-xs" href="{{route('MakeEventLive' , ['event_id' => $event->id])}}" >Publish Event</a>
                @endif
    </div>
</section>
@endif
<section id="intro" class="content">
    <div class="container">
        <div class="col-md-3">
            <a title="{{$event->venue_name}}" href="{{$event->event_url}}"><img alt="{{$event->organiser->name}}" src="{{asset($event->organiser->full_logo_path)}}" property="logo"></a>
        </div>
        <div class="col-md-9">
            <h1 property="name">{{$event->title}}</h1>
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
