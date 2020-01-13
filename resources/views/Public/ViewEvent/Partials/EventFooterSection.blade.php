<footer id="footer" class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                {{--Attendize is provided free of charge on the condition the below hyperlink is left in place.--}}
                {{--See https://www.attendize.com/licence.php for more information.--}}
                @include('Shared.Partials.PoweredBy')
                &bull;
                <a class="adminLink " href='/privacy/policy'>Politique de vie privée et de protection des données</a>

                @if(Utils::userOwns($event))
                &bull;
                <a class="adminLink " href="{{route('showEventDashboard' , ['event_id' => $event->id])}}">@lang('public_viewevent_partials_eventfootersection.dashboard_event')</a>
                &bull;
                <a class="adminLink "
                   href="{{route('showOrganiserDashboard' , ['organiser_id' => $event->organiser->id])}}">@lang('public_viewevent_partials_eventfootersection.dashboard_organiser')</a>
                @endif
            </div>
        </div>
    </div>
</footer>
{{--Admin Links--}}
