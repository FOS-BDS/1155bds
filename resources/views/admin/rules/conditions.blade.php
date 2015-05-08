<?php use \App\Libraries\InputHelper; ?>
<div class="box box-solid box-warning">
    <div class="box-header">
        <h3 class="box-title">{{Lang::get('app.conditions')}}</h3>
        <div class="box-tools pull-right" role="group" aria-label="...">
            <button type="button" class="btn btn-sm btn-warning" onclick="RuleModule.addRule(this)"><span class="fa fa-plus"></span> {{Lang::get('app.create_condition_new')}}</button>
            <button type="button" class="btn btn-sm btn-warning" onclick="RuleModule.getRules(this,'rule')"><span class="fa fa-building-o"></span> {{Lang::get('app.rules')}}</button>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-striped table-bordered">
            <tr class="active" style="background-color: #2a6496;">
                <td style="text-align: center; width:20%;">{{Lang::get('app.name')}}</td>
                <td>{{Lang::get('app.description')}}</td>
                <td style="text-align: center;">{{Lang::get('app.odd_type')}}</td>
                <td style="text-align: center;">{{Lang::get('app.time')}}</td>
                <td style="text-align: center;">{{Lang::get('app.field')}}</td>
                <td style="text-align: center;">{{Lang::get('app.operator')}}</td>
                <td style="text-align: center;">{{Lang::get('app.value')}}</td>
                <td style="text-align: center; width:15%;">{{Lang::get('app.action')}}</td>
            </tr>
            @foreach($rules as $rule)
                <tr>
                    <td style="text-align: left;">{{$rule['name']}}</td>
                    <td style="text-align: left;">{{$rule['description']}}</td>
                    <td style="text-align: right;">{!!InputHelper::getOddType($rule['odd_type'])!!}</td>
                    <td style="text-align: center;">{!!InputHelper::getTime($rule)!!}</td>
                    <td style="text-align: left;">{!!InputHelper::getField($rule['field'])!!}</td>
                    <td style="text-align: center;">{!!InputHelper::getOperator($rule['operator'])!!}</td>
                    <td style="text-align: center;">{!!InputHelper::getConditionValue($rule['operator'],$rule['condition_values'])!!}</td>
                    <td style="text-align: center;">
                        <div class="btn-group">
                            <button class="btn btn-xs btn-warning" data-loading-text="Editing..." onclick="RuleModule.editRule(this,'{{$rule['_id']}}');">Edit | <span class="fa fa-edit"></span></button>
                            <button class="btn btn-xs btn-danger" data-loading-text="Deleting..." onclick="RuleModule.deleteRule(this,'{{$rule['_id']}}');">Delete | <span class="fa fa-trash-o"></span></button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>