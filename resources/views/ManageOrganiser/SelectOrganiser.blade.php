@extends('Shared.Layouts.MasterWithoutMenus')

@section('title')
    @lang('manageorganiser_selectorganiser.title')
@stop

@section('head')
    <style>
        .modal-header {
            background-color: transparent !important;
            color: #666 !important;
            text-shadow: none !important;;
        }
    </style>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel">
                <div class="panel-body">
                    <div class="logo">
                        {!!HTML::image('assets/images/logo-dark.png')!!}
                    </div>

                    <h5>@lang('manageorganiser_selectorganiser.continue')</h5>
                    <div class="list-group">
                        @foreach($organisers as $organiser)
                            <a href="{{route('showOrganiserDashboard', ['organiser_id'=>$organiser->id] )}}"
                               class="list-group-item">
                                {{$organiser->name}}
                            </a>
                        @endforeach
                    </div>

                    <div style="margin-top:-15px; padding: 10px; text-align: center;">
                        @lang('manageorganiser_selectorganiser.or')
                    </div>
                    <a style="color: white;" href="{{route('showCreateOrganiser')}}" class="btn btn-block btn-success">@lang('manageorganiser_selectorganiser.create')</a>
                </div>
            </div>
        </div>
    </div>
@stop
