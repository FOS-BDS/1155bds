<div class="box-header">
    <h3 class="box-title">{{Lang::get('app.conditions')}}</h3>
    <div class="box-tools pull-right" role="group" aria-label="...">
        <button type="button" class="btn btn-sm btn-info" onclick="RuleModule.addRule(this)"><span class="fa fa-plus"></span> {{Lang::get('app.new')}}</button>
        <button type="button" class="btn btn-sm btn-info" onclick="RuleModule.getRules(this,'rule')"><span class="fa fa-building-o"></span> {{Lang::get('app.rules')}}</button>
    </div>
</div>
<div class="box-body">
    <table class="table table-striped table-bordered">
        <tr class="active" style="background-color: #2a6496;">
            <td style="text-align: center; width:20%;">{{Lang::get('app.name')}}</td>
            <td style="text-align: center;">{{Lang::get('app.condition')}}</td>
            <td style="text-align: center;">{{Lang::get('app.operator')}}</td>
            <td style="text-align: center;">{{Lang::get('app.condition')}}</td>
            <td>{{Lang::get('app.desctiption')}}</td>
            <td style="text-align: center; width:15%;">{{Lang::get('app.action')}}</td>
        </tr>
        @foreach($rules as $rule)
            <tr>
                <td style="text-align: left;">{{$rule['name']}}</td>
                <td style="text-align: right;">{{$rule['time']}}</td>
                <td style="text-align: center;">{{$rule['operator']}}</td>
                <td style="text-align: left;">{{$rule['value']}}</td>
                <td style="text-align: left;">{{$rule['description']}}</td>
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