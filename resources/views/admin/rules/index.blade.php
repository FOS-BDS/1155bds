@extends('app')
@section('footer')
    <?php echo Html::script('/admin/js/RuleModule.js') ?>
@endsection
@section('content')
    <style>
        .rules>.panel-body {
            padding: 0;
        }
        .rules>.panel-body>.list-group {
            margin-bottom: 0;
        }
        .rules>.panel-body .list-group-item:first-child {
            border-top-right-radius: 0;
            border-top-left-radius: 0;
        }
        .rules>.panel-body .list-group-item {
            border-left: none;
            border-right: none;
        }
        .rules>.panel-body .list-group-item:last-child {
            margin-bottom: 0;
            border-bottom: none;
        }
        .tab-pane {
            padding: 15px 0;
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <ul class="nav nav-tabs">
                    @foreach($suppliers as $supplier)
                        <li role="presentation" class=""><a href="#{{$supplier->name}}" data-toggle="tab">{{$supplier->name}}</a></li>
                    @endforeach
                </ul>
                <div class="tab-content">
                    @foreach($suppliers as $supplier)
                    <div class="tab-pane" id="{{$supplier->name}}">
                        <div class="col-lg-3 col-md-3 col-xs-12 col-sm-12 no-padding">
                            <div class="panel panel-primary rules">
                                <div class="panel-heading">Loại luật - {{$supplier->name}}</div>
                                <div class="panel-body">
                                    <div class="list-group" id="rule_type_list">
                                        <a href="#" class="list-group-item" onclick="RuleModule.LoadRuleData(this,{{$supplier->id}}); return false;">
                                            <span class="glyphicon glyphicon-chevron-right"></span>
                                            Handicap Odds
                                            <span class="badge">28</span>
                                        </a>
                                        <a href="#" class="list-group-item" onclick="RuleModule.LoadRuleData(this,{{$supplier->id}}); return false;">
                                            <span class="glyphicon glyphicon-chevron-right"></span>
                                            Over/Under Odds
                                            <span class="badge">28</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9 col-xs-12 col-sm-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">Danh sách các luật</div>
                                <div class="panel-body" id="role_list_{{$supplier->id}}">

                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editRuleModal" tabindex="-1" role="dialog" aria-labelledby="Edit Rule" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Edit Rule</h4>
                </div>
                <div class="modal-body" id="editRuleModalContent">
                    <p>Loading data...</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" data-loading-text="Saving..." onclick="RuleModule.saveRule(event,this);">Save</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection