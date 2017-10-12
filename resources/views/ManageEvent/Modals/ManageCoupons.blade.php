<div role="dialog"  class="modal fade " style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">
                    <i class="ico-question"></i>
                    @lang('manageevent_modals_managecoupons.coupons')</h3>
            </div>
            <div class="modal-body">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#QuestionsAccordion" href="#collapse{{$i}}" class="collapsed">
                                <span class="arrow mr5"></span> @lang('manageevent_modals_managecoupons.age')
                            </a>
                        </h4>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="required">
                                        @lang('manageevent_modals_managecoupons.question')
                                    </label>
                                    <input placeholder="@lang('manageevent_modals_managecoupons.placeholder_name')" class="form-control" type="text" name="title" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>
                                        @lang('manageevent_modals_managecoupons.type')
                                    </label>
                                    <select class="form-control" name="question_type_id">
                                        <option value="1">
                                            @lang('manageevent_modals_managecoupons.text')
                                        </option>
                                        <option value="2">
                                            @lang('manageevent_modals_managecoupons.list')
                                        </option>
                                        <option value="3">
                                            @lang('manageevent_modals_managecoupons.checkbox')
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>
                                        @lang('manageevent_modals_managecoupons.instructions')
                                    </label>
                                    <input class="form-control" type="text" name="instructions" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>
                                        @lang('manageevent_modals_managecoupons.options')
                                    </label>
                                    <input placeholder="e.g option 1, option 2, option 3" class="form-control" type="text" name="options" />
                                    <div class="help-block">
                                        @lang('manageevent_modals_managecoupons.help')
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <span class="checkbox custom-checkbox">
                                        <input type="checkbox" id="requiredq" value="option1">
                                        <label for="requiredq">@lang('manageevent_modals_managecoupons.required')</label>
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="panel-footer">
                        <div class="form-group no-border">
                            <div class="col-sm-12">
                                <button  class="btn btn-danger deleteThis float-right">@lang('manageevent_modals_managecoupons.delete')</button>
                                <button type="submit" class="btn btn-success float-right">@lang('manageevent_modals_managecoupons.save')</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- /end modal body-->
            <div class="modal-footer">
                <a href="" class="btn btn-danger" data-dismiss="modal">
                    @lang('manageevent_modals_managecoupons.close')
                </a>
                <a href="" class="btn btn-success">
                    @lang('manageevent_modals_managecoupons.create')
                </a>
                <button data-modal-id="CreateTicket" href="javascript:void(0);"  data-href="{{route('showCreateTicket', array('event_id'=>$event->id))}}" class="loadModal btn btn-success" type="button" ><i class="ico-ticket"></i> @lang('manageevent_modals_managecoupons.create_ticket')</button>
            </div>
        </div><!-- /end modal content-->
    </div>
</div>
