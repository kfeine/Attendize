@extends('Shared.Layouts.Master')

@section('title')
    @parent
    @lang('manageevent_optionsgeneric.title')
@stop

@section('top_nav')
    @include('ManageEvent.Partials.TopNav')
@stop

@section('page_title')
    <i class="ico-ticket mr5"></i>
    @lang('manageevent_optionsgeneric.title')
<span class="page_title_sub_title hide">
  @lang('manageevent_optionsgeneric.subtitle', ['count' => \App\Models\TicketOptionsDetailsGeneric::count()])
</span>
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
                <button data-modal-id='CreateOptionsGeneric'
                        data-href="{{route('options_generic.create', array('event_id'=>$event->id))}}"
                        class='loadModal btn btn-success' type="button"><i class="ico-ticket"></i> @lang('manageevent_optionsgeneric.create_optionsgeneric')
                </button>
            </div>
        </div>
        <!--/ Toolbar -->
    </div>
@stop

@section('content')
    <!--Start option table-->
    <div class="row">
        @if($options->count())

            <div class="col-md-12">

                <!-- START panel -->
                <div class="panel">
                    <div class="table-responsive ">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>@lang('manageevent_optionsgeneric.title')</th>
                                    <th>@lang('manageevent_optionsgeneric.sold')</th>
                                    <th>@lang('manageevent_optionsgeneric.really_sold')</th>
                                    <th>@lang('manageevent_optionsgeneric.remaining')</th>
                                    <th>@lang('manageevent_optionsgeneric.used')</th>
                                    <th>@lang('manageevent_optionsgeneric.actions')</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($options as $option)
                                <tr>
                                    <td>
                                        <a href='javascript:void(0);' data-modal-id='view-option-{{ $option->id }}' data-href="{{route('showManageOrder', ['option_id'=>$option->id])}}" title="View Option" class="loadModal">
                                            {{$option->title}}
                                        </a>
                                    </td>
                                    <td>
                                        {{ $option->quantity_sold }}
                                    </td>
                                    <td>
                                        {{ $option->quantity_reserved }}
                                    </td>
                                    <td>
                                        {{ ($option->quantity_available === null) ? '&infin;' : $option->quantity_remaining }}
                                    </td>
                                    <td>
                                        {{ $option->quantity_used_for_option }}
                                    </td>
                                    <td>
                                        <a data-modal-id="view-option-{{ $option->id }}" data-href="{{route('options_generic.edit', ['event_id' => $event->id, 'option_id'=>$option->id])}}" title="View Option" class="btn btn-xs btn-primary loadModal">@lang('manageevent_optionsgeneric.details')</a>
                                        @if($option->quantity_sold == 0 && $option->quantity_used_for_option == 0)
                                            {!! Form::model($option, ['url' => route('options_generic.destroy', ['event_id' => $event->id, 'options_generic'=>$option->id]), 'class' => 'ajax pull-right']) !!}
                                            {{ method_field('DELETE') }}

                                            {{ csrf_field() }}

                                            <button class="btn btn-danger btn-xs">@lang('manageevent_optionsgeneric.delete')</button>
                                            {!! Form::close() !!}
                                        @endif
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            @include('ManageEvent.Partials.OptionsGenericBlankSlate')
        @endif
    </div><!--/ end option table-->
@stop
