@extends('app')
@section('scripts')
    <?php echo Html::script('/admin/js/RuleModule.js') ?>
    <?php echo Html::script('/admin/js/plugins/tinycolor/tinycolor.min.js') ?>
    <?php echo Html::script('/admin/js/plugins/colorpicker-slider/bootstrap.colorpickersliders.js') ?>
@endsection
@section('styles')
    <?php echo Html::style('/admin/js/plugins/colorpicker-slider/bootstrap.colorpickersliders.css') ?>
@endsection
@section('content')
    <section class="content-header panel-primary"><h3 class="panel-title">Quan ly luat</h3></section>
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            @foreach($suppliers as $supplier)
                <li role="presentation" class=""><a href="#{{$supplier['name']}}" data-toggle="tab">{{$supplier['name']}}</a></li>
            @endforeach
        </ul>
        <div class="tab-content">
            @foreach($suppliers as $supplier)
                <div class="tab-pane" id="{{$supplier['name']}}">
                    <aside class="left-side sidebar-offcanvas">
                        <section class="content-header box box-primary"><h3 class="panel-title">Loại luật - {{$supplier['name']}}</h3></section>
                        <section class="sidebar">
                            <ul class="sidebar-menu">
                                <li>
                                    <a href="#" onclick="RuleModule.getRules(this,{{$supplier['id']}},'HandicapOdd'); return false;">
                                        <span class="glyphicon glyphicon-chevron-right"></span>
                                        Handicap Odds
                                        <span class="badge">28</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" onclick="RuleModule.getRules(this,{{$supplier['id']}},'OverUnderOdd'); return false;">
                                        <span class="glyphicon glyphicon-chevron-right"></span>
                                        Over/Under Odds
                                        <span class="badge">28</span>
                                    </a>
                                </li>
                            </ul>
                        </section>
                    </aside>
                    <aside class="right-side">
                        <div id="role_edit_{{$supplier['id']}}"></div>
                        <div id="role_list_{{$supplier['id']}}" class="box box-danger">
                            <section class="content-header"><h3 class="panel-title">Danh sách các luật</h3></section>
                            <section class="content">Vui long chon mot loai luat de hien thi.</section>
                        </div>
                    </aside>
                </div>
            @endforeach
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