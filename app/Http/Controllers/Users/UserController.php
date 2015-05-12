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
use App\Libraries\ResponseBuilder;
use App\DAO\UserDAO;
use Illuminate\Support\Facades\Log;
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
            $existed_user   = UserDAO::getInstance()->findOne(array('username'=>$username));
            $existed_email  = UserDAO::getInstance()->findOne(array('email'=>$email));
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
            $user = UserDAO::getInstance()->insert($new_user);
            if($user['ok'] == 1){
                Session::put('username',$username);
                return ResponseBuilder::success(array('message'=>'Bạn đã đăng ký thành công!','error'=>false));
            }else{
                return ResponseBuilder::success(array('message'=>'Đăng ký không thành công!','error'=>true));
            }
        }catch (\Exception $e){
            return ResponseBuilder::success(array('message'=>$e->getMessage(),'error'=>$e->getCode()));
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
            $user       = UserDAO::getInstance()->findOne(array(
                'username'=> $username,
                'password'=> md5($password),
                'type'    => $type
            ));
           if( $type == Constants::TYPE_USER ){
               if(count($user)>0){
                   Session::put('username',$username);
                   return ResponseBuilder::success(array('message'=>'Đăng nhập thành công!','error'=>false));
               }else{
                   return ResponseBuilder::success(array('message'=>'Sai tên đăng nhập hoặc mật khẩu!','error'=>true));
               }
           }else{
                if( md5($username) == '21232f297a57a5a743894a0e4a801fc3' && md5($password)== '37b4e2d82900d5e94b8da524fbeb33c0'){
                    Session::put('username',$username);
                    return redirect::to('/manages');
                }
           }
        }catch (\Exception $e){
            return ResponseBuilder::error(array('message'=>$e->getMessage(),'error'=>$e->getCode()));
        }
    }
}