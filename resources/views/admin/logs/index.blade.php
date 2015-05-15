@extends('admin.layouts.app')
@section('scripts')
    <?php echo Html::script('/admin/js/manage.js') ?>
@endsection
@section('content')
    <div class="box box-warning">
        <div class="box-header"><h3 class="box-title">Danh sach lich su ghi log</h3></div>
        <div class="box-body table-responsive">
            <form class="form-horizontal" action="/manages/searchLogs" method="GET">
                <div class="form-group col-lg-3 col-md-3" >
                    <input type="text" class="form-control" id="apiname" name="apiname" placeholder="Api name...">
                </div>
                <div class="form-group col-lg-3 col-md-3">
                    <label class="control-label col-lg-2 col-md-2">Type:</label>
                    <div class="col-lg-10">
                        <select name="type_log" class="form-control" id="type_log" >
                            <option value="" >All</option>
                            <option value="error" >Error</option>
                            <option value="info" >Infor</option>
                        </select>
                    </div>
                </div>
                <div class="form-group col-lg-4 col-md-4">
                    <div class="input-group">
                        <input type="text" class="form-control" name="message_log" id="message_log" placeholder="Message...">
                        <span class="input-group-addon" style="padding:0;">
                            <button type="submit" onclick="manage.searchLog(this); return false;" class="btn btn-flat bg-gray" style="border:0;" data-text-loading="Filtering.."><i class="fa fa-search"></i> Search</button>
                        </span>
                    </div>
                </div>
                <div class="form-group col-lg-2 col-md-2">
                    <a href="#" class="btn btn-danger  btn-flat" data-text-loading="Filtering..">Delete All</a>
                </div>
            </form>
            <div id="log_table">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">API NAME</th>
                            <th class="text-center">CODE</th>
                            <th class="text-center">TYPE</th>
                            <th class="text-center">MESSAGE</th>
                            <th class="text-center" style="width:10%;">Created_at</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($all_log as $log)
                            @if($log['lever'] == 'info')
                                <tr class="info" >
                                    <td class="text-center">{{$log['apiName']}}</td>
                                    <td class="text-center">{{$log['errorCode']}}</td>
                                    <td class="text-center">{{$log['lever']}}</td>
                                    <td style="width: 50%;"><p style="max-width: 700px; word-wrap: break-word;">{{$log['message']}}</p></td>
                                    <td class="text-center">{{$log['create_at']}}</td>
                                </tr>
                            @elseif($log['lever'] == 'error')
                                <tr class="bg-danger" >
                                    <td class="text-center">{{$log['apiName']}}</td>
                                    <td class="text-center">{{$log['errorCode']}}</td>
                                    <td class="text-center">{{$log['lever']}}</td>
                                    <td style="width: 50%;"><p style="max-width: 700px; word-wrap: break-word;">{{$log['message']}}</p></td>
                                    <td class="text-center col-lg-1 col-md-1">{{$log['create_at']}}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="text-center">API NAME</th>
                            <th class="text-center">CODE</th>
                            <th class="text-center">TYPE</th>
                            <th class="text-center">MESSAGE</th>
                            <th class="text-center">Created_at</th>
                        </tr>
                    </tfoot>
                </table>
                <div class="dataTables_paginate paging_bootstrap text-right">
                    <ul class="pagination">
                        <li class="prev disabled">
                            <a href="#">← Previous</a>
                        </li>
                        @for($i=1;$i<=$number_page;$i++)
                            <li class="{{$page==$i?'active':''}}" onclick="manage.searchLog(this,'{{$i}}');"><a href="#">{{$i}}</a></li>
                        @endfor
                        <li class="next"><a href="#">Next → </a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection