<?php use App\Libraries\Constants; ?>
<script>
    $(function(){
        $('div.btn-group[data-toggle-name]').each(function () {
            var group = $(this);
            var form = $('#condition_form').eq(0);
            var name = group.attr('data-toggle-name');
            var hidden = $('input[name="' + name + '"]', form);
            $('button', group).each(function () {
                var button = $(this);
                button.on('click', function () {
                    hidden.val($(this).val());
                    $('button',group).removeClass('active');
                    if (button.val() == hidden.val()) {
                        button.addClass('active');
                    }
                });
                if (button.val() == hidden.val()) {
                    button.addClass('active');
                }
            });
        });
    });
</script>
<div class="box box-solid box-warning" id="rule_form">
    <div class="box-header">
        <h4 class="box-title panel-title"><i class="fa fa-cogs"></i> {{ isset($params['_id']) && $params['_id']?Lang::get('app.edit_condition'):Lang::get('app.create_condition_new')}}</h4>
        <div class="box-tools pull-right">
            <button class="btn btn-warning btn-xs" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-warning btn-xs" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
    {!! Form::open(array('method' => 'POST', 'role' => 'form', 'id' => 'condition_form')) !!}
    <div class="box-body">
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    {!! Form::label('name', Lang::get('app.name'), array('class' => 'control-label')) !!}
                    {!! Form::text('name',isset($params['name'])?$params['name']:'',array('class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('description', Lang::get('app.description'), array('class' => 'control-label')) !!}
                    {!! Form::textarea('description',isset($params['description'])?$params['description']:'',array('rows'=>4,'class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-lg-8">
                <div class="form-group row">
                    <div class="col-lg-4">
                        {!! Form::label('odd_type', Lang::get('app.fulltime'), array('class' => 'control-label')) !!}
                        <div class="btn-block btn-group" data-toggle-name="odd_type" data-toggle="buttons-radio">
                            <button type="button" value="{{Constants::ODD_1X2}}" data-toggle="button" class="btn btn-primary">{{Lang::get('app.odd_1x2')}}</button>
                            <button type="button" value="{{Constants::ODD_AH}}" data-toggle="button"class="btn btn-primary">{{Lang::get('app.odd_ah')}}</button>
                            <button type="button" value="{{Constants::ODD_OU}}" data-toggle="button"class="btn btn-primary">{{Lang::get('app.odd_ou')}}</button>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        {!! Form::label('odd_type', Lang::get('app.halftime'), array('class' => 'control-label')) !!}
                        <div class="btn-block btn-group" data-toggle-name="odd_type" data-toggle="buttons-radio">
                            <button type="button" value="{{Constants::ODD_1X21ST}}" data-toggle="button" class="btn btn-primary">{{Lang::get('app.odd_1x2')}}</button>
                            <button type="button" value="{{Constants::ODD_AH1ST}}" data-toggle="button"class="btn btn-primary">{{Lang::get('app.odd_ah')}}</button>
                            <button type="button" value="{{Constants::ODD_OU1ST}}" data-toggle="button"class="btn btn-primary">{{Lang::get('app.odd_ou')}}</button>
                        </div>
                    </div>
                    {!! Form::hidden('odd_type',isset($params['odd_type'])?$params['odd_type']:Constants::ODD_1X2,array('class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('time', Lang::get('app.time'), array('class' => 'control-label')) !!}
                    <div class="btn-group btn-block" data-toggle-name="time" data-toggle="buttons-radio">
                        <button type="button" value="{{Constants::TIME_PRE_MATCH}}" data-toggle="button" class="btn btn-primary">{{Lang::get('app.beforetime')}}</button>
                        <button type="button" value="{{Constants::TIME_HT}}" data-toggle="button" class="btn btn-primary">{{Lang::get('app.halftime')}}</button>
                        <button type="button" value="{{Constants::TIME_FULL}}" data-toggle="button" class="btn btn-primary">{{Lang::get('app.fulltime')}}</button>
                    </div>
                    {!! Form::hidden('time',isset($params['time'])?$params['time']:Constants::TIME_PRE_MATCH,array('class' => 'form-control')) !!}
                </div>
                <div class="form-group row">
                    <div class="col-lg-4">
                        {!! Form::label('field', Lang::get('app.field'), array('class' => 'control-label')) !!}
                        <div class="btn-group btn-block" data-toggle-name="field" data-toggle="buttons-radio">
                            <button type="button" value="{{Constants::FIELD_HOME}}" data-toggle="button" class="btn btn-primary">{{Lang::get('app.home')}}</button>
                            <button type="button" value="{{Constants::FIELD_DRAW}}" data-toggle="button" class="btn btn-primary">{{Lang::get('app.draw')}}</button>
                            <button type="button" value="{{Constants::FIELD_AWAY}}" data-toggle="button"class="btn btn-primary">{{Lang::get('app.away')}}</button>
                        </div>
                        {!! Form::hidden('field',isset($params['field'])?$params['field']:Constants::FIELD_HOME,array('class' => 'form-control')) !!}
                    </div>
                    <div class="col-lg-4">
                        {!! Form::label('operator', Lang::get('app.choose_operator_condition'), array('class' => 'control-label')) !!}
                        {!! Form::select('operator', $conditions, isset($params['operator'])?$params['operator']:'$and',array('class' => 'form-control')) !!}
                    </div>
                    <div class="col-lg-4">
                        {!! Form::label('value', Lang::get('app.enter_value'), array('class' => 'control-label')) !!}
                        {!! Form::text('value',$params['value'],array('class' => 'form-control value', 'placeholder' => Lang::get('app.enter_value'))) !!}
                    </div>
                </div>
            </div>
        </div>
        {!! Form::hidden('_id',isset($params['_id'])?$params['_id']:0,array('class' => 'form-control')) !!}
    </div>
    <div class="box-footer clearfix">
        <div class="pull-right">
            {!! Form::submit('Save', array('onclick'=>'RuleModule.save(this);return false;', 'class' => 'btn btn-sm btn-small btn-primary', 'data-loading-text' => 'Saving...')) !!}
        </div>
    </div>
    {!! Form::close() !!}
</div>