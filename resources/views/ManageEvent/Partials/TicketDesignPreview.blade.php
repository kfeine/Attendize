{!! HTML::style(asset('assets/stylesheet/ticket.css')) !!}
<style>
    .ticket {
        border: 1px solid {{$event->ticket_border_color}};
        background: {{$event->ticket_bg_color}} ;
        color: {{$event->ticket_sub_text_color}};
        border-left-color: {{$event->ticket_border_color}} ;
    }
    .ticket h4 {color: {{$event->ticket_text_color}};}
    .ticket .logo {
        border-left: 1px solid {{$event->ticket_border_color}};
        border-bottom: 1px solid {{$event->ticket_border_color}};

    }
</style>
<div class="ticket">
    <div class="logo">
        {!! HTML::image(asset($image_path)) !!}
    </div>

    <div class="event_details">
        <h4>@lang('manageevent_partials_ticketdesignpreview.event')</h4>@lang('manageevent_partials_ticketdesignpreview.demo_event')<h4>@lang('manageevent_partials_ticketdesignpreview.organiser')</h4>@lang('manageevent_partials_ticketdesignpreview.demo_organiser')<h4>@lang('manageevent_partials_ticketdesignpreview.venue')</h4>@lang('manageevent_partials_ticketdesignpreview.demo_location')<h4>@lang('manageevent_partials_ticketdesignpreview.start_date')</h4>
        @lang('manageevent_partials_ticketdesignpreview.demo_start')
        <h4>@lang('manageevent_partials_ticketdesignpreview.end_date')</h4>
        @lang('manageevent_partials_ticketdesignpreview.demo_end')
    </div>

    <div class="attendee_details">
        <h4>@lang('manageevent_partials_ticketdesignpreview.name')</h4>@lang('manageevent_partials_ticketdesignpreview.demo_name')<h4>@lang('manageevent_partials_ticketdesignpreview.type')</h4>
        @lang('manageevent_partials_ticketdesignpreview.demo_type')
        <h4>@lang('manageevent_partials_ticketdesignpreview.order_ref')</h4>
        @lang('manageevent_partials_ticketdesignpreview.demo_order_ref')
        <h4>@lang('manageevent_partials_ticketdesignpreview.attendee_ref')</h4>
        @lang('manageevent_partials_ticketdesignpreview.demo_attendee_ref')
        <h4>@lang('manageevent_partials_ticketdesignpreview.price')</h4>
        @lang('manageevent_partials_ticketdesignpreview.demo_price')
    </div>

    <div class="barcode">
        {!! DNS2D::getBarcodeSVG('hello', "QRCODE", 6, 6) !!}
    </div>
    @if($event->is_1d_barcode_enabled)
        <div class="barcode_vertical">
            {!! DNS1D::getBarcodeSVG(12211221, "C39+", 1, 50) !!}
        </div>
    @endif
</div>
