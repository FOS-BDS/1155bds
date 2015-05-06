<!DOCTYPE html>
<html>
    @include('users.layouts.header')
    <body>
        <div class="container">
            @include('users.layouts.banner')
            <div id="place_register" class="col-lg-8 col-lg-offset-2">
                <div class="panel panel-success">
                    <div class="panel-heading text-center"> <span style="font-weight: bold;font-size: 25px;">Đăng ký thành viên </span><span class="fa fa-3x fa-pencil-square-o pull-right"> </span></div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="form_register">
                                <div class="form-group">
                                     <label for="username" class="col-lg-3 control-label">Tên đăng nhập*</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Tên tài khoản đăng nhập...">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password" class=" col-lg-3 control-label">Mật khẩu*</label>
                                    <div class="col-lg-9">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu...">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="repassword" class="col-lg-3 control-label">Nhập lại mật khẩu*</label>
                                    <div class="col-lg-9">
                                        <input type="repassword" class="form-control" id="repassword" name="repassword" placeholder="Nhập lại mật khẩu...">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-lg-3 control-label">Email*</label>
                                    <div class="col-lg-9">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email...">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="phone" class="col-lg-3 control-label">Số điện thoại</label>
                                    <div class="col-lg-9">
                                        <input type="phone" class="form-control" id="phone" name="phone" placeholder="Nhập số điện thoại...">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-offset-4 col-lg-10">
                                        <a  class="btn btn-warning" href="/users/home" >Trang chủ</a>
                                        <a  class="btn btn-primary" data-text-loading="Đang đăng nhập..." onclick="user.register(this,'#form_login');">Đồng ý</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </body>
</html>