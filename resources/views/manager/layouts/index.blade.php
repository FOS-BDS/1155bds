<!DOCTYPE html>
<html>
  @include('users.layouts.header')
  <body>
        <div>
            <nav class="navbar navbar-inverse nav-tabs">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">Logs</a>
                    <a class="navbar-brand" href="#">Người dùng</a>
                    <a class="navbar-brand" href="#">Các luật chung</a>
                </div>
            </nav>
        </div>
        <div class="container">
            @yield('content')
        </div>
  </body>
</html>