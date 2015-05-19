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
<table class="table table-bordered table-striped table-hover table-responsive">
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
                <td class="text-left" style="font-style: italic">{{$log['apiName']}}</td>
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