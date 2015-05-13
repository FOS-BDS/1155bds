<table class="table table-bordered table-hover">
                <tr class="bg-success">
                    <th class="text-center">API NAME</th>
                    <th class="text-center">CODE</th>
                    <th class="text-center">TYPE</th>
                    <th class="text-center">MESSAGE</th>
                    <th class="text-center">Created_at</th>
                </tr>
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
</table>
     <div style="text-align: center">
        @for($i=1;$i<=$number_page;$i++)
            <a href="#" onclick="manage.searchPage(this,'{{$i}}');"><span class="badge page_{{$i}}" style="background-color:#9D928C;">{{$i}}</span></a>
        @endfor
     </div>