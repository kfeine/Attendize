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
                  {!! Form::label('title', __('manageevent_modals_editticketoptions.name'), array('class'=>'control-label required')) !!}
                  {!! Form::text('title', $option->title,
                     array(
                     'class'=>'form-control',
                     'placeholder'=>__('manageevent_modals_editticketoptions.name')
                     ))
                  !!}
              </div>
              <div class="form-group">
                  {!! Form::label('description', __('manageevent_modals_editticketoptions.description'), array('class'=>'control-label required')) !!}
                  {!! Form::text('description', $option->description,
                     array(
                     'class'=>'form-control',
                     'placeholder'=>__('manageevent_modals_editticketoptions.description')
                     ))
                  !!}
              </div>
              <div class="row">
                  <div class="col-sm-6">
                      <div class="form-group">
                          {!! Form::label('price', __('manageevent_modals_editticketoptions.price'), ['class'=>'control-label required']) !!}
                          {!! Form::text('price', $option->price,['class' => 'form-control', 'placeholder' => __('manageevent_modals_editticketoptions.price')]) !!}
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-sm-6">
                      <div class="form-group">
                          {!! Form::checkbox('multiple', 1, $option->multiple) !!}
                          {!! Form::label('multiple', __('manageevent_modals_editticketoptions.multiple'), ['class'=>'control-label required']) !!}
                      </div>
                  </div>
              </div>
            </div> <!-- /end modal body-->
            <div class="modal-footer">
               {!! Form::button("__close", ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
               {!! Form::submit("__enregistrer", ['class'=>"btn btn-success"]) !!}
            </div>
        </div><!-- /end modal content-->
       {!! Form::close() !!}
    </div>
</div>
