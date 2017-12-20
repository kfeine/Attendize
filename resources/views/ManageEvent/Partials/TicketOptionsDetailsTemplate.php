<script id="ticket-option-template" type="text/x-handlebars-template">
        <input type="hidden" name="details[]" value="{{ number }}"> 
        <tr>
            <td>Titre : <input class="form-control" name="option[]" type="text"></td>
            <td>Description : <input class="form-control" name="option[]" type="text"></td>
            <td width="50">
                <i class="btn btn-danger ico-remove" onclick="removeTicketOptionsDetails(this);"></i>
            </td>
        </tr>

<div class="form-group">
                            {!! Form::label('title', __('manageevent_modals_createticketoption.category_name'), array('class'=>'control-label required')) !!}
                            {!! Form::text('title', Input::old('title'),
                                        array(
                                        'class'=>'form-control',
                                        'placeholder'=>__('manageevent_modals_createticketoption.category_name')
                                        )) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', __('manageevent_modals_createticketoption.description'), array('class'=>'control-label required')) !!}
                            {!! Form::text('description', Input::old('description'),
                                        array(
                                        'class'=>'form-control'
                                        )) !!}
                        </div>
    </script>
