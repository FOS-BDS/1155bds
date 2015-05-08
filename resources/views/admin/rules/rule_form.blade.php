<style>
    .typeahead {
        background-color: #fff;
    }

    .typeahead:focus {
        border: 2px solid #0097cf;
    }

    .tt-query {
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    }
    .tt-menu {
        width: 200px;
        margin: 12px 0;
        padding: 8px 0;
        background-color: #fff;
        border: 1px solid #ccc;
        border: 1px solid rgba(0, 0, 0, 0.2);
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        border-radius: 8px;
        -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
        -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
        box-shadow: 0 5px 10px rgba(0,0,0,.2);
    }

    .tt-suggestion {
        padding: 3px 20px;
        line-height: 24px;
    }

    .tt-suggestion:hover {
        cursor: pointer;
        color: #fff;
        background-color: #0097cf;
    }

    .tt-suggestion.tt-cursor {
        color: #fff;
        background-color: #0097cf;

    }

    .tt-suggestion p {
        margin: 0;
    }
</style>
<script>
    $(function() {
        $('.condition_left').typeahead({
            ajax: RuleModule.urlApi+'rules/getConditionAndRules',
            displayField: 'name',
            valueField: 'id',
            scrollBar:true,
            onSelect: function(item) {
                $('#condition_left').val(item.value);
                $('#condition_left_display').val(item.value);
            }
        });
        $('.condition_right').typeahead({
            ajax: RuleModule.urlApi+'rules/getConditionAndRules',
            displayField: 'name',
            valueField: 'id',
            scrollBar:true,
            onSelect: function(item) {
                $('#condition_right').val(item.value);
                $('#condition_right_display').val(item.value);
            }
        });
    });
</script>
<div class="box box-solid box-primary" id="rule_form">
    <div class="box-header">
        <h4 class="box-title panel-title">{{ isset($params['_id']) && $params['_id']?Lang::get('app.edit_rule'):Lang::get('app.create_rule_new')}}</h4>
        <div class="box-tools pull-right">
            <button class="btn btn-primary btn-xs" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-primary btn-xs" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
    {!! Form::open(array('method' => 'POST', 'role' => 'form')) !!}
    <div class="box-body">
        <div class="row" >
            <div class="col-lg-12">
                <h4 class="form_alert alert-danger"></h4>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('name', Lang::get('app.name'), array('class' => 'control-label')) !!}
            {!! Form::text('name',isset($params['name'])?$params['name']:'',array('class' => 'form-control')) !!}
        </div>
        <div class="row form-group">
            <div class="col-lg-5">
                {!! Form::label('condition_left', Lang::get('app.choose_condition'), array('class' => 'control-label')) !!}
                {!! Form::text('condition_left_display',$params['condition_left_display'],array('class' => 'form-control condition_left', 'placeholder' => 'Enter text')) !!}
                {!! Form::hidden('condition_left',$params['condition_left'],array('class' => 'form-control')) !!}
            </div>
            <div class="col-lg-2">
                {!! Form::label('operator', Lang::get('app.choose_operator'), array('class' => 'control-label')) !!}
                {!! Form::select('operator', $conditions, isset($params['operator'])?$params['operator']:'$and',array('class' => 'form-control')) !!}
            </div>
            <div class="col-lg-5">
                {!! Form::label('condition_right', Lang::get('app.choose_condition'), array('class' => 'control-label')) !!}
                {!! Form::text('condition_right_display',$params['condition_right_display'],array('class' => 'form-control condition_right', 'placeholder' => 'Enter text')) !!}
                {!! Form::hidden('condition_right',$params['condition_right'],array('class' => 'form-control')) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('description', Lang::get('app.description'), array('class' => 'control-label')) !!}
            {!! Form::textarea('description',isset($params['description'])?$params['description']:'',array('rows'=>4,'class' => 'form-control')) !!}
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