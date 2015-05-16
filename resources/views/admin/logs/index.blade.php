@extends('admin.layouts.app')
@section('scripts')
    <?php echo Html::script('/admin/js/manage.js') ?>
    <?php echo Html::script('/admin/js/plugins/pagination/jquery.twbsPagination.min.js') ?>
    <script>
        $(function(){
            $('#pagination').twbsPagination({
                totalPages: <?php echo $number_page ?>,
                startPage: <?php echo $page ?>,
                visiblePages: 10,
                first: "{{Lang::get('app.first')}}",
                last: "{{Lang::get('app.last')}}",
                next: "{{Lang::get('app.next')}}",
                prev: "{{Lang::get('app.prev')}}",
                onPageClick: function (event, page) {
                    manage.searchLog(null,page);
                }
            });
        });
    </script>
@endsection
@section('content')
    <div class="box box-warning">
        <div class="box-header"><h3 class="box-title">Lịch sử theo dõi ghi dấu</h3></div>
        <div class="box-body table-responsive">
            <form class="form-horizontal" action="/manages/searchLogs" method="GET">
                <div class="form-group col-lg-3 col-md-3" >
                    <input type="text" class="form-control" id="apiname" name="apiname" placeholder="Tên API...">
                </div>
                <div class="form-group col-lg-3 col-md-3">
                    <label class="control-label col-lg-2 col-md-2">Loại:</label>
                    <div class="col-lg-10">
                        <select name="type_log" class="form-control" id="type_log" >
                            <option value="">Tất cả</option>
                            <option value="error">Error</option>
                            <option value="info">Info</option>
                        </select>
                    </div>
                </div>
                <div class="form-group col-lg-4 col-md-4">
                    <div class="input-group">
                        <input type="text" class="form-control" name="message_log" id="message_log" placeholder="Nội dung cần tìm...">
                        <span class="input-group-addon" style="padding:0;">
                            <button type="submit" onclick="manage.searchLog(this); return false;" class="btn btn-flat bg-gray" style="border:0;" data-text-loading="Đang tìm..."><i class="fa fa-search"></i> Tìm kiếm</button>
                        </span>
                    </div>
                </div>
                <div class="form-group col-lg-2 col-md-2">
                    <a href="#" class="btn btn-danger btn-flat" onclick="manage.deleteLogs(this); return false;" data-text-loading="Đang xóa...">Xóa tất cả</a>
                </div>
            </form>
            <div id="log_table">
                <table class="table table-bordered table-striped table-responsive">
                    <thead>
                        <tr>
                            <th class="text-center">Tên API</th>
                            <th class="text-center">Mã lỗi</th>
                            <th class="text-center">Loại</th>
                            <th class="text-center">Nội dung</th>
                            <th class="text-center" style="width:10%;">Ngày tạo</th>
                        </tr>
                    </thead>
                    <tbody>
						@if(count($logs) == 0)
							<tr class="bg-danger">
								<td colspan="5">Không tìm thấy bất kỳ dữ liệu nào theo yêu cầu.</td>
							</tr>
						@endif
                        @foreach($logs as $log)
                            <tr class="info" >
                                <td class="text-center">{{$log['apiName']}}</td>
                                <td class="text-center"><span class="label {!!$log['lever'] == 'info'?'label-success':'label-danger'!!}">{{$log['errorCode']}}</span></td>
                                <td class="text-center"><span class="label {!!$log['lever'] == 'info'?'label-success':'label-danger'!!}">{{$log['lever']}}</span></td>
                                <td style="width: 50%;"><p style="max-width: 700px; word-wrap: break-word;">{{$log['message']}}</p></td>
                                <td class="text-center">{{$log['create_at']}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="text-center">Tên API</th>
                            <th class="text-center">Mã lỗi</th>
                            <th class="text-center">Loại</th>
                            <th class="text-center">Nội dung</th>
                            <th class="text-center">Ngày tạo</th>
                        </tr>
                    </tfoot>
                </table>
                <div class="dataTables_paginate paging_bootstrap text-right">
                    <ul id="pagination" class="pagination-sm"></ul>
                </div>
            </div>
        </div>
    </div>
@endsection