@foreach($ticket->questions->where('is_enabled', 1)->sortBy('sort_order') as $question)
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label("ticket_holder_questions[{$ticket->id}][{$attendee_id}][$question->id]", $question->title, ['class' => $question->is_required ? 'required' : '']) !!}

            @if($question->question_type_id == config('attendize.question_textbox_single'))
                {!! Form::text("ticket_holder_questions[{$ticket->id}][{$attendee_id}][$question->id]", null, [$question->is_required ? 'required' : '' => $question->is_required ? 'required' : '', 'class' => "ticket_holder_questions.{$ticket->id}.{$attendee_id}.{$question->id}   form-control"]) !!}
            @elseif($question->question_type_id == config('attendize.question_textbox_multi'))
                {!! Form::textarea("ticket_holder_questions[{$ticket->id}][{$attendee_id}][$question->id]", null, ['rows'=>5, $question->is_required ? 'required' : '' => $question->is_required ? 'required' : '', 'class' => "ticket_holder_questions.{$ticket->id}.{$attendee_id}.{$question->id}  form-control"]) !!}
            @elseif($question->question_type_id == config('attendize.question_dropdown_single'))
                {!! Form::select("ticket_holder_questions[{$ticket->id}][{$attendee_id}][$question->id]", array_merge(['' => __('public_viewevent_partials_ticketoptions.select_one_option')], $question->options->pluck('name', 'name')->toArray()), null, [$question->is_required ? 'required' : '' => $question->is_required ? 'required' : '', 'class' => "ticket_holder_questions.{$ticket->id}.{$attendee_id}.{$question->id} form-control"]) !!}
            @elseif($question->question_type_id == config('attendize.question_datalist'))
                <input list="list_ticket_holder_questions.{{ $ticket->id }}.{{ $attendee_id }}.{{ $question->id }}" name="ticket_holder_questions[{{ $ticket->id }}][{{ $attendee_id }}][{{ $question->id }}]" id="ticket_holder_questions[{{ $ticket->id }}][{{ $attendee_id }}][{{ $question->id }}]" class="ticket_holder_questions.{{ $ticket->id }}.{{ $attendee_id }}.{{ $question->id }} form-control" {{ $question->is_required ? 'required' : '' }}>
                <datalist id="list_ticket_holder_questions.{{ $ticket->id }}.{{ $attendee_id }}.{{ $question->id }}">
                    @foreach($question->options as $option)
                    <option value="{{ $option->name }}">
                    @endforeach
                </datalist>
            @elseif($question->question_type_id == config('attendize.question_dropdown_multi'))
                {!! Form::select("ticket_holder_questions[{$ticket->id}][{$attendee_id}][$question->id][]",$question->options->pluck('name', 'name'), null, [$question->is_required ? 'required' : '' => $question->is_required ? 'required' : '', 'multiple' => 'multiple','class' => "ticket_holder_questions.{$ticket->id}.{$attendee_id}.{$question->id}   form-control"]) !!}
            @elseif($question->question_type_id == config('attendize.question_checkbox_multi'))
                <br>
                @foreach($question->options as $option)
                    <?php
                        $checkbox_id = md5($ticket->id.$attendee_id.$question->id.$option->name);
                    ?>
                    <div class="custom-checkbox">
                        {!! Form::checkbox("ticket_holder_questions[{$ticket->id}][{$attendee_id}][$question->id][]",$option->name, false,['class' => "ticket_holder_questions.{$ticket->id}.{$attendee_id}.{$question->id}  ", 'id' => $checkbox_id]) !!}
                        <label for="{{ $checkbox_id }}">{{$option->name}}</label>
                    </div>
                @endforeach
            @elseif($question->question_type_id == config('attendize.question_radio_single'))
                <br>
                @foreach($question->options as $option)
                    <?php
                    $radio_id = md5($ticket->id.$attendee_id.$question->id.$option->name);
                    ?>
                <div class="custom-radio">
                    {!! Form::radio("ticket_holder_questions[{$ticket->id}][{$attendee_id}][$question->id]",$option->name, false, ['id' => $radio_id, 'class' => "ticket_holder_questions.{$ticket->id}.{$attendee_id}.{$question->id}  "]) !!}
                    <label for="{{ $radio_id }}">{{$option->name}}</label>
                </div>
                @endforeach
            @endif

        </div>
    </div>
@endforeach
