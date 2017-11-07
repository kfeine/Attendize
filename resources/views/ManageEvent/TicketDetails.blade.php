@extends('Shared.Layouts.Master')

@section('title')
    @parent
    __ticket :  {{ $ticket->title }}
@stop

@section('top_nav')
    @include('ManageEvent.Partials.TopNav')
@stop

@section('page_title')
    <i class="ico-ticket mr5"></i>
    __ticket : {{ $ticket->title }}
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
                <a href="{{route('showEventTickets', array('event_id' => $event->id)) }}"><i class="ico-eye2"></i> __Revenir à la liste des tickets</a>
            </div>
            @if(false)
                <div class="btn-group btn-group-responsive ">
                    <button data-modal-id='TicketQuestions'
                            data-href="{{route('showTicketQuestions', array('event_id'=>$event->id))}}" type="button"
                            class="loadModal btn btn-success">
                        <i class="ico-question"></i> @lang('manageevent_tickets.questions')
                    </button>
                </div>
                <div class="btn-group btn-group-responsive">
                    <button type="button" class="btn btn-success">
                        <i class="ico-tags"></i> @lang('manageevent_tickets.coupon')
                    </button>
                </div>
            @endif
        </div>
        <!--/ Toolbar -->
    </div>
@stop
@section('content')
<p>__Title : {{$ticket->title}}</p>
<p>__Prix : {{$ticket->price}}</p>
<p>__Nombre de ticket : {{$ticket->quantity_available}}</p>
<p>__Description : {{$ticket->description}}</p>
<p>__date de début : {{$ticket->start_sale_date}}</p>
<p>__date de fin : {{$ticket->end_sale_date}}</p>
<p>__nombre minimum par personne : {{$ticket->min_per_person}}</p>
<p>__nombre maximum par personne : {{$ticket->max_per_person}}</p>
<p>__est caché ? : {{$ticket->is_hidden}}</p> 
<button data-modal-id='TicketQuestions'
                            data-href="{{route('showEditTicket', array('event_id'=>$event->id, 'ticket_id' => $ticket->id))}}" type="button"
                            class="loadModal btn btn-success">
                         __modifier les informations
                    </button>

<div class="row">
    @if($ticket->options->count())
    <div class="col-md-12">

        <!-- START panel -->
        <div class="panel">
            <div class="table-responsive ">
                <table class="table">
                    <thead>
                        <tr>
                            <th>
                               __title
                            </th>
                            <th>
                                __description
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($ticket->options as $option)
                        <tr id="option_{{$option->id}}">
                            <td>
                                {{$option->title}}
                            </td>
                            <td>
                                {{$option->description}}
                            </td>
                            <td>__Prix : {{$option->price}}</td>
                            <td class="text-center">
                                <a data-modal-id="view-option-{{ $option->id }}" data-href="{{route('showEditTicketOptions', ['event_id' => $event->id, 'ticket_id' => $ticket->id, 'option_id'=>$option->id])}}" title="View Option" class="btn btn-xs btn-primary loadModal">__editer</a>
                                <a class="btn btn-xs btn-primary enableTicketOption" href="javascript:void(0);"
                                           data-route="{{ route('postEnableTicketOption', ['event_id' => $event->id, 'ticket_id' => $ticket->id, 'option_id'=>$option->id]) }}"
                                           data-id="{{ $option->id }}"
                                        >
                                          @if($option->is_enabled)
                                              <i class="ico-pause"></i> __descactiver
                                          @else
                                              <i class="ico-play4"></i> __activer
                                          @endif
                                        </a>
                                <a data-id="{{ $option->id }}"
                                   title="__delete"
                                   data-route="{{ route('postDeleteTicketOption', ['event_id' => $event->id, 'ticket_id' => $ticket->id, 'option_id' => $option->id]) }}"
                                   data-type="option" href="javascript:void(0);"
                                   class="deleteThis btn btn-xs btn-danger">
                                                __supprimer
                                </a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @else
      __pas d'option actuellement
    @endif
  <div class="col-md-12">
        <button data-modal-id='TicketQuestions'
          data-href="{{route('showCreateTicketOption', array('event_id'=>$event->id, 'ticket_id' => $ticket->id))}}" type="button"
          class="loadModal btn btn-success">
            __ajouter une option
        </button>    </div>


@stop
