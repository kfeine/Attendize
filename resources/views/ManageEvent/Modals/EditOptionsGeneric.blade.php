<div role="dialog"  class="modal fade " style="display: none;">
    {!! Form::open(array('url' => route('options_generic.update', array('event_id' => $event->id, 'options_generic' => $option->id)), 'class' => 'ajax')) !!}
    {{ method_field('PUT') }}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">
                    <i class="ico-ticket"></i>
                    @lang('manageevent_modals_editticketoptionsgeneric.option') <em>{{$option->title}}</em></h3>
            </div>
            <div class="modal-body">
              <div class="form-group">
                  {!! Form::label('title', __('manageevent_modals_editticketoptionsgeneric.title'), array('class'=>'control-label required')) !!}
                  {!! Form::text('title', $option->title,
                     array(
                     'class'=>'form-control',
                     'placeholder'=>__('manageevent_modals_editticketoptionsgeneric.title')
                     ))
                  !!}
              </div>
              <div class="form-group">
                  {!! Form::label('quantity_available', __('manageevent_modals_editticketoptionsgeneric.quantity'), array('class'=>' control-label')) !!}
                  {!!  Form::text('quantity_available', $option->quantity_available,
                        array(
                        'class'=>'form-control',
                        'placeholder'=>__('manageevent_modals_editticketoptionsgeneric.quantity_placeholder'),
                        ))  !!}
              </div>
            </div> <!-- /end modal body-->
            <div class="modal-footer">
               {!! Form::button(__('manageevent_modals_editticketoptionsgeneric.close'), ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
               {!! Form::submit(__('manageevent_modals_editticketoptionsgeneric.save'), ['class'=>"btn btn-success"]) !!}
            </div>
        </div><!-- /end modal content-->
       {!! Form::close() !!}
    </div>
</div>
