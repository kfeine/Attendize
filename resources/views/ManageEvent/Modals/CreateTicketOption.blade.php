<div role="dialog"  class="modal fade" style="display: none;">
   {!! Form::open(array('url' => route('postCreateTicketOption', array('event_id' => $event->id, 'ticket_id' => $ticket->id)), 'class' => 'ajax')) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">
                    <i class="ico-ticket"></i>
                    @lang('manageevent_modals_createticketoption.create_option')</h3>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::label('title', __('manageevent_modals_createticketoption.block_name'), array('class'=>'control-label required')) !!}
                    {!! Form::text('title', Input::old('title'),
                                array(
                                'class'=>'form-control',
                                'placeholder'=>__('manageevent_modals_createticketoption.block_name')
                                )) !!}
                </div>
                <div class="form-group">
                  {!! Form::label('description', __('manageevent_modals_createticketoption.description'), array('class'=>'control-label')) !!}
                  {!! Form::textarea('description', Input::old('description'),
                     array(
                     'class'=>'form-control',
                     'placeholder'=>__('manageevent_modals_createticketoption.description')
                     ))
                  !!}
                </div>
                <div class="form-group">
                    {!! Form::label('block_order', __('manageevent_modals_createticketoption.block_order'), array('class'=>'control-label')) !!}
                    {!! Form::number('block_order', Null,
                       array(
                       'class'=>'form-control',
                       'placeholder'=>__('manageevent_modals_createticketoption.block_order')
                       ))
                    !!}
                </div>
                <div class="form-group">
                    <label for="ticket-options-type">
                        @lang('manageevent_modals_createticketoption.option_type')
                    </label>

                    <select id="ticket-options-type" class="form-control" name="ticket_options_type_id"
                            onchange="changeTicketOptionsType(this);">
                        @foreach ($ticket_options_types as $option_type)
                            <option data-has-options="{{$option_type->has_options}}" value="{{$option_type->id}}">
                                {{$option_type->name}}
                            </option>
                        @endforeach
                    </select>
                </div>

                <fieldset id="ticket-options">
                    <h4>@lang('manageevent_modals_createticketoption.options_details')</h4>
                    <table class="table table-bordered table-condensed">
                        <tbody>
                        <tr>
                            <td>{!! Form::hidden('details[]', "1") !!}
                                {!! Form::label("details_1_title", __('manageevent_modals_createticketoption.title')) !!}
                                {!! Form::text("details_1_title", null, ['required' => 'required', 'class' => "form-control"]) !!}
                                {!! Form::label("details_1_price", __('manageevent_modals_createticketoption.price')) !!}
                                {!! Form::text("details_1_price", null, ['required' => 'required', 'class' => "form-control"]) !!}
                                {!! Form::label("details_1_option_order", __('manageevent_modals_editticketoptions.option_order')) !!}
                                {!! Form::number("details_1_option_order", null, ['class' => "form-control"]) !!}
                            </td>
                            <td width="50">
                                <i class="btn btn-danger ico-remove" onclick="removeTicketOptionsDetails(this);"></i>
                            </td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="2">
                                           <span id="add-ticket-options-details" class="btn btn-success btn-xs"
                                                 onclick="addTicketOptionsDetails();">
                                               <i class="ico-plus"></i>
                                               @lang('manageevent_modals_createticketoption.another')
                                           </span>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </fieldset>

                <div class="form-group">
                    <div class="custom-checkbox">
                        {!! Form::checkbox('is_required', 'yes', false, ['data-toggle' => 'toggle', 'id' => 'is_required']) !!}
                        {!! Form::label('is_required', __('manageevent_modals_createticketoption.required_option')) !!}
                    </div>
                </div>

            </div> <!-- /end modal body-->
            <div class="modal-footer">
               {!! Form::button(__('manageevent_modals_createticketoption.close'), ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
               {!! Form::submit(__('manageevent_modals_createticketoption.create'), ['class'=>"btn btn-success"]) !!}
            </div>
        </div><!-- /end modal content-->
       {!! Form::close() !!}
    </div>
</div>

<script>
  function getFormTicketDetails(number){

      return ` 
        <tr>
            <td>{!! Form::hidden('details[]', "`+number+`") !!}
                {!! Form::label("details_`+number+`_title", __('manageevent_modals_createticketoption.title')) !!}
                {!! Form::text("details_`+number+`_title", null, ['required' => 'required', 'class' => "form-control"]) !!}
                {!! Form::label("details_`+number+`_price", __('manageevent_modals_createticketoption.price')) !!}
                {!! Form::text("details_`+number+`_price", null, ['required' => 'required', 'class' => "form-control"]) !!}
                {!! Form::label("details_`+number+`_option_order", __('manageevent_modals_editticketoptions.option_order')) !!}
                {!! Form::number("details_`+number+`_option_order", null, ['class' => "form-control"]) !!}
            </td>
            <td width="50">
                <i class="btn btn-danger ico-remove" onclick="removeTicketOptionsDetails(this);"></i>
            </td>
        </tr>`; 
  }
</script>
