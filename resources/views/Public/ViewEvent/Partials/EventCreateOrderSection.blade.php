<section id='order_form' class="container">
    <div class="row">
        <h1 class="section_head">
            @lang('public_viewevent_partials_eventcreateordersection.order_details')
        </h1>
    </div>
    <div class="row">
        <div class="col-md-4 col-md-push-8">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="ico-cart mr5"></i>
                        @lang('public_viewevent_partials_eventcreateordersection.order_summary')
                    </h3>
                </div>

                <div class="panel-body pt0">
                    <table class="table mb0 table-condensed">
                        @foreach($tickets as $ticket)
                        <tr>
                            <td>
                                <table style="width: 100%;">
                                    <tr>
                                        <td class="pl0"><b>{{ $ticket['ticket']['title'] }}</b></td>
                                        <td style="text-align: right;">
                                            @if((int)ceil($ticket['full_price']) === 0)
                                            -
                                            @else
                                            {{ money($ticket['full_price'], $event->currency) }}
                                            @endif
                                        </td>
                                    </tr>
                                    @foreach($ticket['options'] as $option)
                                    <tr>
                                        <td>+ {{{$option->title}}}</td>
                                              <td style="text-align: right;">
                                                    @if((int)ceil($option->price) === 0)
                                                    -
                                                    @else
                                                    {{ money($option->price, $event->currency) }}
                                                    @endif
                                              </td>
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </td>
                        </tr>
                        @endforeach
                        @if($discount)
                        <tr>
                            <td>
                                <table style="width: 100%;">
                                    <tr>
                                        <td class="pl0"><b>{{ $discount->title }}</b></td>
                                        <td style="text-align: right;">
                                            @if($discount->type === "amount")
                                            {{ money($discount->price, $event->currency) }}
                                            @else
                                            {{ $discount->price }} %
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        @endif
                    </table>
                </div>
                <div class="panel-footer">
                    <h5>
                        Total: <span style="float: right;"><b>{{ money($order_total + $total_booking_fee,$event->currency) }}</b></span>
                    </h5>
                </div>

            </div>
            <div class="help-block">
                @lang('public_viewevent_partials_eventcreateordersection.countdown', ['countdown'=> '<span id=\'countdown\'></span>'])
            </div>
        </div>
        <div class="col-md-8 col-md-pull-4">
            <div class="event_order_form">
                {!! Form::open(['url' => route('postCreateOrder', ['event_id' => $event->id]), 'class' => ($order_requires_payment && @$payment_gateway->is_on_site) ? 'ajax payment-form' : 'ajax', 'data-stripe-pub-key' => isset($account_payment_gateway->config['publishableKey']) ? $account_payment_gateway->config['publishableKey'] : '']) !!}

                {!! Form::hidden('event_id', $event->id) !!}

                <h3>@lang('public_viewevent_partials_eventcreateordersection.information')</h3>

                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group">
                            {!! Form::label("order_last_name", __('public_viewevent_partials_eventcreateordersection.last_name'), ['class' => "required"]) !!}
                            {!! Form::text("order_last_name", $tickets[0]['attendee']['last_name'], ['required' => 'required', 'class' => 'required form-control']) !!}
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            {!! Form::label("order_first_name", __('public_viewevent_partials_eventcreateordersection.first_name'), ['class' => "required"]) !!}
                            {!! Form::text("order_first_name", $tickets[0]['attendee']['first_name'], ['required' => 'required', 'class' => 'required form-control']) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label("order_email", __('public_viewevent_partials_eventcreateordersection.email'), ['class' => "required"]) !!}
                            {!! Form::text("order_email", $tickets[0]['attendee']['email'], ['required' => 'required', 'class' => 'required form-control']) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label("order_phone", __('public_viewevent_partials_eventcreateordersection.phone'), ['class' => "required"]) !!}
                            {!! Form::text("order_phone", null, ['required' => 'required', 'class' => 'required form-control']) !!}
                        </div>
                    </div>
                </div>

                <div class="address-manual">
                    <div class="form-group">
                        {!! Form::label('order_address_line_1', __('public_viewevent_partials_eventcreateordersection.address1'), ['class' => "required"]) !!}
                        {!!  Form::text('order_address_line_1', null, [
                                    'class'=>'form-control required',
                                    'required' => 'required',
                                    'placeholder'=>__('public_viewevent_partials_eventcreateordersection.placeholder_address1')
                        ])  !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('order_address_line_2', __('public_viewevent_partials_eventcreateordersection.address2'), array('class'=>'')) !!}
                        {!!  Form::text('order_address_line_2', null, [
                                    'class'=>'form-control',
                                    'placeholder'=>__('public_viewevent_partials_eventcreateordersection.placeholder_address2')
                        ])  !!}
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('order_postal_code', __('public_viewevent_partials_eventcreateordersection.postcode'), ['class' => "required"]) !!}
                                {!!  Form::text('order_postal_code', null, [
                                            'class'=>'form-control required',
                                            'required' => 'required',
                                            'placeholder'=>__('public_viewevent_partials_eventcreateordersection.placeholder_postcode')
                                ])  !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('order_city', __('public_viewevent_partials_eventcreateordersection.city'), ['class' => "required"]) !!}
                                {!!  Form::text('order_city', null, [
                                            'class'=>'form-control required',
                                            'required' => 'required',
                                            'placeholder'=>__('public_viewevent_partials_eventcreateordersection.placeholder_city')
                                ])  !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p20 pl0">
                    <a href="javascript:void(0);" class="btn btn-primary btn-xs" id="mirror_buyer_info">
                        @lang('public_viewevent_partials_eventcreateordersection.copy')
                    </a>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="ticket_holders_details" >
                            <h3>@lang('public_viewevent_partials_eventcreateordersection.ticket')</h3>
                            <?php
                                $total_attendee_increment = 0;
                            ?>
                            @foreach($tickets as $ticket)
                                <div class="panel panel-primary">

                                    <div class="panel-heading">
                                        <h3 class="panel-title">
                                            @lang('public_viewevent_partials_eventcreateordersection.details', ['number' => $ticket['attendee_id']]): <b>{{$ticket['ticket']['title']}}</b>
                                        </h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    {!! Form::label("ticket_holder_gender[{$ticket['attendee_id']}][{$ticket['ticket']['id']}]", __('public_viewevent_partials_eventcreateordersection.gender'), ['class' => "required"]) !!}
                                                    {!! Form::select(
                                                        "ticket_holder_gender[{$ticket['attendee_id']}][{$ticket['ticket']['id']}]",
                                                        array('M' => __('public_viewevent_partials_eventcreateordersection.gender_male'), 'W' => __('public_viewevent_partials_eventcreateordersection.gender_female')),
                                                        $ticket['attendee']['gender'],
                                                        ['required' => 'required', 'class' => "ticket_holder_gender.{$ticket['attendee_id']}.{$ticket['ticket']['id']} ticket_holder_gender form-control"]
                                                    ) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    {!! Form::label("ticket_holder_last_name[{$ticket['attendee_id']}][{$ticket['ticket']['id']}]", __('public_viewevent_partials_eventcreateordersection.last_name'), ['class' => "required"]) !!}
                                                    {!! Form::text("ticket_holder_last_name[{$ticket['attendee_id']}][{$ticket['ticket']['id']}]", $ticket['attendee']['last_name'], ['required' => 'required', 'class' => "required ticket_holder_last_name.{$ticket['attendee_id']}.{$ticket['ticket']['id']} ticket_holder_last_name form-control"]) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    {!! Form::label("ticket_holder_first_name[{$ticket['attendee_id']}][{$ticket['ticket']['id']}]", __('public_viewevent_partials_eventcreateordersection.first_name'), ['class' => "required"]) !!}
                                                    {!! Form::text("ticket_holder_first_name[{$ticket['attendee_id']}][{$ticket['ticket']['id']}]", $ticket['attendee']['first_name'], ['required' => 'required', 'class' => "required ticket_holder_first_name.{$ticket['attendee_id']}.{$ticket['ticket']['id']} ticket_holder_first_name form-control"]) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    {!! Form::label("ticket_holder_email[{$ticket['attendee_id']}][{$ticket['ticket']['id']}]", __('public_viewevent_partials_eventcreateordersection.email')) !!}
                                                    {!! Form::text("ticket_holder_email[{$ticket['attendee_id']}][{$ticket['ticket']['id']}]", $ticket['attendee']['email'], [ 'class' => "ticket_holder_email.{$ticket['attendee_id']}.{$ticket['ticket']['id']} ticket_holder_email form-control"]) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    {!! Form::label("ticket_holder_birthdate[{$ticket['attendee_id']}][{$ticket['ticket']['id']}]", __('public_viewevent_partials_eventcreateordersection.birthdate')) !!}
                                                    {!! Form::date("ticket_holder_birthdate[{$ticket['attendee_id']}][{$ticket['ticket']['id']}]", null, ['required' => 'required', 'class' => "required ticket_holder_birthdate.{$ticket['attendee_id']}.{$ticket['ticket']['id']} ticket_holder_birthdate form-control"]) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    {!! Form::label("ticket_holder_phone[{$ticket['attendee_id']}][{$ticket['ticket']['id']}]", __('public_viewevent_partials_eventcreateordersection.phone'), ['class' => 'required']) !!}
                                                    {!! Form::text("ticket_holder_phone[{$ticket['attendee_id']}][{$ticket['ticket']['id']}]", null, ['required' => 'required', 'class' => "required form-control ticket_holder_phone.{$ticket['attendee_id']}.{$ticket['ticket']['id']} ticket_holder_phone"]) !!}
                                                </div>

                                                <div class="form-group">
                                                    {!! Form::label("ticket_holder_address_line_1[{$ticket['attendee_id']}][{$ticket['ticket']['id']}]", __('public_viewevent_partials_eventcreateordersection.address1'), ['class' => "required"]) !!}
                                                    {!!  Form::text("ticket_holder_address_line_1[{$ticket['attendee_id']}][{$ticket['ticket']['id']}]", null, [
                                                                'class'=>"form-control required ticket_holder_address_line_1.{$ticket['attendee_id']}.{$ticket['ticket']['id']} ticket_holder_address_line_1",
                                                                'required' => 'required',
                                                                'placeholder'=>__('public_viewevent_partials_eventcreateordersection.placeholder_address1')
                                                    ])  !!}
                                                </div>
                                                <div class="form-group">
                                                    {!! Form::label("ticket_holder_address_line_2[{$ticket['attendee_id']}][{$ticket['ticket']['id']}]", __('public_viewevent_partials_eventcreateordersection.address2'), array('class'=>'')) !!}
                                                    {!!  Form::text("ticket_holder_address_line_2[{$ticket['attendee_id']}][{$ticket['ticket']['id']}]", null, [
                                                                'class'=>"form-control ticket_holder_address_line_2.{$ticket['attendee_id']}.{$ticket['ticket']['id']} ticket_holder_address_line_2",
                                                                'placeholder'=>__('public_viewevent_partials_eventcreateordersection.placeholder_address2')
                                                    ])  !!}
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {!! Form::label("ticket_holder_postal_code[{$ticket['attendee_id']}][{$ticket['ticket']['id']}]", __('public_viewevent_partials_eventcreateordersection.postcode'), ['class' => "required"]) !!}
                                                    {!!  Form::text("ticket_holder_postal_code[{$ticket['attendee_id']}][{$ticket['ticket']['id']}]", null, [
                                                                'class'=>"form-control required ticket_holder_postal_code.{$ticket['attendee_id']}.{$ticket['ticket']['id']} ticket_holder_postal_code",
                                                                'required' => 'required',
                                                                'placeholder'=>__('public_viewevent_partials_eventcreateordersection.placeholder_postcode')
                                                    ])  !!}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {!! Form::label("ticket_holder_city[{$ticket['attendee_id']}][{$ticket['ticket']['id']}]", __('public_viewevent_partials_eventcreateordersection.city'), ['class' => "required"]) !!}
                                                    {!!  Form::text("ticket_holder_city[{$ticket['attendee_id']}][{$ticket['ticket']['id']}]", null, [
                                                                'class'=>"form-control required ticket_holder_city.{$ticket['attendee_id']}.{$ticket['ticket']['id']} ticket_holder_city",
                                                                'required' => 'required',
                                                                'placeholder'=>__('public_viewevent_partials_eventcreateordersection.placeholder_city')
                                                    ])  !!}
                                                </div>
                                            </div>
                                            @include('Public.ViewEvent.Partials.AttendeeQuestions', ['ticket' => $ticket['ticket'],'attendee_id' => $ticket['attendee_id'],'attendee_number' => $total_attendee_increment++])

                                        </div>

                                    </div>

                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <h3 class="required">@lang('public_viewevent_partials_eventcreateordersection.privacy')</h3>
                <div>
                    <p>Vous trouverez tous les détails concernant le traitement et la protection des données à caractère personnel sur cette page : <a target="_blank" rel="noopener noreferrer" href="/privacy/policy">Politique de protection de la vie privée</a></p>
                    <p>En cochant chacun des case suivantes, je certifie que chacune des personnes inscrites (dans le cas de personnes de moins de 15 ans, je certifie que le titulaire de l'autorité parentale consent aussi au traitement), ainsi la personne effectuant la commande, consent à l'utilisation :</p>
                </div>
                <div class="consent_privacy">
                    <div class="custom-checkbox">
                        <input data-toggle="toggle" id="consent_privacy" name="consent_privacy" type="checkbox" required>
                        <label for="consent_privacy">@lang('public_viewevent_partials_eventcreateordersection.consent_privacy') <span style="color: red; font-size: 9px;"><b>*</b></span></label>
                    </div>
                </div>
                <div class="consent_share_coordinates">
                    <div class="custom-checkbox">
                        <input data-toggle="toggle" id="consent_share_coordinates" name="consent_share_coordinates" type="checkbox">
                        <label for="consent_share_coordinates">@lang('public_viewevent_partials_eventcreateordersection.consent_share_coordinates')</label>
                    </div>
                </div>
                <div class="consent_contact_reminder">
                    <div class="custom-checkbox">
                        <input data-toggle="toggle" id="consent_contact_reminder" name="consent_contact_reminder" type="checkbox">
                        <label for="consent_contact_reminder">@lang('public_viewevent_partials_eventcreateordersection.consent_contact_reminder')</label>
                    </div>
                </div>

                <style>
                    .offline_payment_toggle {
                        padding: 20px 0;
                    }
                </style>

                @if($order_requires_payment)

                <h3>@lang('public_viewevent_partials_eventcreateordersection.payment')</h3>

                @if($event->enable_offline_payments)
                    <div class="offline_payment_toggle">
                        <div class="custom-checkbox">
                            <input data-toggle="toggle" id="pay_offline" name="pay_offline" type="checkbox" value="1">
                            <label for="pay_offline">@lang('public_viewevent_partials_eventcreateordersection.offline')</label>
                        </div>
                    </div>
                    @if(!empty($event->offline_payment_instructions))
                    <div class="offline_payment" style="display: none;">
                        <h5>@lang('public_viewevent_partials_eventcreateordersection.instructions')</h5>
                        <div class="well">
                            {!! Markdown::parse($event->offline_payment_instructions) !!}
                        </div>
                    </div>
                    @endif

                @endif


                @if(@$payment_gateway->is_on_site)
                    <div class="online_payment">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('card-number', __('public_viewevent_partials_eventcreateordersection.card')) !!}
                                    <input required="required" type="text" autocomplete="off" placeholder="**** **** **** ****" class="required form-control card-number" size="20" data-stripe="number">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    {!! Form::label('card-expiry-month', __('public_viewevent_partials_eventcreateordersection.expiry_month')) !!}
                                    {!!  Form::selectRange('card-expiry-month',1,12,null, [
                                            'class' => 'form-control card-expiry-month',
                                            'data-stripe' => 'exp_month'
                                        ] )  !!}
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    {!! Form::label('card-expiry-year', __('public_viewevent_partials_eventcreateordersection.expiry_year')) !!}
                                    {!!  Form::selectRange('card-expiry-year',date('Y'),date('Y')+10,null, [
                                            'class' => 'form-control card-expiry-year',
                                            'data-stripe' => 'exp_year'
                                        ] )  !!}</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('card-expiry-year', __('public_viewevent_partials_eventcreateordersection.cvc')) !!}
                                    <input required="required" placeholder="***" class="required form-control card-cvc" data-stripe="cvc">
                                </div>
                            </div>
                        </div>
                    </div>

                @endif

                @endif

                @if($event->pre_order_display_message)
                <div class="well well-small">
                    {!! nl2br(e($event->pre_order_display_message)) !!}
                </div>
                @endif

               {!! Form::hidden('is_embedded', $is_embedded) !!}
               {!! Form::submit(__('public_viewevent_partials_eventcreateordersection.checkout'), ['class' => 'btn btn-lg btn-success card-submit', 'style' => 'width:100%;']) !!}

            </div>
        </div>
    </div>
</section>
@if(session()->get('message'))
    <script>showMessage('{{session()->get('message')}}');</script>
@endif
