@extends('admin.layouts.login')
@section('content')
    <div class="form-box" id="register-box" style="width: 500px">
        <div class="header">Đăng ký thành viên</div>
        <form class="form-horizontal" id="form_register" role="form">
            <div class="body bg-gray">
                <div class="callout callout-danger error_register" style="display: none"></div>
                <div class="form-group row">
                    <label for="username" class="col-lg-4 col-md-4 control-label text-right no-padding">Tên đăng nhập*</label>
                    <div class="col-lg-8 col-md-8">
                        <div class="input-group">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Nhập tên tài khoản..."/>
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password" class="col-lg-4 col-md-4 control-label text-right no-padding">Mật khẩu*</label>
                    <div class="col-lg-8 col-md-8">
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu...">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="repassword" class="col-lg-4 col-md-4 control-label text-right no-padding">Nhập lại mật khẩu*</label>
                    <div class="col-lg-8 col-md-8">
                        <div class="input-group">
                            <input type="password" class="form-control" id="repassword" name="repassword" placeholder="Nhập lại mật khẩu..."/>
                            <span class="input-group-addon"><i class="fa fa-unlock"></i></span>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-lg-4 col-md-4 control-label text-right no-padding">Email*</label>
                    <div class="col-lg-8 col-md-8">
                        <div class="input-group">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email..."/>
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="phone" class="col-lg-4 col-md-4 control-label text-right no-padding">Số điện thoại</label>
                    <div class="col-lg-8 col-md-8">
                        <div class="input-group">
                            <input type="text"  class="form-control" id="phone" name="phone" placeholder="Nhập số điện thoại...">
                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer text-center">
                <a href="{{URL::to('users/login')}}" class="btn bg-blue">Đăng nhập</a>
                <button type="submit" class="btn bg-olive" data-text-loading="Đang chờ..." onclick="user.register(this,'#form_register');return false;">Đăng ký</button>
            </div>
        </form>
    </div>
@endsection