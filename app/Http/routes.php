<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

Route::get('/', 'WelcomeController@index');

/////////////CRON///////////////////
Route::get('/cron/match/v9bet/{in_time}','BackgroundProcessController@cronGetMatchData');



/////// END OF CRON ///////////////


Route::get('testInput', 'HomeController@testInput');
Route::get('home', 'HomeController@index');

/* Admin */
Route::get('admin/rules', 'Admin\RulesController@index');
Route::get('admin/rules/getRules', 'Admin\RulesController@getRules');
Route::get('admin/rules/editRule', 'Admin\RulesController@editRule');
Route::post('admin/rules/save', 'Admin\RulesController@save');
/* End Admin */

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

//////////// SYNC DATA  //////////

Route::post('/matchs','Data\MatchController@postMatchs');



//////// END SYNC DATA ////////////

//User
Route::get('users/home','Users\UserController@home');
Route::post('users/register','Users\UserController@register');
Route::get('users/login','Users\UserController@login');
Route::get('users/register','Users\UserController@viewRegister');
Route::post('users/confirmLogin','Users\UserController@confirmLogin');
// end User
Route::get('/test',function() {
    $users=new \App\Models\Users();
    $user_cur=$users->find();
    $user_cur->next();
    while($user_cur->hasNext()) {
        var_dump($user_cur->current());
        $user_cur->next();
    }

});
Route::filter('checkSession',function(){
    if(!Session::has('username')){
        return view('users.page.login');
    }
});
// some apis need to login function
Route::group(array('before'=>'checkSession'),function(){
    Route::get('users/logout','Users\UserController@logout');
    Route::get('manager','Users\UserController@manager');
});