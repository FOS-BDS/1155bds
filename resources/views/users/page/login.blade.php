@extends('admin.layouts.login')
@section('content')
    <div class="form-box" id="login-box">
        <div class="header bg-primary">Đăng nhập<img src="<?php echo URL::to('/') ?>/img/img_soccer.gif"style="width: 40px;height: 40px; float: right"></div>
        <form id="form_login">
            <div class="body bg-gray">
                <div class="callout callout-danger error_login" style="display: none"></div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Nhập tên tài khoản...">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu...">
                    </div>
                </div>
                <div class="form-group">
                    <input type="checkbox" name="remember_me"/> {!!Lang::get('app.remember_me')!!}
                </div>
            </div>
            <div class="footer">
                <button type="submit" class="btn bg-green btn-block" data-text-loading="Đang đăng nhập..." onclick="user.login(this,'#form_login');return false;">Đăng nhập</button>
                <p><a href="{{URL::to('users/forgotpassword')}}">{!!Lang::get('app.i_forgot_my_password')!!}</a></p>
                <a href="{{URL::to('users/register')}}" class="text-center">{!!Lang::get('app.register_a_new_member')!!}</a>
            </div>
        </form>
    </div>
@endsection