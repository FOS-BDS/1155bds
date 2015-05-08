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
        $('div.minutes[data-name]').each(function () {
            var that = $(this);
            var name = $(this).attr('data-name');
            var hidden = $('input[name="' + name + '"]');
            $('a', that).each(function () {
                $(this).on('click', function () {
                    $('a', that).removeClass('label-danger');
                    hidden.val($(this).text());
                    $('.at_time').html('{{Lang::get('app.attime')}}' + '<i class="label label-danger">'+$(this).text()+'</i>');
                    $(this).addClass('label-danger');
                });
            });
        });

        $('#condition_form')
            .formValidation({
                framework: 'bootstrap',
                err: {
                    container: 'tooltip'
                },
                icon: {
                    valid: 'fa fa-check',
                    invalid: 'fa fa-times',
                    validating: 'fa fa-refresh'
                },
                row: {
                    selector: 'div.valid'
                },
                fields: {
                    "description": {
                        validators: {
                            notEmpty: {
                                message: 'The description is required'
                            }
                        }
                    },
                    "name": {
                        validators: {
                            notEmpty: {
                                message: 'The name is required'
                            }
                        }
                    },
                    value: {
                        validators: {
                            between: {
                                min: 2,
                                max: 100,
                                message: 'The number of value must be between %s and %s'
                            },
                            notEmpty: {
                                message: 'The first name is required'
                            }
                        }
                    },
                    value_2: {
                        validators: {
                            between: {
                                min: 'value',
                                max: 200,
                                message: 'The number of value must be between %s and %s'
                            },
                            notEmpty: {
                                message: 'The last name is required'
                            }
                        }
                    }
                }
            })
        // Revalidate the floor field when changing the number of floors
            .on('keyup', '[name="numFloors"]', function(e) {
                $('#dynamicOptionForm').formValidation('revalidateField', 'floor');
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
                    <div class="col-lg-12 valid">
                        {!! Form::label('name', Lang::get('app.name'), array('class' => 'control-label')) !!}
                        {!! Form::text('name',isset($params['name'])?$params['name']:'',array('class' => 'form-control row')) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('description', Lang::get('app.description'), array('class' => 'control-label')) !!}
                    {!! Form::textarea('description',isset($params['description'])?$params['description']:'',array('rows'=>5,'class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-lg-8">
                <div class="form-group row">
                    <div class="btn-block btn-group" data-toggle-name="odd_type" data-toggle="buttons-radio">
                        <div class="col-lg-4">
                            {!! Form::label('odd_type', Lang::get('app.fulltime'), array('class' => 'control-label')) !!}
                            <div class="btn-block btn-group">
                                <button type="button" value="{{Constants::ODD_1X2}}" data-toggle="button" class="btn btn-primary">{{Lang::get('app.odd_1x2')}}</button>
                                <button type="button" value="{{Constants::ODD_AH}}" data-toggle="button"class="btn btn-primary">{{Lang::get('app.odd_ah')}}</button>
                                <button type="button" value="{{Constants::ODD_OU}}" data-toggle="button"class="btn btn-primary">{{Lang::get('app.odd_ou')}}</button>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            {!! Form::label('odd_type', Lang::get('app.firsthalf'), array('class' => 'control-label')) !!}
                            <div class="btn-block btn-group">
                                <button type="button" value="{{Constants::ODD_1X21ST}}" data-toggle="button" class="btn btn-primary">{{Lang::get('app.odd_1x2')}}</button>
                                <button type="button" value="{{Constants::ODD_AH1ST}}" data-toggle="button"class="btn btn-primary">{{Lang::get('app.odd_ah')}}</button>
                                <button type="button" value="{{Constants::ODD_OU1ST}}" data-toggle="button"class="btn btn-primary">{{Lang::get('app.odd_ou')}}</button>
                            </div>
                        </div>
                    </div>
                    {!! Form::hidden('odd_type',isset($params['odd_type'])?$params['odd_type']:Constants::ODD_1X2,array('class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('time_type', Lang::get('app.time'), array('class' => 'control-label')) !!}
                    <div class="btn-group btn-block" data-toggle-name="time_type" data-toggle="buttons-radio">
                        <button type="button" value="{{Constants::TIME_PRE_MATCH}}" data-toggle="button" class="btn btn-primary">{{Lang::get('app.beforetime')}}</button>
                        <button type="button" value="{{Constants::TIME_HT}}" data-toggle="button" class="btn btn-primary">{{Lang::get('app.halftime')}}</button>
                        <div class="btn-group">
                            <button type="button" class="at_time btn disabled">{{Lang::get('app.attime')}}{!! ($params['time_type']==Constants::TIME_FULL?'<i class="label label-danger">'.$params['time_value'].'</i>':'')!!}</button>
                            <button type="button" value="{{Constants::TIME_FULL}}" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu" style="min-width: 386px;">
                                <div class="pull-left minutes" data-name="time_value" style="padding: 5px 10px">
                                    @for($i=0;$i<=90;$i++)
                                        <?php $class = (isset($params['time_value']) && $params['time_value'] == $i) ? 'label-danger' : ''; ?>
                                        <a class="pull-left label {{$class}} label-info" style="width:24px;margin:2px;padding:5px 0;" href="">{{$i}}</a>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::hidden('time_type',$params['time_type'],array('class' => 'form-control')) !!}
                    {!! Form::hidden('time_value',$params['time_value'],array('class' => 'form-control')) !!}
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
                    <div class="col-lg-2">
                        {!! Form::label('operator', Lang::get('app.choose_operator_condition'), array('class' => 'control-label')) !!}
                        {!! Form::select('operator', $conditions, isset($params['operator'])?$params['operator']:'$and',array('class' => 'form-control')) !!}
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('value', Lang::get('app.enter_value'), array('class' => 'control-label col-lg-12')) !!}
                            <div class="col-lg-6 valid">
                                {!! Form::text('value',$params['value'],array('class' => 'form-control row', 'placeholder' => Lang::get('app.enter_value'))) !!}
                            </div>
                            <div class="col-lg-6 valid">
                                {!! Form::text('value_2',$params['value'],array('class' => 'form-control row', 'placeholder' => Lang::get('app.enter_value'))) !!}
                            </div>
                        </div>
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