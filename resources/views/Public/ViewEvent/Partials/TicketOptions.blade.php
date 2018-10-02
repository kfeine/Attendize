@foreach ($tickets as $ticket)
    <div class="ticket-options ticket-options-{{$ticket->id}} {{$loop->first?"":"hide"}} form-group">
        @foreach ($ticket->options_enabled as $option)
            <div class="form-group">
                {!! Form::label("attendee_{$numAttendee}_ticket_{$ticket->id}_options_$option->id", $option->title, ['class' => $option->is_required ? 'required' : '']) !!}
                @if($option->description)
                <br/>
                <small class="form-text text-muted">{!!$option->description!!}</small>
                @endif
                @if($option->ticket_options_type_id == config('attendize.ticket_options_dropdown_single'))
                    {!! Form::select("attendee_{$numAttendee}_ticket_{$ticket->id}_options_$option->id", array('' => __('public_viewevent_partials_ticketoptions.select_one_option')) + $option->options_enabled->pluck('title_with_price', 'id')->toArray(), null, ['class' =>  $option->is_required ? 'required form-control' : 'form-control', $option->is_required ? 'required' : '' => $option->is_required ? 'required' : '']) !!}
                @elseif($option->ticket_options_type_id == config('attendize.ticket_options_dropdown_multi'))
                    {!! Form::select("attendee_{$numAttendee}_ticket_{$ticket->id}_options_$option->id",$option->options->pluck('title_with_price', 'id'), null, [$option->is_required ? 'required' : '' => $option->is_required ? 'required' : '', 'multiple' => 'multiple','class' => $option->is_required ? 'required form-control' : 'form-control']) !!}
                @elseif($option->ticket_options_type_id == config('attendize.ticket_options_checkbox_multi'))
                    <br>
                    @foreach($option->options_enabled as $detail)
                        <?php
                            $checkbox_id = $numAttendee."_".md5($ticket->id.$option->id.$detail->title);
                        ?>
                        <div class="custom-checkbox">
                            {!! Form::checkbox("attendee_{$numAttendee}_ticket_{$ticket->id}_options_$option->id[]", $detail->id, $detail->default_value, ["disabled" => $detail->is_forced ? true : false, 'id' => $checkbox_id]) !!}
                            <label for="{{ $checkbox_id }}" {{ $detail->is_forced ? 'class=disabled' : '' }}>{{ $detail->title_with_price }}</label>
                        </div>
                    @endforeach
                @elseif($option->ticket_options_type_id == config('attendize.ticket_options_radio_single'))
                    <br>
                    @foreach($option->options_enabled as $detail)
                        <?php
                            $radio_id = $numAttendee."_".md5($ticket->id.$option->id.$detail->title);
                        ?>
                    <div class="custom-radio">
                        {!! Form::radio("attendee_{$numAttendee}_ticket_{$ticket->id}_options_$option->id",$detail->id, false, ['id' => $radio_id, 'class' => ""]) !!}
                        <label for="{{ $radio_id }}">{{$detail->title_with_price}}</label>
                    </div>
                    @endforeach
                @endif
            </div>
        @endforeach
    </div>
@endforeach
