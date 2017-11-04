<script>
    $(function() {
        $('.payment_gateway_options').hide();
        $('#gateway_{{$account->payment_gateway_id}}').show();

        $('.gateway_selector').on('change', function(e) {
            $('.payment_gateway_options').hide();
            $('#gateway_' + $(this).val()).fadeIn();
        });

    });
</script>

{!! Form::model($account, array('url' => route('postEditAccountPayment'), 'class' => 'ajax ')) !!}
<div class="form-group">
    {!! Form::label('payment_gateway_id', __('manageaccount_partials_paymentgatewayoptions.gateway'), array('class'=>'control-label ')) !!}
    {!! Form::select('payment_gateway_id', $payment_gateways, $account->payment_gateway_id, ['class' => 'form-control gateway_selector']) !!}
</div>

{{--Stripe--}}
<section class="payment_gateway_options" id="gateway_{{config('attendize.payment_gateway_stripe')}}">
    <h4>@lang('manageaccount_partials_paymentgatewayoptions.settings')</h4>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('stripe[apiKey]', __('manageaccount_partials_paymentgatewayoptions.secret'), array('class'=>'control-label ')) !!}
                {!! Form::text('stripe[apiKey]', $account->getGatewayConfigVal(config('attendize.payment_gateway_stripe'), 'apiKey'),[ 'class'=>'form-control'])  !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('publishableKey', __('manageaccount_partials_paymentgatewayoptions.publishable'), array('class'=>'control-label ')) !!}
                {!! Form::text('stripe[publishableKey]', $account->getGatewayConfigVal(config('attendize.payment_gateway_stripe'), 'publishableKey'),[ 'class'=>'form-control'])  !!}
            </div>
        </div>
    </div>
</section>

{{--Paypal--}}
<section class="payment_gateway_options"  id="gateway_{{config('attendize.payment_gateway_paypal')}}">
    <h4>@lang('manageaccount_partials_paymentgatewayoptions.paypal_settings')</h4>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('paypal[username]', __('manageaccount_partials_paymentgatewayoptions.paypal_username'), array('class'=>'control-label ')) !!}
                {!! Form::text('paypal[username]', $account->getGatewayConfigVal(config('attendize.payment_gateway_paypal'), 'username'),[ 'class'=>'form-control'])  !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('paypal[password]', __('manageaccount_partials_paymentgatewayoptions.paypal_password'), ['class'=>'control-label ']) !!}
                {!! Form::text('paypal[password]', $account->getGatewayConfigVal(config('attendize.payment_gateway_paypal'), 'password'),[ 'class'=>'form-control'])  !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('paypal[signature]', __('manageaccount_partials_paymentgatewayoptions.paypal_signature'), array('class'=>'control-label ')) !!}
                {!! Form::text('paypal[signature]', $account->getGatewayConfigVal(config('attendize.payment_gateway_paypal'), 'signature'),[ 'class'=>'form-control'])  !!}
            </div>
        </div>
    </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('paypal[brandName]', __('manageaccount_partials_paymentgatewayoptions.branding_name'), array('class'=>'control-label ')) !!}
                    {!! Form::text('paypal[brandName]', $account->getGatewayConfigVal(config('attendize.payment_gateway_paypal'), 'brandName'),[ 'class'=>'form-control'])  !!}
                    <div class="help-block">
                        @lang('manageaccount_partials_paymentgatewayoptions.help')
                    </div>
                </div>
            </div>
        </div>


</section>

{{--BitPay--}}
<section class="payment_gateway_options" id="gateway_{{config('attendize.payment_gateway_bitpay')}}">
    <h4>@lang('manageaccount_partials_paymentgatewayoptions.bitpay_settings')</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('bitpay[apiKey]', __('manageaccount_partials_paymentgatewayoptions.bitpay_key'), array('class'=>'control-label ')) !!}
                {!! Form::text('bitpay[apiKey]', $account->getGatewayConfigVal(config('attendize.payment_gateway_bitpay'), 'apiKey'),[ 'class'=>'form-control'])  !!}
            </div>
        </div>
    </div>
</section>


{{--Coinbase--}}
<section class="payment_gateway_options"  id="gateway_{{config('attendize.payment_gateway_coinbase')}}">
    <h4>@lang('manageaccount_partials_paymentgatewayoptions.coinbase_settings')</h4>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('coinbase[apiKey]', __('manageaccount_partials_paymentgatewayoptions.coinbase_api'), array('class'=>'control-label ')) !!}
                {!! Form::text('coinbase[apiKey]', $account->getGatewayConfigVal(config('attendize.payment_gateway_coinbase'), 'apiKey'),[ 'class'=>'form-control'])  !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('coinbase[secret]', __('manageaccount_partials_paymentgatewayoptions.coinbase_code'), ['class'=>'control-label ']) !!}
                {!! Form::text('coinbase[secret]', $account->getGatewayConfigVal(config('attendize.payment_gateway_coinbase'), 'secret'),[ 'class'=>'form-control'])  !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('coinbase[accountId]', __('manageaccount_partials_paymentgatewayoptions.coinbase_account'), array('class'=>'control-label ')) !!}
                {!! Form::text('coinbase[accountId]', $account->getGatewayConfigVal(config('attendize.payment_gateway_coinbase'), 'accountId'),[ 'class'=>'form-control'])  !!}
            </div>
        </div>
    </div>


</section>

{{--Scellius--}}
<section class="payment_gateway_options"  id="gateway_{{config('attendize.payment_gateway_scellius')}}">
    <h4>@lang('manageaccount_partials_paymentgatewayoptions.scellius_settings')</h4>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('scellius[merchantId]', __('manageaccount_partials_paymentgatewayoptions.scellius_merchant_id'), array('class'=>'control-label ')) !!}
                {!! Form::text('scellius[merchantId]', $account->getGatewayConfigVal(config('attendize.payment_gateway_scellius'), 'merchantId'),[ 'class'=>'form-control'])  !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('scellius[merchantCountry]', __('manageaccount_partials_paymentgatewayoptions.scellius_merchant_country'), array('class'=>'control-label ')) !!}
                {!! Form::text('scellius[merchantCountry]', $account->getGatewayConfigVal(config('attendize.payment_gateway_scellius'), 'merchantCountry'),[ 'class'=>'form-control'])  !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('scellius[pathBinRequest]', __('manageaccount_partials_paymentgatewayoptions.scellius_pathbin_request'), array('class'=>'control-label ')) !!}
                {!! Form::text('scellius[pathBinRequest]', $account->getGatewayConfigVal(config('attendize.payment_gateway_scellius'), 'pathBinRequest'),[ 'class'=>'form-control'])  !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('scellius[pathBinResponse]', __('manageaccount_partials_paymentgatewayoptions.scellius_pathbin_response'), array('class'=>'control-label ')) !!}
                {!! Form::text('scellius[pathBinResponse]', $account->getGatewayConfigVal(config('attendize.payment_gateway_scellius'), 'pathBinResponse'),[ 'class'=>'form-control'])  !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('scellius[pathFile]', __('manageaccount_partials_paymentgatewayoptions.scellius_pathfile'), array('class'=>'control-label ')) !!}
                {!! Form::text('scellius[pathFile]', $account->getGatewayConfigVal(config('attendize.payment_gateway_scellius'), 'pathFile'),[ 'class'=>'form-control'])  !!}
            </div>
        </div>
    </div>

</section>

{{--BDO MIGS--}}
<section class="payment_gateway_options"  id="gateway_{{config('attendize.payment_gateway_migs')}}">
    <h4>@lang('manageaccount_partials_paymentgatewayoptions.mastercard_settings')</h4>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('migs[merchantAccessCode]', __('manageaccount_partials_paymentgatewayoptions.mastercard_code'), array('class'=>'control-label ')) !!}
                {!! Form::text('migs[merchantAccessCode]', $account->getGatewayConfigVal(config('attendize.payment_gateway_migs'), 'merchantAccessCode'),[ 'class'=>'form-control'])  !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('migs[merchantId]', __('manageaccount_partials_paymentgatewayoptions.mastercard_id'), ['class'=>'control-label ']) !!}
                {!! Form::text('migs[merchantId]', $account->getGatewayConfigVal(config('attendize.payment_gateway_migs'), 'merchantId'),[ 'class'=>'form-control'])  !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('migs[secureHash]', __('manageaccount_partials_paymentgatewayoptions.mastercard_hash'), array('class'=>'control-label ')) !!}
                {!! Form::text('migs[secureHash]', $account->getGatewayConfigVal(config('attendize.payment_gateway_migs'), 'secureHash'),[ 'class'=>'form-control'])  !!}
            </div>
        </div>
    </div>


</section>




<div class="row">
    <div class="col-md-12">
        <div class="panel-footer">
            {!! Form::submit(__('manageaccount_partials_paymentgatewayoptions.save'), ['class' => 'btn btn-success pull-right']) !!}
        </div>
    </div>
</div>


{!! Form::close() !!}
