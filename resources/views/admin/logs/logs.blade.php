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
                manage.searchLog(this,page);
            }
        });
    });
</script>
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
    @if(count($logs) == 0)
        <tr class="bg-danger">
            <td colspan="5">Khong tim thay du lieu theo yeu cau.</td>
        </tr>
    @endif
    @foreach($logs as $log)
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
    <ul id="pagination" class="pagination-sm"></ul>
</div>