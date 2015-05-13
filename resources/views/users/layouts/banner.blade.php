<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav navbar-right">
        @if(\Illuminate\Support\Facades\Session::has('user'))
         <li><a class="btn btn-default"><span style="font-weight: bold;">Xin chào {{Session::get('user.username')}}</span></a></li>
         <li><a href="/users/logout" class="btn btn-warning"><span style="font-weight: bold;">Đăng xuất</span></a></li>

        @else
            <li><a href="/users/login" class="btn btn-info"><span style="font-weight: bold;">Đăng nhập</span></a></li>
            <li><a href="/users/register" class="btn btn-warning"><span style="font-weight: bold;">Đăng ký</span></a></li>
        @endif
      </ul>
    </div>
  </div>
</nav>

