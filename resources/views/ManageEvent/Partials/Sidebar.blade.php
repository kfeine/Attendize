<aside class="sidebar sidebar-left sidebar-menu">
    <section class="content">
        <h5 class="heading">@lang('manageevent_partials_sidebar.main_menu')</h5>
        <ul id="nav_main" class="topmenu">
            <li>
                <a href="{{route('showOrganiserDashboard', ['organiser_id' => $event->organiser->id])}}">
                    <span class="figure"><i class="ico-arrow-left"></i></span>
                    <span class="text">@lang('manageevent_partials_sidebar.back', ['organiser' => $event->organiser->name])</span>
                </a>
            </li>
        </ul>
        <h5 class="heading">@lang('manageevent_partials_sidebar.event_menu')</h5>
        <ul id="nav_event" class="topmenu">
            <li class="{{ Request::is('*dashboard*') ? 'active' : '' }}">
                <a href="{{route('showEventDashboard', array('event_id' => $event->id))}}">
                    <span class="figure"><i class="ico-home2"></i></span>
                    <span class="text">@lang('manageevent_partials_sidebar.dashboard')</span>
                </a>
            </li>
            <li class="{{ Request::is('*tickets*') ? 'active' : '' }}">
                <a href="{{route('showEventTickets', array('event_id' => $event->id))}}">
                    <span class="figure"><i class="ico-ticket"></i></span>
                    <span class="text">@lang('manageevent_partials_sidebar.tickets')</span>
                </a>
            </li>
            <li class="{{ Request::is('*options_generic*') ? 'active' : '' }}">
                <a href="{{route('options_generic.index', array('event_id' => $event->id))}}">
                    <span class="figure"><i class="ico-ticket"></i></span>
                    <span class="text">@lang('manageevent_partials_sidebar.options_generic')</span>
                </a>
            </li>
            <li class="{{ Request::is('*orders*') ? 'active' : '' }}">
                <a href="{{route('showEventOrders', array('event_id' => $event->id))}}">
                    <span class="figure"><i class="ico-cart"></i></span>
                    <span class="text">@lang('manageevent_partials_sidebar.orders')</span>
                </a>
            </li>
            <li class="{{ Request::is('*attendees*') ? 'active' : '' }}">
                <a href="{{route('showEventAttendees', array('event_id' => $event->id))}}">
                    <span class="figure"><i class="ico-user"></i></span>
                    <span class="text">@lang('manageevent_partials_sidebar.attendees')</span>
                </a>
            </li>
            <li class="{{ Request::is('*promote*') ? 'active' : '' }} hide">
                <a href="{{route('showEventPromote', array('event_id' => $event->id))}}">
                    <span class="figure"><i class="ico-bullhorn"></i></span>
                    <span class="text">@lang('manageevent_partials_sidebar.promote')</span>
                </a>
            </li>
            <li class="{{ Request::is('*customize*') ? 'active' : '' }}">
                <a href="{{route('showEventCustomize', array('event_id' => $event->id))}}">
                    <span class="figure"><i class="ico-cog"></i></span>
                    <span class="text">@lang('manageevent_partials_sidebar.customize')</span>
                </a>
            </li>
        </ul>
        <h5 class="heading">@lang('manageevent_partials_sidebar.event_tools')</h5>
        <ul id="nav_event" class="topmenu">
            <li class="{{ Request::is('*check_in*') ? 'active' : '' }}">
                <a href="{{route('showChechIn', array('event_id' => $event->id))}}">
                    <span class="figure"><i class="ico-checkbox-checked"></i></span>
                    <span class="text">@lang('manageevent_partials_sidebar.checkin')</span>
                </a>
            </li>
            <li class="{{ Request::is('*discounts*') ? 'active' : '' }}">
                <a href="{{route('showEventDiscounts', array('event_id' => $event->id))}}">
                    <span class="figure"><i class="ico-gift"></i></span>
                    <span class="text">@lang('manageevent_partials_sidebar.discounts')</span>
                </a>
            </li>
            <li class="{{ Request::is('*surveys*') ? 'active' : '' }}">
                <a href="{{route('showEventSurveys', array('event_id' => $event->id))}}">
                    <span class="figure"><i class="ico-question"></i></span>
                    <span class="text">@lang('manageevent_partials_sidebar.surveys')</span>
                </a>
            </li>
            <li class="{{ Request::is('*widgets*') ? 'active' : '' }}">
                <a href="{{route('showEventWidgets', array('event_id' => $event->id))}}">
                    <span class="figure"><i class="ico-code"></i></span>
                    <span class="text">@lang('manageevent_partials_sidebar.widgets')</span>
                </a>
            </li>
    </section>
</aside>
