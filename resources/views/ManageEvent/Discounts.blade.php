@extends('Shared.Layouts.Master')

@section('title')
    @parent
    @lang('manageevent_discounts.title')
@stop

@section('top_nav')
    @include('ManageEvent.Partials.TopNav')
@stop

@section('menu')
    @include('ManageEvent.Partials.Sidebar')
@stop

@section('page_title')
    <i class='ico-clipboard4 mr5'></i>
    @lang('manageevent_discounts.title')
@stop

@section('page_header')
    <div class="col-md-9 col-sm-6">
        <!-- Toolbar -->
        <div class="btn-toolbar" role="toolbar">
            <div class="btn-group btn-group btn-group-responsive">
                <button class="loadModal btn btn-success" type="button" data-modal-id="CreateDiscount"
                        href="javascript:void(0);"
                        data-href="{{route('showCreateEventDiscount', ['event_id' => $event->id])}}">
                    <i class="ico-gift"></i> @lang('manageevent_discounts.add_discount')
                </button>
            </div>
        </div>
        <!--/ Toolbar -->
    </div>
    <div class="col-md-3 col-sm-6">
    </div>
@stop


@section('content')
    <!--Start Discounts table-->
    @if($discounts->count())
        <div class="row">
            <div class="col-md-12">
                <!-- START panel -->
                <div class="panel">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <th> @lang('manageevent_discounts.description') </th>
                                <th> @lang('manageevent_discounts.code') </th>
                                <th> @lang('manageevent_discounts.price') </th>
                                <th> @lang('manageevent_discounts.usage') </th>
                                <th> @lang('manageevent_discounts.actions') </th>
                            </thead>

                            <tbody class="sortable">
                            @foreach($discounts as $discount)
                                <tr id="discount-{{ $discount->id }}" data-discount-id="{{ $discount->id }}">
                                    <td>
                                        {{ $discount->title }}
                                    </td>
                                    <td>
                                        {{ $discount->code }}
                                    </td>
                                    <td>
                                        {{ $discount->price }}
                                    </td>
                                    <td>
                                        {{ $discount->orders->count() }}
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-xs btn-primary loadModal" data-modal-id="EditDiscount"
                                           href="javascript:void(0);"
                                           data-href="{{route('showEditEventDiscount', ['event_id' => $event->id, 'discount_id' => $discount->id])}}">
                                            @lang('manageevent_discounts.edit')
                                        </a>
                                        <a class="btn btn-xs btn-primary enableDiscount" href="javascript:void(0);"
                                           data-route="{{ route('postEnableDiscount', ['event_id' => $event->id, 'discount_id' => $discount->id]) }}"
                                           data-id="{{ $discount->id }}"
                                        >
                                            {{ $discount->is_enabled ? 'Disable' : 'Enable' }}
                                        </a>
                                        <a data-id="{{ $discount->id }}"
                                           title="The disount code won't be effective anymore, but existing reductions will still apply."
                                           data-route="{{ route('postDeleteEventDiscount', ['event_id' => $event->id, 'discount_id' => $discount->id]) }}"
                                           data-type="discount" href="javascript:void(0);"
                                           class="deleteThis btn btn-xs btn-danger">
                                            @lang('manageevent_discounts.delete')
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <script>
                /*
                @todo Move this into main JS file
                 */
                $(function () {
                    $(document.body).on('click', '.enableDiscount', function (e) {

                        var discountId = $(this).data('id'),
                                route = $(this).data('route');

                        $.post(route, 'discount_id=' + discountId)
                                .done(function (data) {

                                    if (typeof data.message !== 'undefined') {
                                        showMessage(data.message);
                                    }

                                    switch (data.status) {
                                        case 'success':
                                            setTimeout(function () {
                                                document.location.reload();
                                            }, 300);
                                            break;
                                        case 'error':
                                            showMessage(Attendize.GenericErrorMessages);
                                            break;

                                        default:
                                            break;
                                    }
                                }).fail(function (data) {
                            showMessage(Attendize.GenericErrorMessages);
                        });

                        e.preventDefault();
                    });

                    $('.sortable').sortable({
                        handle: '.sortHanlde',
                        forcePlaceholderSize: true,
                        placeholder: '<tr><td class="bg-info" colspan="6">&nbsp;</td></tr>'
                    }).bind('sortupdate', function (e, ui) {

                        var data = $('.sortable tr').map(function () {
                            return $(this).data('discount-id');
                        }).get();

                        $.ajax({
                            type: 'POST',
                            url: Attendize.postUpdateDiscountsOrderRoute,
                            dataType: 'json',
                            data: {discount_ids: data},
                            success: function (data) {
                                showMessage(data.message)
                            },
                            error: function (data) {
                                console.log(data);
                            }
                        });
                    });
                });
            </script>

    @else

        @include('ManageEvent.Partials.DiscountsBlankSlate')

    @endif
    </div>    <!--/End discounts table-->


@stop
