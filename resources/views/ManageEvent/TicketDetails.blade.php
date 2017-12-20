@extends('Shared.Layouts.Master')

@section('title')
    @parent
    __ticket : {{ $ticket->title }}
@stop

@section('top_nav')
    @include('ManageEvent.Partials.TopNav')
@stop

@section('page_title')
    <i class="ico-ticket mr5"></i>
    @lang('manageevent_ticketdetails.ticket') : {{ $ticket->title }}
@stop

@section('head')
@stop

@section('menu')
    @include('ManageEvent.Partials.Sidebar')
@stop

@section('page_header')
    <div class="col-md-9">
        <!-- Toolbar -->
        <div class="btn-toolbar" role="toolbar">
            <div class="btn-group btn-group-responsive">
                <a href="{{ route('showEventTickets', array('event_id' => $event->id)) }}"><i class="ico-arrow-left"></i> @lang('manageevent_ticketdetails.back_to_tickets')</a>
            </div>
            @if(false)
                <div class="btn-group btn-group-responsive ">
                    <button data-modal-id='TicketQuestions'
                            data-href="{{ route('showTicketQuestions', array('event_id'=>$event->id)) }}" type="button"
                            class="loadModal btn btn-success">
                        <i class="ico-question"></i> @lang('manageevent_ticketdetails.questions')
                    </button>
                </div>
                <div class="btn-group btn-group-responsive">
                    <button type="button" class="btn btn-success">
                        <i class="ico-tags"></i> @lang('manageevent_ticketdetails.coupon')
                    </button>
                </div>
            @endif
        </div>
        <!--/ Toolbar -->
    </div>
@stop

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-body">
                <h3>@lang('manageevent_ticketdetails.ticket_information')</h3>
                <div class="p0 well bgcolor-white order_overview">
                    <div class="row">
                        <div class="col-sm-6 col-xs-6">
                            <b>@lang('manageevent_ticketdetails.ticket'):</b> {{$ticket->title}}
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <b>@lang('manageevent_ticketdetails.price'):</b> {{money($ticket->price, $event->currency)}}
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <b>@lang('manageevent_ticketdetails.quantity_available'):</b> {{$ticket->quantity_available}}
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <b>@lang('manageevent_ticketdetails.description'):</b> {{$ticket->description}}
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <b>@lang('manageevent_ticketdetails.start_sale_date'):</b> {{$ticket->start_sale_date}}
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <b>@lang('manageevent_ticketdetails.end_sale_date'):</b> {{$ticket->end_sale_date}}
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <b>@lang('manageevent_ticketdetails.is_hidden'):</b> @if($ticket->is_hidden)@lang('manageevent_ticketdetails.yes')@else @lang('manageevent_ticketdetails.no')@endif
                        </div>
                    </div>
                </div>

                <button data-modal-id='TicketQuestions'
                                            data-href="{{route('showEditTicket', array('event_id'=>$event->id, 'ticket_id' => $ticket->id))}}" type="button"
                                            class="loadModal btn btn-success">
                                         @lang('manageevent_ticketdetails.edit_information')
                                    </button>

                <h3>@lang('manageevent_ticketdetails.options')</h3>
                @if($ticket->options->count())
                <div class="panel">
                    <div class="table-responsive ">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>@lang('manageevent_ticketdetails.name')</th>
                                    <th>@lang('manageevent_ticketdetails.description')</th>
                                    <th>@lang('manageevent_ticketdetails.price')</th>
                                    <th>@lang('manageevent_ticketdetails.actions')</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($ticket->options as $option)
                                <tr id="option_{{$option->id}}">
                                    <td>{{$option->title}} </td>
                                    <td>{{$option->description}}</td>
                                    <td>{{money($option->price, $event->currency)}}</td>
                                    <td class="text-center">
                                        <a data-modal-id="view-option-{{ $option->id }}" data-href="{{route('showEditTicketOptions', ['event_id' => $event->id, 'ticket_id' => $ticket->id, 'option_id'=>$option->id])}}" title="View Option" class="btn btn-xs btn-primary loadModal">@lang('manageevent_ticketdetails.edit')</a>
                                        <a class="btn btn-xs btn-primary enableTicketOption" href="javascript:void(0);"
                                                   data-route="{{ route('postEnableTicketOption', ['event_id' => $event->id, 'ticket_id' => $ticket->id, 'option_id'=>$option->id]) }}"
                                                   data-id="{{ $option->id }}"
                                                >
                                                  @if($option->is_enabled)
                                                      <i class="ico-pause"></i> @lang('manageevent_ticketdetails.disable')
                                                  @else
                                                      <i class="ico-play4"></i> @lang('manageevent_ticketdetails.enable')
                                                  @endif
                                                </a>
                                        <a data-id="{{ $option->id }}"
                                           title="__delete"
                                           data-route="{{ route('postDeleteTicketOption', ['event_id' => $event->id, 'ticket_id' => $ticket->id, 'option_id' => $option->id]) }}"
                                           data-type="option" href="javascript:void(0);"
                                           class="deleteThis btn btn-xs btn-danger">
                                                        @lang('manageevent_ticketdetails.delete')
                                        </a>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div> <!-- end panel -->
                @else
                  <p>@lang('manageevent_ticketdetails.no_options')</p>
                @endif

                <button data-modal-id='TicketQuestions'
                  data-href="{{route('showCreateTicketOption', array('event_id'=>$event->id, 'ticket_id' => $ticket->id))}}" type="button"
                  class="loadModal btn btn-success">
                    @lang('manageevent_ticketdetails.add_option')
                </button>

            </div> <!-- end panel-body -->
        </div>
    </div>
</div>


@stop
