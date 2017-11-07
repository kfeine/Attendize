<div role="dialog"  class="modal fade " style="display: none;">
    {!! Form::open(array('url' => route('postEditTicketOption', array('event_id' => $event->id, 'ticket_id' => $ticket->id, 'option_id' => $option->id)), 'class' => 'ajax')) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">
                    <i class="ico-ticket"></i>
                    __Option <em>{{$option->title}}</em></h3>
            </div>
            <div class="modal-body">
              <div class="form-group">
                  {!! Form::label('title', "__title", array('class'=>'control-label required')) !!}
                  {!!  Form::text('title', $option->title,
                     array(
                     'class'=>'form-control',
                     'placeholder'=>"__title"
                     ))  
                  !!}
              </div>
              <div class="form-group">
                  {!! Form::label('description', "__description", array('class'=>'control-label required')) !!}
                  {!!  Form::text('description', $option->description,
                     array(
                     'class'=>'form-control',
                     'placeholder'=>"__description"
                     ))  
                  !!}
              </div>
              <div class="row">
                  <div class="col-sm-6">
                      <div class="form-group">
                          {!! Form::label('price', "__prix", ['class'=>'control-label required']) !!}
                          {!!  Form::text('price', $option->price,['class' => 'form-control', 'placeholder' => "__prix"]) !!}
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
