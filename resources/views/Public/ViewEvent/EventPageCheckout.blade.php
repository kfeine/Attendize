@extends('Public.ViewEvent.Layouts.EventPage')

@section('head')
    @if ( config('attendize.enable_payments') === 1)
      <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    @endif
@stop

@section('content')
    @include('Public.ViewEvent.Partials.EventHeaderSection')

    @include('Public.ViewEvent.Partials.EventCreateOrderSection')
    <script>var OrderExpires = {{strtotime($expires)}};</script>
    @include('Public.ViewEvent.Partials.EventFooterSection')
@stop

