<div class="panel panel-success event">
    <div class="panel-heading" data-style="background-color: {{{$event->bg_color}}};background-image: url({{{$event->bg_image_url}}}); background-size: cover;">
        <div class="event-date">
            <div class="month">
                {{strtoupper($event->start_date->format('M'))}}
            </div>
            <div class="day">
                {{$event->start_date->format('d')}}
            </div>
        </div>
        <ul class="event-meta">
            <li class="event-title">
                <a title="{{{$event->title}}}" href="{{route('showEventDashboard', ['event_id'=>$event->id])}}">
                    {{{ str_limit($event->title, $limit = 75, $end = '...') }}}
                </a>
            </li>
            <li class="event-organiser">
                @lang('manageorganiser_partials_eventpanel.by') <a href='{{route('showOrganiserDashboard', ['organiser_id' => $event->organiser->id])}}'>{{{$event->organiser->name}}}</a>
            </li>
        </ul>

    </div>

    <div class="panel-body">
        <ul class="nav nav-section nav-justified mt5 mb5">
            <li>
                <div class="section">
                    <h4 class="nm">{{$event->tickets->sum('quantity_sold')}}</h4>
                    <p class="nm text-muted">@lang('manageorganiser_partials_eventpanel.tickets_sold')</p>
                </div>
            </li>

            <li>
                <div class="section">
                    <h4 class="nm">{{{money($event->sales_volume + $event->organiser_fees_volume, $event->currency)}}}</h4>
                    <p class="nm text-muted">@lang('manageorganiser_partials_eventpanel.revenue')</p>
                </div>
            </li>
        </ul>
    </div>
    <div class="panel-footer">
        <ul class="nav nav-section nav-justified">
            <li>
                <a href="{{route('showEventCustomize', ['event_id' => $event->id])}}">
                    <i class="ico-edit"></i> @lang('manageorganiser_partials_eventpanel.edit')
                </a>
            </li>

            <li>
                <a href="{{route('showEventDashboard', ['event_id' => $event->id])}}">
                    <i class="ico-cog"></i> @lang('manageorganiser_partials_eventpanel.manage')
                </a>
            </li>
        </ul>
    </div>
</div>
