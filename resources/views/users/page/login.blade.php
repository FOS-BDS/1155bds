<!DOCTYPE html>
<html>
    @include('users.layouts.header')
    <body>
     @include('users.layouts.banner')
        <div class="container">
            <div id="place_login" class="col-lg-8 col-lg-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading text-center"><img src="<?php echo URL::to('/') ?>/img/img_soccer.gif"style="width: 40px;height: 40px; float: right"> <span style="font-weight: bold;font-size: 25px;">Đăng nhập </span></div>
                        <div class="panel-body">
                        <h4 class="alert alert-danger error_login" style="display: none;text-align: center"></h4>
                            <form class="form-horizontal" id="form_login">
                                <div class="form-group">
                                     <label for="username" class="fa fa-user col-lg-1 control-label fa-2x"></label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Nhập tên tài khoản...">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="fa fa-lock fa-2x col-lg-1 control-label"></label>
                                    <div class="col-lg-10">
                                        <input type="password" class="form-control" id="password" placeholder="Nhập mật khẩu...">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-offset-5 col-lg-10">
                                        <a  class="btn btn-info" href="/users/home" >Trang chủ</a>
                                        <a  class="btn btn-primary login_btn" data-text-loading="Đang đăng nhập..." onclick="user.login(this,'#form_login');">Đăng nhập</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </body>
    <script type="text/javascript">
        $(document).ready(function(){
             $(document).bind('keypress', function(e){
                  if(e.which === 13) { // return
                     var username    = $('#username').val(),
                            password    = $('#password').val();
                        if(username == '' || password == ''){
                            $('.error_login').show();
                            $('.error_login').text('Vui lòng nhập tài khoản và mật khẩu!');
                            return false;
                        }else{
                            $('.error_login').hide();
                            $.ajax({
                                url:'/users/confirmLogin',
                                data:{username:username,password:password},
                                type:'POST',
                                beforeSend:function(){
                                    $('.login_btn').button('loading');
                                },
                                success:function(result){
                                    if(result.error != false){
                                        $('.login_btn').button('reset');
                                        $('.error_login').show();
                                        $('.error_login').text(result.message);
                                    }else{
                                        location.href = '/users/matchs';
                                    }
                                },
                                error:function(result){
                                    $('.login_btn').button('reset');
                                    console.log(result.responseText);
                                }
                            })
                        }
                  }
            });
        });
    </script>
</html>