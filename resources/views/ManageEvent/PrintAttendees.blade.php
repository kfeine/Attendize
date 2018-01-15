<html>
    <head>
        <title>
            @lang('manageevent_printattendees.title')
        </title>

        <!--Style-->
       {!!HTML::style('assets/stylesheet/application.css')!!}
        <!--/Style-->

        <style type="text/css">
            .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
                padding: 3px;
            }
            table {
                font-size: 13px;
            }
        </style>
    </head>
    <body style="background-color: #FFFFFF;" onload="window.print();">
        <div class="well" style="border:none; margin: 0;">
            <b>{{$attendees->count()}}</b> @lang('manageevent_printattendees.attendees_for_event') <b>{{{$event->title}}}</b> ({{$event->start_date->toDayDateTimeString()}})<br>
        </div>

        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>@lang('manageevent_printattendees.name')</th>
                    <th>@lang('manageevent_printattendees.email')</th>
                    <th>@lang('manageevent_printattendees.city')</th>
                    <th>@lang('manageevent_printattendees.ticket')</th>
                    <th>@lang('manageevent_printattendees.ref')</th>
                    <th>@lang('manageevent_printattendees.date')</th>
                    <th>@lang('manageevent_printattendees.status')</th>
                    <th>@lang('manageevent_printattendees.arrived')</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendees as $attendee)
                <tr>
                    <td>{{{$attendee->full_name}}}</td>
                    <td>{{{$attendee->email}}}</td>
                    <td>{{{$attendee->postal_code}}} {{{$attendee->city}}}</td>
                    <td>{{{$attendee->ticket->title}}}</td>
                    <td>{{{$attendee->getReferenceAttribute()}}}</td>
                    <td>{{$attendee->created_at->format('d/m/Y H:i')}}</td>
                    <td>@if($attendee->order->is_payment_received)@lang('manageevent_printattendees.payment_du') @endif</td>
                    <td><input type="checkbox" style="border: 1px solid #000; height: 15px; width: 15px;" /></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>
