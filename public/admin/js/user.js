/**
 * Created by Kudo Shinichi on 5/6/2015.
 */
var user={
    login:function(myself,form_id){
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
                    $(myself).button('loading');
                },
                success:function(result){
                    if(result.error != false){
                        $(myself).button('reset');
                        $('.error_login').show();
                        $('.error_login').text(result.message);
                    }else{
                        location.href = '/users/matchs';
                    }
                },
                error:function(result){
                    console.log(result.responseText);
                }
            })
        }
    },
    register:function(myself,form_id){
        var username    = $('#username').val(),
            password    = $('#password').val(),
            repassword  = $('#repassword').val(),
            email       = $('#email').val(),
            phone       = $('#phone').val();
        if(username == '' || password == '' || repassword == '' || email == '' ){
            $('.error_register').show();
            $('.error_register').text('Bạn hãy nhập tất cả các trường bắt buộc (*)!');
            return false;
        }else{
            $('.error_register').hide();
            if(repassword != password){
                $('.error_register').show();
                $('.error_register').text('Mật khẩu không giống nhau!');
                $('#repassword').css('background','#ffe4fb');
            }else{
                $('.error_register').hide();
                $.ajax({
                    url:'/users/register',
                    data:{username:username,password:password,repassword:repassword,email:email,phone:phone},
                    type:'POST',
                    beforeSend:function(){
                        $(myself).button('loading');
                    },
                    success:function(result){
                        if(result.error != false){
                            $(myself).button('reset');
                            $('.error_register').show();
                            $('.error_register').text(result.message);
                        }else{
                            location.href = '/users/matchs';
                        }
                    },
                    error:function(result){
                        console.log(result.responseText);
                    }
                })
            }
        }

    }
}