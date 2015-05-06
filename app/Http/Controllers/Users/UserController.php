<?php
/**
 * Created by PhpStorm.
 * User: Kudo Shinichi
 * Date: 5/5/2015
 * Time: 11:12 AM
 */
namespace App\Http\Controllers\Users;

use App\Http\Controllers\BaseController;
use App\Libraries\InputHelper;
use App\Models\Users;

class UserController extends BaseController{
    public function home(){
        return view('users.page.index');
    }
    public function register(){
        try{
            $username       = InputHelper::getInput('username',true);
            $password       = InputHelper::getInput('password',true);
            $repassword       = InputHelper::getInput('repassword',true);
            $phone     = InputHelper::getInput('phone',true);
            $email          = InputHelper::getInput('email',true);
           // $avatar     = InputHelper::getFile('avatar');
            if($password != $repassword ){
                return response()->json(array('message'=>'Mật khẩu không giống nhau!','error'=>true));
            }
            $new_user = array(
                'username' => $username,
                'password' => md5($password),
                'phone' => $phone,
                'email'    => $email
            );
            Users::getInstance()->insert($new_user);
            return response()->json(array('message'=>'success!','error'=>false));
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
}