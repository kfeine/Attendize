@extends('Shared.Layouts.Master')

@section('title')
@parent
@lang('manageevent_attendees.title')
@stop


@section('page_title')
<i class="ico-users"></i>
@lang('manageevent_attendees.attendees')
@stop

@section('top_nav')
@include('ManageEvent.Partials.TopNav')
@stop

@section('menu')
@include('ManageEvent.Partials.Sidebar')
@stop


@section('head')

@stop

@section('page_header')

<div class="col-md-9">
    <div class="btn-toolbar" role="toolbar">
        <div class="btn-group btn-group-responsive">
            <button data-modal-id="InviteAttendee" href="javascript:void(0);"  data-href="{{route('showInviteAttendee', ['event_id'=>$event->id])}}" class="loadModal btn btn-success" type="button"><i class="ico-user-plus"></i> @lang('manageevent_attendees.invite')</button>
        </div>

        <div class="btn-group btn-group-responsive">
            <button data-modal-id="ImportAttendees" href="javascript:void(0);"  data-href="{{route('showImportAttendee', ['event_id'=>$event->id])}}" class="loadModal btn btn-success" type="button"><i class="ico-file"></i> @lang('manageevent_attendees.invite_attendees')</button>
        </div>

        <div class="btn-group btn-group-responsive">
            <a class="btn btn-success" href="{{route('showPrintAttendees', ['event_id'=>$event->id])}}" target="_blank" ><i class="ico-print"></i> @lang('manageevent_attendees.print_list')</a>
        </div>
        <div class="btn-group btn-group-responsive">
            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                <i class="ico-users"></i> @lang('manageevent_attendees.export') <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><a href="{{route('showExportAttendees', ['event_id'=>$event->id,'export_as'=>'xlsx'])}}">excel (xlsx)</a></li>
                <li><a href="{{route('showExportAttendees', ['event_id'=>$event->id,'export_as'=>'xls'])}}">excel (xls)</a></li>
                <li><a href="{{route('showExportAttendees', ['event_id'=>$event->id,'export_as'=>'csv'])}}">csv</a></li>
                <li><a href="{{route('showExportAttendees', ['event_id'=>$event->id,'export_as'=>'html'])}}">html</a></li>
            </ul>
        </div>
        <div class="btn-group btn-group-responsive">
            <button data-modal-id="messageattendees" href="javascript:void(0);" data-href="{{route('showMessageAttendees', ['event_id'=>$event->id])}}" class="loadmodal btn btn-success" type="button"><i class="ico-envelope"></i> @lang('manageevent_attendees.message')</button>
        </div>
    </div>
</div>
<div class="col-md-3">
   {!! form::open(array('url' => route('showEventAttendees', ['event_id'=>$event->id,'sort_by'=>$sort_by]), 'method' => 'get')) !!}
    <div class="input-group">
        <input name="q" value="{{$q or ''}}" placeholder="@lang('manageevent_attendees.search')" type="text" class="form-control" />
        <span class="input-group-btn">
            <button class="btn btn-default" type="submit"><i class="ico-search"></i></button>
        </span>
    </div>
   {!! form::close() !!}
</div>
@stop


@section('content')

<!--Start Attendees table-->
<div class="row">
    <div class="col-md-12">
        @if($attendees->count())
        <div class="panel">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>
                               {!!Html::sortable_link(__('manageevent_attendees.name'), $sort_by, 'first_name', $sort_order, ['q' => $q , 'page' => $attendees->currentPage()])!!}
                            </th>
                            <th>
                               {!!Html::sortable_link(__('manageevent_attendees.email'), $sort_by, 'email', $sort_order, ['q' => $q , 'page' => $attendees->currentPage()])!!}
                            </th>
                            <th>
                               {!!Html::sortable_link(__('manageevent_attendees.ticket'), $sort_by, 'ticket_id', $sort_order, ['q' => $q , 'page' => $attendees->currentPage()])!!}
                            </th>
                            <th>
                               {!!Html::sortable_link(__('manageevent_attendees.order_ref'), $sort_by, 'order_reference', $sort_order, ['q' => $q , 'page' => $attendees->currentPage()])!!}
                            </th>
                            <th>
                               {!!Html::sortable_link(__('manageevent_attendees.ticket_ref'), $sort_by, 'reference_index', $sort_order, ['q' => $q , 'page' => $attendees->currentPage()])!!}
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendees as $attendee)
                        <tr class="attendee_{{$attendee->id}} {{$attendee->is_cancelled ? 'danger' : ''}}">
                            <td>{{{$attendee->full_name}}}</td>
                            <td>
                                <a data-modal-id="MessageAttendee" href="javascript:void(0);" class="loadModal"
                                    data-href="{{route('showMessageAttendee', ['attendee_id'=>$attendee->id])}}"
                                    > {{$attendee->email}}</a>
                            </td>
                            <td>
                                {{{$attendee->ticket->title}}}
                            </td>
                            <td>
                                <a href="javascript:void(0);" data-modal-id="view-order-{{ $attendee->order->id }}" data-href="{{route('showManageOrder', ['order_id'=>$attendee->order->id])}}" title="View Order #{{$attendee->order->order_reference}}" class="loadModal">
                                    {{$attendee->order->order_reference}}
                                </a>
                            </td>
                             <td>
                                <a data-modal-id="EditAttendee"
                                   href="javascript:void(0);"
                                   data-href="{{route('showEditAttendee', ['event_id'=>$event->id, 'attendee_id'=>$attendee->id])}}"
                                   class="loadModal">
                                    {{$attendee->id}}
                                </a>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        @if($attendee->email)
                                        <li><a
                                            data-modal-id="MessageAttendee"
                                            href="javascript:void(0);"
                                            data-href="{{route('showMessageAttendee', ['attendee_id'=>$attendee->id])}}"
                                            class="loadModal"
                                            > @lang('manageevent_attendees.message')</a></li>
                                        @endif
                                        <li><a
                                            data-modal-id="ResendTicketToAttendee"
                                            href="javascript:void(0);"
                                            data-href="{{route('showResendTicketToAttendee', ['attendee_id'=>$attendee->id])}}"
                                            class="loadModal"
                                            > @lang('manageevent_attendees.resend')</a></li>
                                        <li><a
                                            href="{{route('showExportTicket', ['event_id'=>$event->id, 'attendee_id'=>$attendee->id])}}"
                                            >@lang('manageevent_attendees.download')</a></li>
                                    </ul>
                                </div>

                                <a
                                    data-modal-id="EditAttendee"
                                    href="javascript:void(0);"
                                    data-href="{{route('showEditAttendee', ['event_id'=>$event->id, 'attendee_id'=>$attendee->id])}}"
                                    class="loadModal btn btn-xs btn-primary"
                                    > @lang('manageevent_attendees.edit')</a>

                                <a
                                    data-modal-id="CancelAttendee"
                                    href="javascript:void(0);"
                                    data-href="{{route('showCancelAttendee', ['event_id'=>$event->id, 'attendee_id'=>$attendee->id])}}"
                                    class="loadModal btn btn-xs btn-danger"
                                    > @lang('manageevent_attendees.cancel')</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else

        @if(!empty($q))
        @include('Shared.Partials.NoSearchResults')
        @else
        @include('ManageEvent.Partials.AttendeesBlankSlate')
        @endif

        @endif
    </div>
    <div class="col-md-12">
        {!!$attendees->appends(['sort_by' => $sort_by, 'sort_order' => $sort_order, 'q' => $q])->render()!!}
    </div>
</div>    <!--/End attendees table-->

@stop
