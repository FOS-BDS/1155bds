<?php use \App\Libraries\InputHelper; ?>
<div class="box box-solid box-warning widget-table">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-list"></i> {{Lang::get('app.conditions')}}</h3>
        <div class="box-tools pull-right" role="group" aria-label="...">
            <button type="button" class="btn btn-sm btn-warning" onclick="RuleModule.addRule(this)"><span class="fa fa-plus"></span> {{Lang::get('app.create_condition_new')}}</button>
        </div>
    </div>
    <div class="box-body widget-content">
        <table class="table table-striped table-bordered table-hover table-responsive">
            <tr class="active" style="background-color: #2a6496;">
                <th style="text-align: center; width:15%;">{{Lang::get('app.name')}}</th>
                <th style="width:30%;">{{Lang::get('app.description')}}</th>
                <th style="text-align: center;">{{Lang::get('app.odd_type')}}</th>
                <th style="text-align: center;">{{Lang::get('app.time')}}</th>
                <th style="text-align: center;">{{Lang::get('app.field')}}</th>
                <th style="text-align: center;">{{Lang::get('app.operator')}}</th>
                <th style="text-align: center;">{{Lang::get('app.value')}}</th>
                <th style="text-align: center;min-width:140px;">{{Lang::get('app.action')}}</th>
            </tr>
            @foreach($rules as $rule)
                <tr>
                    <td style="text-align: left;">{{$rule['name']}}</td>
                    <td style="text-align: left;">{{substr($rule['description'],0,250)}}</td>
                    <td style="text-align: right;">{!!InputHelper::getOddType($rule['odd_type'])!!}</td>
                    <td style="text-align: center;">{!!InputHelper::getTime($rule)!!}</td>
                    <td style="text-align: left;">{!!InputHelper::getField($rule['field'])!!}</td>
                    <td style="text-align: center;">{!!InputHelper::getOperator($rule['operator'])!!}</td>
                    <td style="text-align: center;">{!!InputHelper::getConditionValue($rule['operator'],$rule['condition_values'])!!}</td>
                    <td style="text-align: center;">
                        <div class="btn-group-xs">
                            <button class="btn btn-xs btn-warning" data-loading-text="Editing..." onclick="RuleModule.editRule(this,'{{$rule['_id']}}');">{{Lang::get('app.edit')}} | <span class="fa fa-edit"></span></button>
                            <button class="btn btn-xs btn-danger" data-loading-text="Deleting..." onclick="RuleModule.deleteRule(this,'{{$rule['_id']}}');">{{Lang::get('app.delete')}} | <span class="fa fa-trash-o"></span></button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>