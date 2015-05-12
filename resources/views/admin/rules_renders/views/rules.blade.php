<div class="box-header">
    <h3 class="box-title">{{Lang::get('app.rules')}}</h3>
    <div class="box-tools pull-right" role="group" aria-label="...">
        <button type="button" class="btn btn-sm btn-info" onclick="RuleModule.addRule(this)"><span class="fa fa-plus"></span> {{Lang::get('app.new')}}</button>
        <button type="button" class="btn btn-sm btn-info" onclick="RuleModule.addRule(this)"><span class="fa fa-building-o"></span> {{Lang::get('app.conditions')}}</button>
    </div>
</div>
<div class="box-body">
    <table class="table table-striped table-bordered">
        <tr class="active" style="background-color: #2a6496;">
            <td style="text-align: center; width:20%;">#Id</td>
            <td style="text-align: center;">Đầu trận </td>
            <td style="text-align: center;">45+HT </td>
            <td style="text-align: center;">Báo màu</td>
            <td style="text-align: center; width:15%;">Công cụ </td>
        </tr>
        @foreach($rules as $rule)
            <tr>
                <td style="text-align: left;">{{$rule['_id']}}</td>
                <td style="text-align: center;">{{$rule['start_odd']}}</td>
                <td style="text-align: center;">{{$rule['after_odd']}}</td>
                <td style="text-align: center;">
                    {{$rule['rule_color']}}
                    <div class="progress xs">
                        <div class="progress-bar" style="background-color:{{$rule['rule_color']}};width: 100%"></div>
                    </div>
                </td>
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