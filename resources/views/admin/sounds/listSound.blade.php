<table class="table table-bordered table-responsive table-hover text-center">
    <tr style="background: #f38aff;">
        <th>Tên âm thanh</th>
        <th>Định dạng</th>
        <th>Nghe thử</th>
        <th>Công cụ</th>
        <th>update_at</th>
    </tr>
    @if(count($sounds) > 0)
        @foreach($sounds as $sound)
            <tr>
                <td>{{$sound['soundName']}}</td>
                <td>{{$sound['extension']}}</td>
                <td><span class="fa fa-play-circle fa-2x"></span></td>
                <td>
                    <a class="btn btn-sm small btn-warning">Sửa</a>
                    <a class="btn btn-danger btn-sm">Xóa</a>
                </td>
                <td>{{$sound['updated_at']}}</td>
            </tr>
        @endforeach
    @else
        <tr>
            <td> Chưa có file âm thanh </td>
        </tr>
    @endif
</table>