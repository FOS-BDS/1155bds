<?php use \App\Libraries\InputHelper; ?>
<div class="box box-solid box-info widget-table">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-list"></i> {{Lang::get('app.rules')}}</h3>
        <div class="box-tools pull-right" role="group" aria-label="...">
            <button type="button" class="btn btn-sm btn-info" onclick="RuleModule.addRule(this)"><span class="fa fa-plus"></span> {{Lang::get('app.create_rule_new')}}</button>
        </div>
    </div>
    <div class="box-body widget-content">
        <table class="table table-striped table-bordered table-hover table-responsive">
            <tr class="active" style="background-color: #2a6496;">
                <th style="width:20%;">{{Lang::get('app.name')}}</th>
                <th>{{Lang::get('app.description')}}</th>
                <th style="text-align: center; width:8%;">{{Lang::get('app.color')}}</th>
                <th style="text-align: center; width:10%;">{{Lang::get('app.status')}}</th>
                <th style="text-align: center; width:140px;">{{Lang::get('app.action')}}</th>
            </tr>
            @foreach($rules as $rule)
                <tr>
                    <td style="text-align: left;">{{$rule['name']}}</td>
                    <td style="text-align: left;">{{$rule['description']}}</td>
                    <td style="text-align: center;">
                        {{isset($rule['rule_color'])?$rule['rule_color']:'#ffffff'}}
                        <div class="progress xs">
                            <div class="progress-bar" style="background-color:{{isset($rule['rule_color'])?$rule['rule_color']:'#ffffff'}};width: 100%"></div>
                        </div>
                    </td>
                    <td style="text-align: left;">{!!InputHelper::getStatus($rule['status'])!!}</td>
                    <td style="text-align: center;">
                        <div class="btn-group">
                            <button class="btn btn-xs btn-warning" data-loading-text="Editing..." onclick="RuleModule.editRule(this,'{{$rule['_id']}}');">{{Lang::get('app.edit')}} | <span class="fa fa-edit"></span></button>
                            <button class="btn btn-xs btn-danger" data-loading-text="Deleting..." onclick="RuleModule.deleteRule(this,'{{$rule['_id']}}');">{{Lang::get('app.delete')}} | <span class="fa fa-trash-o"></span></button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>