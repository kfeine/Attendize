<div role="dialog"  class="modal fade " style="display: none;">
    {!! Form::open(array('url' => route('postEditTicketOption', array('event_id' => $event->id, 'ticket_id' => $ticket->id, 'option_id' => $option->id)), 'class' => 'ajax')) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">
                    <i class="ico-ticket"></i>
                    @lang('manageevent_modals_editticketoptions.option') <em>{{$option->title}}</em></h3>
            </div>
            <div class="modal-body">
              <div class="form-group">
                  {!! Form::label('title', __('manageevent_modals_editticketoptions.block_name'), array('class'=>'control-label required')) !!}
                  {!! Form::text('title', $option->title,
                     array(
                     'class'=>'form-control',
                     'placeholder'=>__('manageevent_modals_editticketoptions.block_name')
                     ))
                  !!}
              </div>
              <div class="form-group">
                  {!! Form::label('description', __('manageevent_modals_editticketoptions.description'), array('class'=>'control-label')) !!}
                  {!! Form::textarea('description', $option->description,
                     array(
                     'class'=>'form-control',
                     'placeholder'=>__('manageevent_modals_editticketoptions.description')
                     ))
                  !!}
              </div>
              <div class="form-group">
                  {!! Form::label('block_order', __('manageevent_modals_editticketoptions.block_order'), array('class'=>'control-label')) !!}
                  {!! Form::number('block_order', $option->block_order,
                     array(
                     'class'=>'form-control',
                     'placeholder'=>__('manageevent_modals_editticketoptions.block_order')
                     ))
                  !!}
              </div>
              <div class="form-group">
                    <label for="ticket-options-type">
                        @lang('manageevent_modals_editticketoptions.option_type')
                    </label>

                    <select id="ticket-options-type" class="form-control" name="ticket_options_type_id"
                            onchange="changeTicketOptionsType(this);">
                        @foreach ($ticket_options_types as $option_type)
                            <option data-has-options="{{$option_type->has_options}}" value="{{$option_type->id}}" {{$option->ticket_options_type_id == $option_type->id ? "selected" : ""}}>
                                {{$option_type->name}}
                            </option>
                        @endforeach
                    </select>
              </div>
              <fieldset id="ticket-options">
                    <h4>@lang('manageevent_modals_editticketoptions.options_details')</h4>
                    <table class="table table-bordered table-condensed">
                        <tbody>
                        @foreach($details as $detail)
                        <tr>
                            <td>
                                {!! Form::hidden('details[]', $detail->id) !!}
                                {!! Form::label("details_".$detail->id."_title", __('manageevent_modals_editticketoptions.title')) !!}
                                {!! Form::text("details_".$detail->id."_title", $detail->title, ['required' => 'required', 'class' => "form-control"]) !!}
                                {!! Form::label("details_".$detail->id."_price", __('manageevent_modals_editticketoptions.price')) !!}
                                {!! Form::text("details_".$detail->id."_price", $detail->price, ['required' => 'required', 'class' => "form-control"]) !!}
                                <div class="custom-checkbox">
                                {!! Form::checkbox("details_".$detail->id."_is_forced", "yes", $detail->is_forced, ['data-toggle' => 'toggle', 'id' => "details_".$detail->id."_is_forced"]) !!}
                                {!! Form::label("details_".$detail->id."_is_forced", __('manageevent_modals_editticketoptions.is_forced')) !!}
                                </div>
                                <div class="custom-checkbox">
                                {!! Form::checkbox("details_".$detail->id."_default_value", "yes", $detail->default_value, ['data-toggle' => 'toggle', 'id' => "details_".$detail->id."_default_value"]) !!}
                                {!! Form::label("details_".$detail->id."_default_value", __('manageevent_modals_editticketoptions.default_value')) !!}
                                </div>
                                {!! Form::text("details_".$detail->id."_price", $detail->price, ['required' => 'required', 'class' => "form-control"]) !!}
                                {!! Form::label("details_".$detail->id."_option_order", __('manageevent_modals_editticketoptions.option_order')) !!}
                                {!! Form::number("details_".$detail->id."_option_order", $detail->option_order, ['class' => "form-control"]) !!}
                            </td>
                            <td width="50">
                                <i class="btn btn-danger ico-remove" onclick="removeTicketOptionsDetails(this);"></i> <br>
                                <a class="btn btn-primary enableTicketOptionDetail" href="javascript:void(0);" data-route="{{ route('postEnableTicketOptionDetail', ['event_id' => $event->id, 'ticket_id' => $ticket->id, 'option_id'=>$option->id, 'option_detail_id'=>$detail->id]) }}" data-id="{{ $detail->id }}">
                                      @if($detail->is_enabled)
                                          <i class="ico-pause"></i>
                                      @else
                                          <i class="ico-play4"></i>
                                      @endif
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="2">
                                           <span id="add-ticket-options-details" class="btn btn-success btn-xs"
                                                 onclick="addTicketOptionsDetails();">
                                               <i class="ico-plus"></i>
                                               @lang('manageevent_modals_editticketoptions.another')
                                           </span>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </fieldset>
                <div class="form-group">
                    <div class="custom-checkbox">
                        {!! Form::checkbox('is_required', 'yes', $option->is_required, ['data-toggle' => 'toggle', 'id' => 'is_required']) !!}
                        {!! Form::label('is_required', __('manageevent_modals_editticketoptions.required_option')) !!}
                    </div>
                </div>
            </div> <!-- /end modal body-->
            <div class="modal-footer">
               {!! Form::button(__('manageevent_modals_editticketoptions.close'), ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
               {!! Form::submit(__('manageevent_modals_editticketoptions.save'), ['class'=>"btn btn-success"]) !!}
            </div>
        </div><!-- /end modal content-->
       {!! Form::close() !!}
    </div>
</div>

<script>
  function getFormTicketDetails(number){

      return `
        <tr>
        <td>
                {!! Form::hidden('details[]', "`+number+`") !!}
                {!! Form::label("details_`+number+`_title", __('manageevent_modals_createticketoption.title')) !!}
                {!! Form::text("details_`+number+`_title", null, ['required' => 'required', 'class' => "form-control"]) !!}
                {!! Form::label("details_`+number+`_price", __('manageevent_modals_createticketoption.price')) !!}
                {!! Form::text("details_`+number+`_price", null, ['required' => 'required', 'class' => "form-control"]) !!}
                <div class="custom-checkbox">
                    {!! Form::checkbox("details_`+number+`_is_forced", "yes", null, ['data-toggle' => 'toggle', 'id' => "details_`+number+`_is_forced"]) !!}
                    {!! Form::label("details_`+number+`_is_forced", __('manageevent_modals_editticketoptions.is_forced')) !!}
                </div>
                <div class="custom-checkbox">
                    {!! Form::checkbox("details_`+number+`_default_value", "yes", null, ['data-toggle' => 'toggle', 'id' => "details_`+number+`_default_value"]) !!}
                    {!! Form::label("details_`+number+`_default_value", __('manageevent_modals_createticketoption.default_value')) !!}
                </div>
                {!! Form::label("details_`+number+`_option_order", __('manageevent_modals_editticketoptions.option_order')) !!}
                {!! Form::number("details_`+number+`_option_order", null, ['class' => "form-control"]) !!}
            </td>
            <td width="50">
                <i class="btn btn-danger ico-remove" onclick="removeTicketOptionsDetails(this);"></i>
            </td>
        </tr>`;
  }
</script>
