@foreach ($tickets as $ticket)
    <div class="ticket-options ticket-options-{{$ticket->id}} {{$loop->first?"":"hide"}} form-group">
        @foreach ($ticket->options_enabled as $option)
            <div class="form-group">
                {!! Form::label("attendee_{$numAttendee}_ticket_{$ticket->id}_options_$option->id", $option->title, ['class' => $option->is_required ? 'required' : '']) !!}
                @if($option->description)
                <br/>
                <small class="form-text text-muted">{!!$option->description!!}</small>
                @endif
                @if($option->ticket_options_type_id == config('attendize.ticket_options_dropdown_single') or $option->ticket_options_type_id == config('attendize.ticket_options_dropdown_multi'))
                    <select 
                        id="attendee_{{$numAttendee}}_ticket_{{$ticket->id}}_options_{{$option->id}}" 
                        name="attendee_{{$numAttendee}}_ticket_{{$ticket->id}}_options_{{$option->id}}" 
                        class="{!! $option->is_required ? 'required form-control' : 'form-control'!!}" 
                        {!!$option->is_required ? 'required="required"' : ''!!}
                        {!!$option->ticket_options_type_id == config('attendize.ticket_options_dropdown_multi') ?'multiple="multiple"' : ""!!}
                    >
                        <option>@lang('public_viewevent_partials_ticketoptions.select_one_option')</option>
                        @foreach ($option->options_enabled as $detail)
                            <option value="{!!$detail->id!!}" {!! $detail->isRemaining() ? '' : 'disabled'!!}>{{$detail->title_with_price}} {!! $detail->isRemaining() ? '' : " (".__('public_viewevent_partials_ticketoptions.exhausted').")"!!}</option>
                        @endforeach
                    </select>
                @elseif($option->ticket_options_type_id == config('attendize.ticket_options_checkbox_multi'))
                    <br>
                    @foreach($option->options_enabled as $detail)
                        <?php
                            $checkbox_id = $numAttendee."_".md5($ticket->id.$option->id.$detail->title);
                        ?>
                        <div class="custom-checkbox">
                            {!! Form::checkbox("attendee_{$numAttendee}_ticket_{$ticket->id}_options_$option->id[]", $detail->id, $detail->default_value, ['id' => $checkbox_id, "onclick" => $detail->is_forced ? "return false;" : "", $detail->isRemaining() ? "":"disabled" ]) !!}
                            <label for="{{ $checkbox_id }}" {!! ($detail->is_forced or !$detail->isRemaining()) ? 'class=disabled' : '' !!}>{{ $detail->title_with_price }} {!! $detail->isRemaining() ? '' : " (".__('public_viewevent_partials_ticketoptions.exhausted').")"!!}</label>
                        </div>
                    @endforeach
                @elseif($option->ticket_options_type_id == config('attendize.ticket_options_radio_single'))
                    <br>
                    @foreach($option->options_enabled as $detail)
                        <?php
                            $radio_id = $numAttendee."_".md5($ticket->id.$option->id.$detail->title);
                        ?>
                    <div class="custom-radio">
                        {!! Form::radio("attendee_{$numAttendee}_ticket_{$ticket->id}_options_$option->id",$detail->id, false, ['id' => $radio_id, 'class' => "", $detail->isRemaining() ? "":"disabled" ]) !!}
                        <label for="{{ $radio_id }}" {!! ($detail->is_forced or !$detail->isRemaining()) ? 'class=disabled' : '' !!}>{{$detail->title_with_price}} {!! $detail->isRemaining() ? '' : " (".__('public_viewevent_partials_ticketoptions.exhausted').")"!!}</label>
                    </div>
                    @endforeach
                @endif
            </div>
        @endforeach
    </div>
@endforeach
