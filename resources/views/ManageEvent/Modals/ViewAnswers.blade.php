<div role="dialog" class="modal fade" style="display: ;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">
                    @lang('manageevent_modals_viewanswers.title_questions', ['title' => $question->title ])
                </h3>
            </div>

            @if(count($answers))
            <div class="table-responsive">
                           <table class="table">
                               <thead>
                               <tr>
                                   <th>
                                       @lang('manageevent_modals_viewanswers.details')
                                   </th>
                                   <th>
                                       @lang('manageevent_modals_viewanswers.ticket')
                                   </th>
                                   <th>
                                       @lang('manageevent_modals_viewanswers.answer')
                                   </th>
                               </tr>

                               </thead>
                               <tbody>
                               @foreach($answers as $answer)
                                   <tr>
                                       <td>

                                           {{ $answer->attendee->full_name }}
                                           @if($answer->attendee->is_cancelled)
                                               (<span title="This attendee has been cancelled" class="text-danger">@lang('manageevent_modals_viewanswers.cancelled')</span>)
                                           @endif<br>
                                           <a title="Go to attendee: {{ $answer->attendee->full_name }}" href="{{route('showEventAttendees', ['event_id' => $answer->attendee->event_id, 'q' => $answer->attendee->getReferenceAttribute()])}}">{{ $answer->attendee->getReferenceAttribute() }}</a><br>

                                       </td>
                                       <td>
                                           {{ $answer->attendee->ticket->title }}
                                       </td>
                                       <td>
                                           {!! nl2br(e($answer->answer_text)) !!}
                                       </td>
                                   </tr>
                               @endforeach
                               </tbody>
                           </table>

                       </div>
            @else
                <div class="modal-body">
                    <div class="alert alert-info">
                        @lang('manageevent_modals_viewanswers.alert')
                    </div>
                </div>

            @endif

            <div class="modal-footer">
                {!! Form::button(__('manageevent_modals_viewanswers.close'), ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
            </div>
        </div><!-- /end modal content-->
    </div>
</div>
