<?php
/**
 * Created by PhpStorm.
 * User: Kudo Shinichi
 * Date: 5/5/2015
 * Time: 11:12 AM
 */
namespace App\Http\Controllers\Users;

use App\Http\Controllers\BaseController;
use App\Libraries\Constants;
use App\Libraries\InputHelper;
use App\Models\Users;
use Illuminate\Support\Facades\Session;

class UserController extends BaseController{
    public function home(){
        return view('users.page.index');
    }
    public function register(){
        try{
            $username       = InputHelper::getInput('username',true);
            $password       = InputHelper::getInput('password',true);
            $repassword     = InputHelper::getInput('repassword',true);
            $phone          = InputHelper::getInput('phone',false,'');
            $type           = InputHelper::getInput('type',false,'user');
            $email          = InputHelper::getInput('email',true);
           // $avatar       = InputHelper::getFile('avatar');
            $existed_user   = Users::getInstance()->findOne(array('username'=>$username));
            $existed_email  = Users::getInstance()->findOne(array('email'=>$email));
            if(count($existed_user)>0){
                return response()->json(array('message'=>'Tài khoản này đã có người sử dụng, hãy chọn một tài khoản khác!','error'=>true));
            }
            if(count($existed_email)>0){
                return response()->json(array('message'=>'Email đã được sử dụng!','error'=>true));
            }
            if($password != $repassword ){
                return response()->json(array('message'=>'Mật khẩu không giống nhau!','error'=>true));
            }
            $new_user = array(
                'id'  =>  time() . rand(0, 10000000),
                'username'  => $username,
                'password'  => md5($password),
                'phone'     => $phone,
                'email'     => $email,
                'type'     => $type,
            );
            $user = Users::getInstance()->insert($new_user);
            if($user['ok'] == 1){
                Session::put('username',$username);
                return response()->json(array('message'=>'Bạn đã đăng ký thành công!','error'=>false));
            }else{
                return response()->json(array('message'=>'Đăng ký không thành công!','error'=>true));
            }
        }catch (\Exception $e){
            return response()->json(array('message'=>$e->getMessage(),'error'=>$e->getCode()));
        }
    }
    public function login(){
        return view('users.page.login');
    }
    public function viewRegister(){
        return view('users.page.register');
    }
    public function logout(){
        Session::forget('username');
        return view('users.page.login');
    }
    public function confirmLogin(){
        try{
            $username       = InputHelper::getInput('username',true);
            $password       = InputHelper::getInput('password',true);
            $type           = InputHelper::getInput('type',false,'user');
            $user       = Users::getInstance()->findOne(array(
                'username'=> $username,
                'password'=> md5($password),
                'type'    => $type
            ));
           if( $type == Constants::TYPE_USER ){
               if(count($user)>0){
                   Session::put('username',$username);
                   return response()->json(array('message'=>'Đăng nhập thành công!','error'=>false));
               }else{
                   return response()->json(array('message'=>'Sai tên đăng nhập hoặc mật khẩu!','error'=>true));
               }
           }else{

           }
        }catch (\Exception $e){
            return response()->json(array('message'=>$e->getMessage(),'error'=>$e->getCode()));
        }
    }
}