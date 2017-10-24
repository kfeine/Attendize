@include('ManageOrganiser.Partials.EventCreateAndEditJS')

{!! Form::model($event, array('url' => route('postEditEvent', ['event_id' => $event->id]), 'class' => 'ajax gf')) !!}

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('is_live', __('manageevent_partials_editeventform.visibility'), array('class'=>'control-label required')) !!}
            {!!  Form::select('is_live', [
            '1' => __('manageevent_partials_editeventform.make_visible'),
            '0' => __('manageevent_partials_editeventform.hide')],null,
                                        array(
                                        'class'=>'form-control'
                                        ))  !!}
        </div>
        <div class="form-group">
            {!! Form::label('title', __('manageevent_partials_editeventform.title'), array('class'=>'control-label required')) !!}
            {!!  Form::text('title', Input::old('title'),
                                        array(
                                        'class'=>'form-control',
                                        'placeholder'=> __('manageevent_partials_editeventform.placeholder_title', ['firstname' => Auth::user()->first_name])
                                        ))  !!}
        </div>

        <div class="form-group">
           {!! Form::label('description', __('manageevent_partials_editeventform.description'), array('class'=>'control-label')) !!}
            {!!  Form::textarea('description', Input::old('description'),
                                        array(
                                        'class'=>'form-control editable',
                                        'rows' => 5
                                        ))  !!}
        </div>

        <div class="form-group address-automatic" style="display:{{$event->location_is_manual ? 'none' : 'block'}};">
            {!! Form::label('name', __('manageevent_partials_editeventform.venue_name'), array('class'=>'control-label required ')) !!}
            {!!  Form::text('venue_name_full', Input::old('venue_name_full'),
                                        array(
                                        'class'=>'form-control geocomplete location_field',
                                        'placeholder'=>__('manageevent_partials_editeventform.placeholder_venue')
                                        ))  !!}

            <!--These are populated with the Google places info-->
            <div>
               {!! Form::hidden('formatted_address', $event->location_address, ['class' => 'location_field']) !!}
               {!! Form::hidden('street_number', $event->location_street_number, ['class' => 'location_field']) !!}
               {!! Form::hidden('country', $event->location_country, ['class' => 'location_field']) !!}
               {!! Form::hidden('country_short', $event->location_country_short, ['class' => 'location_field']) !!}
               {!! Form::hidden('place_id', $event->location_google_place_id, ['class' => 'location_field']) !!}
               {!! Form::hidden('name', $event->venue_name, ['class' => 'location_field']) !!}
               {!! Form::hidden('location', '', ['class' => 'location_field']) !!}
               {!! Form::hidden('postal_code', $event->location_post_code, ['class' => 'location_field']) !!}
               {!! Form::hidden('route', $event->location_address_line_1, ['class' => 'location_field']) !!}
               {!! Form::hidden('lat', $event->location_lat, ['class' => 'location_field']) !!}
               {!! Form::hidden('lng', $event->location_long, ['class' => 'location_field']) !!}
               {!! Form::hidden('administrative_area_level_1', $event->location_state, ['class' => 'location_field']) !!}
               {!! Form::hidden('sublocality', '', ['class' => 'location_field']) !!}
               {!! Form::hidden('locality', $event->location_address_line_1, ['class' => 'location_field']) !!}
            </div>
            <!-- /These are populated with the Google places info-->

        </div>

        <div class="address-manual" style="display:{{$event->location_is_manual ? 'block' : 'none'}};">
            <div class="form-group">
                {!! Form::label('location_venue_name', __('manageevent_partials_editeventform.venue_name'), array('class'=>'control-label required ')) !!}
                {!!  Form::text('location_venue_name', $event->venue_name, [
                                        'class'=>'form-control location_field',
                                        'placeholder'=>__('manageevent_partials_editeventform.placeholder_venue')
                            ])  !!}
            </div>
            <div class="form-group">
                {!! Form::label('location_address_line_1', __('manageevent_partials_editeventform.address1'), array('class'=>'control-label')) !!}
                {!!  Form::text('location_address_line_1', $event->location_address_line_1, [
                                        'class'=>'form-control location_field',
                                        'placeholder'=>__('manageevent_partials_editeventform.placeholder_address1')
                            ])  !!}
            </div>
            <div class="form-group">
                {!! Form::label('location_address_line_2', __('manageevent_partials_editeventform.address2'), array('class'=>'control-label')) !!}
                {!!  Form::text('location_address_line_2', $event->location_address_line_2, [
                                        'class'=>'form-control location_field',
                                        'placeholder'=>__('manageevent_partials_editeventform.placeholder_address2')
                            ])  !!}
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('location_state', __('manageevent_partials_editeventform.city'), array('class'=>'control-label')) !!}
                        {!!  Form::text('location_state', $event->location_state, [
                                        'class'=>'form-control location_field',
                                        'placeholder'=>__('manageevent_partials_editeventform.placeholder_city')
                            ])  !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('location_post_code', __('manageevent_partials_editeventform.postcode'), array('class'=>'control-label')) !!}
                        {!!  Form::text('location_post_code', $event->location_post_code, [
                                        'class'=>'form-control location_field',
                                        'placeholder'=>__('manageevent_partials_editeventform.placeholder_postcode')
                            ])  !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix" style="margin-top:-10px; padding: 5px; padding-top: 0px;">
            <span class="pull-right">
                @lang('manageevent_partials_editeventform.or') <a data-clear-field=".location_field" data-toggle-class=".address-automatic, .address-manual" data-show-less-text="{{$event->location_is_manual ? __('manageevent_partials_editeventform.manually') : __('manageevent_partials_editeventform.select')}}" href="javascript:void(0);" class="show-more-options clear_location">{{$event->location_is_manual ? __('manageevent_partials_editeventform.select_existing') : __('manageevent_partials_editeventform.enter_address')}}</a>
            </span>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    {!! Form::label('start_date', __('manageevent_partials_editeventform.start'), array('class'=>'required control-label')) !!}
                    {!!  Form::text('start_date', $event->getFormattedDate('start_date'),
                                                        [
                                                    'class'=>'form-control start hasDatepicker ',
                                                    'data-field'=>'datetime',
                                                    'data-startend'=>'start',
                                                    'data-startendelem'=>'.end',
                                                    'readonly'=>''

                                                ])  !!}
                </div>
            </div>

            <div class="col-sm-6 ">
                <div class="form-group">
                    {!!  Form::label('end_date', __('manageevent_partials_editeventform.end'),
                                        [
                                    'class'=>'required control-label '
                                ])  !!}
                    {!!  Form::text('end_date', $event->getFormattedDate('end_date'),
                                                [
                                            'class'=>'form-control end hasDatepicker ',
                                            'data-field'=>'datetime',
                                            'data-startend'=>'end',
                                            'data-startendelem'=>'.start',
                                            'readonly'=>''
                                        ])  !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                   {!! Form::label('event_image', __('manageevent_partials_editeventform.event_flyer'), array('class'=>'control-label ')) !!}
                   {!! Form::styledFile('event_image', 1) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="float-l">
                    @if($event->images->count())
                    {!! Form::label('', __('manageevent_partials_editeventform.current_event_flyer'), array('class'=>'control-label ')) !!}
                    <div class="form-group">
                        <div class="well well-sm well-small">
                           {!! Form::label('remove_current_image', __('manageevent_partials_editeventform.delete'), array('class'=>'control-label ')) !!}
                           {!! Form::checkbox('remove_current_image') !!}

                        </div>
                    </div>
                    <div class="thumbnail">
                       {!!HTML::image('/'.$event->images->first()['image_path'])!!}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="panel-footer mt15 text-right">
           {!! Form::hidden('organiser_id', $event->organiser_id) !!}
           {!! Form::submit(__('manageevent_partials_editeventform.save'), ['class'=>"btn btn-success"]) !!}
        </div>
    </div>
    {!! Form::close() !!}
</div>
