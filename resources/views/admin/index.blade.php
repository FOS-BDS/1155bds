@extends('app')

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
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-xs-12 col-sm-12">
                <div class="panel panel-primary rules">
                    <div class="panel-heading">Loại luật</div>
                    <div class="panel-body">
                        <div class="list-group" id="rule_type_list">
                            <a href="#" class="list-group-item" onclick="SettingModule.LoadRuleData(this,2); return false;">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                                Crown Handicap Odds
                                <span class="badge">28</span>
                            </a>
                            <a href="#" class="list-group-item" onclick="SettingModule.LoadRuleData(this,3); return false;">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                                Crown Over/Under Odds
                                <span class="badge">18</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-9 col-xs-12 col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Danh sách các luật</div>

                    <div class="panel-body">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
