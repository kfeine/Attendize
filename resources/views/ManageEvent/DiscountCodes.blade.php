@extends('Shared.Layouts.Master')

@section('title')
    @parent

    Event Discount Codes
@stop

@section('top_nav')
    @include('ManageEvent.Partials.TopNav')
@stop

@section('menu')
    @include('ManageEvent.Partials.Sidebar')
@stop

@section('page_title')
    <i class='ico-clipboard4 mr5'></i>
    Event Discount Codes
@stop

@section('head')

@stop

@section('page_header')
    <div class="col-md-9 col-sm-6">
        <!-- Toolbar -->
        <div class="btn-toolbar" role="toolbar">
            <div class="btn-group btn-group btn-group-responsive">
                <button class="loadModal btn btn-success" type="button" data-modal-id="CreateDiscountCode"
                        href="javascript:void(0);"
                        data-href="{{route('showCreateEventDiscountCode', ['event_id' => $event->id])}}">
                    <i class="ico-gift"></i> Add discount code
                </button>
            </div>
        </div>
        <!--/ Toolbar -->
    </div>
    <div class="col-md-3 col-sm-6">

    </div>
    @stop


    @section('content')
            <!--Start Discount codes table-->
    <div class="row">
        <script>
            /*
            @todo Move this into main JS file
             */
            // $(function () {
            //
            //
            //     $(document.body).on('click', '.enableQuestion', function (e) {
            //
            //         var questionId = $(this).data('id'),
            //                 route = $(this).data('route');
            //
            //         $.post(route, 'question_id=' + questionId)
            //                 .done(function (data) {
            //
            //                     if (typeof data.message !== 'undefined') {
            //                         showMessage(data.message);
            //                     }
            //
            //                     switch (data.status) {
            //                         case 'success':
            //                             setTimeout(function () {
            //                                 document.location.reload();
            //                             }, 300);
            //                             break;
            //                         case 'error':
            //                             showMessage(Attendize.GenericErrorMessages);
            //                             break;
            //
            //                         default:
            //                             break;
            //                     }
            //                 }).fail(function (data) {
            //             showMessage(Attendize.GenericErrorMessages);
            //         });
            //
            //
            //         e.preventDefault();
            //     });
            //
            //
            //     $('.sortable').sortable({
            //         handle: '.sortHanlde',
            //         forcePlaceholderSize: true,
            //         placeholder: '<tr><td class="bg-info" colspan="6">&nbsp;</td></tr>'
            //     }).bind('sortupdate', function (e, ui) {
            //
            //         var data = $('.sortable tr').map(function () {
            //             return $(this).data('question-id');
            //         }).get();
            //
            //         $.ajax({
            //             type: 'POST',
            //             url: Attendize.postUpdateQuestionsOrderRoute,
            //             dataType: 'json',
            //             data: {question_ids: data},
            //             success: function (data) {
            //                 showMessage(data.message)
            //             },
            //             error: function (data) {
            //                 console.log(data);
            //             }
            //         });
            //     });
            // });
        </script>
        @if($discount_codes->count())

            <div class="col-md-12">

                <!-- START panel -->
                <div class="panel">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <th style="width: 25px;"> </th>
                                <th> Description </th>
                                <th> Code </th>
                                <th> Price </th>
                                <th> # Usage </th>
                                <th> Actions </th>
                            </thead>

                            <tbody class="sortable">
                            @foreach($discount_codes as $discount_code)
                                <tr id="discount_code-{{ $discount_code->id }}" data-discount_code-id="{{ $discount_code->id }}">
                                    <td>
                                        <div style="cursor: move;" class="sortHanlde">
                                            <i class="ico-sort "></i>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $discount_code->title }}
                                    </td>
                                    <td>
                                        {{ $discount_code->code }}
                                    </td>
                                    <td>
                                        {{ $discount_code->price }}
                                    </td>
                                    <td>
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-xs btn-primary loadModal" data-modal-id="EditDiscountCode"
                                           href="javascript:void(0);"
                                           data-href="{{route('showEditEventDiscountCode', ['event_id' => $event->id, 'discount_code_id' => $discount_code->id])}}">
                                            Edit
                                        </a>
                                        <a class="btn btn-xs btn-primary enableDiscountCode" href="javascript:void(0);"
                                           data-route="{{ route('postEnableDiscountCode', ['event_id' => $event->id, 'discount_code_id' => $discount_code->id]) }}"
                                           data-id="{{ $discount_code->id }}"
                                        >
                                            {{ $discount_code->is_enabled ? 'Disable' : 'Enable' }}
                                        </a>
                                        <a data-id="{{ $discount_code->id }}"
                                           title="The disount code won't be effective anymore, but existing reductions will still apply."
                                           data-route="{{ route('postDeleteEventDiscountCode', ['event_id' => $event->id, 'discount_code_id' => $discount_code->id]) }}"
                                           data-type="discount_code" href="javascript:void(0);"
                                           class="deleteThis btn btn-xs btn-danger">
                                            Delete
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

            <!-- TODO @include('ManageEvent.Partials.SurveyBlankSlate') -->

        @endif
    </div>    <!--/End discount codes table-->


@stop
