<?php use App\Libraries\Constants; ?>
<style>
    .colorpicker-element .input-group-addon i {
        display: block;
        width: 16px;
        height: 16px;
        cursor: pointer;
    }
</style>
<script>
    $(function() {
        $(function() {
            var vleft = $('.condition_left').magicSuggest({
                name: 'conditions',
                maxSelection: 1,
                allowFreeEntries: false,
                data: RuleModule.urlApi+'rules/getConditionAndRules',
                method: 'get',
                noSuggestionText: 'No result matching the term',
                placeholder: "{!!Lang::get('app.choose_condition')!!}",
                value: '<?php echo $params["condition_left"] ?>',
                required: true
            });
            $('.condition_right').magicSuggest({
                name: 'conditions',
                maxSelection: 1,
                allowFreeEntries: false,
                data: RuleModule.urlApi+'rules/getConditionAndRules',
                method: 'get',
                noSuggestionText: 'No result matching the term',
                placeholder: "{!!Lang::get('app.choose_condition')!!}",
                value: '<?php echo $params["condition_right"] ?>'
            });

            $(".rule_color").ColorPickerSliders({
                color: '{{isset($params['rule_color'])?$params['rule_color']:'#ffffff'}}',
                hsvpanel: false,
                previewontriggerelement: true,
                placement: "auto",
                title: 'Select Color',
                sliders: false,
                previewformat: 'hex',
                size: 'sm',
                onchange: function(container, color) {
                    //$('.rule_color_display').css("background-color", color.tiny.toRgbString());
                }
            });
        });

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
                                },
                                stringLength: {
                                    min: 1,
                                    max: 225,
                                    message: 'The name must be more than 1 and less than 225 characters long'
                                },
                                remote: {
                                    type: 'GET',
                                    url: RuleModule.urlApi + 'rules/validate',
                                    data: {
                                        id: '{{isset($params['_id'])?$params['_id']:0}}'
                                    },
                                    message: 'The name condition existing in the system'
                                }
                            }
                        },
                        "conditions[]": {
                            validators: {
                                notEmpty: {
                                    message: 'The conditions is required'
                                }
                            }
                        }
                    },
                    onError: function(e) {
                    },
                    onSuccess: function(e) {
                    }
                })
                .on('success.form.fv', function(e) {
                    // Prevent form submission
                    e.preventDefault();
                    RuleModule.save();
                });
    });
</script>
<div class="box box-solid box-info" id="rule_form">
    <div class="box-header">
        <h4 class="box-title panel-title">{{ isset($params['_id']) && $params['_id']?Lang::get('app.edit_rule'):Lang::get('app.create_rule_new')}}</h4>
        <div class="box-tools pull-right">
            <button class="btn btn-primary btn-xs" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-primary btn-xs" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
    {!! Form::open(array('method' => 'POST', 'role' => 'form', 'id' => 'condition_form')) !!}
    <div class="box-body">
        <div class="form-group row">
            <div class="col-lg-12 valid">
                {!! Form::label('name', Lang::get('app.name').'*', array('class' => 'control-label')) !!}
                {!! Form::text('name',isset($params['name'])?$params['name']:'',array('class' => 'form-control')) !!}
            </div>
        </div>
        <div class="row form-group">
            <div class="col-lg-5 col-md-4 col-sm-4">
                {!! Form::label('condition_left', Lang::get('app.choose_condition'), array('class' => 'control-label')) !!}
                <div class="form-control condition_left"></div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-4">
                {!! Form::label('operator', Lang::get('app.choose_operator'), array('class' => 'control-label')) !!}
                {!! Form::select('operator', $conditions, isset($params['operator'])?$params['operator']:'$and',array('class' => 'form-control')) !!}
            </div>
            <div class="col-lg-5 col-md-4 col-sm-4">
                {!! Form::label('condition_right', Lang::get('app.choose_condition'), array('class' => 'control-label')) !!}
                <div class="form-control condition_right"></div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-8 col-md-8 col-sm-6 valid">
                {!! Form::label('description', Lang::get('app.description'), array('class' => 'control-label')) !!}
                {!! Form::textarea('description',isset($params['description'])?$params['description']:'',array('rows'=>4,'class' => 'form-control')) !!}
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                {!! Form::label('name', 'Báo màu:', array('class' => 'control-label')) !!}
                <div class="input-group  colorpicker-element">
                    {!! Form::text('rule_color','',array('class' => 'form-control rule_color')) !!}
                    <div class="input-group-addon">
                        <i class="fa rule_color_display" style="background-color:{{isset($params['rule_color'])?$params['rule_color']:'#ffffff'}};"></i>
                    </div>
                </div><!-- /.input group -->

                {!! Form::label('status', Lang::get('app.status'), array('class' => 'control-label')) !!}
                <div class="btn-group btn-block" data-toggle-name="status" data-toggle="buttons-radio">
                    <button type="button" value="{{Constants::STATUS_MAIN}}" data-toggle="button" class="btn btn-primary">{{Lang::get('app.main')}}</button>
                    <button type="button" value="{{Constants::STATUS_INTERMEDIATE}}" data-toggle="button"class="btn btn-primary">{{Lang::get('app.intermediate')}}</button>
                    <button type="button" value="{{Constants::STATUS_UNPUBLISH}}" data-toggle="button"class="btn btn-primary">{{Lang::get('app.unpublish')}}</button>
                </div>
                {!! Form::hidden('status',isset($params['status'])?$params['status']:Constants::STATUS_MAIN,array('class' => 'form-control')) !!}
            </div>
        </div>
        {!! Form::hidden('_id',isset($params['_id'])?$params['_id']:0,array('class' => 'form-control')) !!}
    </div>
    <div class="box-footer clearfix">
        <div class="pull-right">
            {!! Form::submit('Save', array('class' => 'btn btn-sm btn-small btn-primary', 'data-loading-text' => 'Saving...')) !!}
        </div>
    </div>
    {!! Form::close() !!}
</div>