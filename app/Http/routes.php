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
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Session;

Route::get('/', 'WelcomeController@index');

/////////////CRON///////////////////
Route::get('/cron/match/v9bet/{in_time}','BackgroundProcessController@cronGetMatchData');
Route::get('/cron/match/matchedOdds','Data\MatchController@getMatchedMatch');
Route::get('/cron/match/matchedNewOdds','Data\MatchController@getMatchedMatchFromNewOdd');
Route::get('/cron/oddversion','BackgroundProcessController@getOddVersion');

// clean logs every 24h
Route::get('/cron/log/clean','LogController@clean');
Route::get('/cron','BackgroundProcessController@cron');

/////// END OF CRON ///////////////


Route::get('testInput', 'HomeController@testInput');
//Route::get('home', 'HomeController@index');

Route::get('home',function() {
    echo date('Y-m-d h:i:s');
} );

/* Admin */
Route::get('admin/rules', 'Admin\RulesController@rules');
Route::get('admin/conditions', 'Admin\RulesController@conditions');
Route::get('admin/rules/getRules', 'Admin\RulesController@getRules');
Route::get('admin/rules/editRule', 'Admin\RulesController@editRule');
Route::get('admin/rules/getConditionAndRules', 'Admin\RulesController@getConditionAndRules');
Route::post('admin/rules/save', 'Admin\RulesController@save');
Route::get('admin/rules/validate', 'Admin\RulesController@checkValid');


/* Match */
Route::get('/matchs',
    [
        'uses'=>'Data\MatchController@getMatchView',
        'middleware'=>['auth']
    ]
    );
Route::get('/matchs/data','Data\MatchController@getMatchData');

Route::get('/matchs/{reference_id}/odd/{type}','Data\OddController@getOddView');
Route::get('/matchs/{reference_id}/odd/{type}/data','Data\OddController@getOddData');

// Logs
Route::get('admin/manages','Admin\LogController@manages');
Route::get('admin/manages/searchLogs','Admin\LogController@searchLogs');
Route::post('admin/manages/deleteLogs','Admin\LogController@deleteLogs');
// end logs
Route::get('admin/manages/sounds','Admin\SoundController@manageSounds');
Route::post('sounds/insert','Admin\SoundController@insertSound');
Route::get('sounds/allSounds','Admin\SoundController@allSounds');

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
Route::get('/test','BackgroundProcessController@testCurl');
Route::filter('checkSession',function(){
    if(!Session::has('user')){
        return view('users.page.login');
    }
});
// some apis need to login function
Route::group(array('before'=>'checkSession'),function(){
    Route::get('users/logout','Users\UserController@logout');
});

// logs events
Log::listen(function($level, $message, $context)
{
    $apiName = Request::capture()->path();
    // Get Error Code
    preg_match('/ERROR_CODE:\s*(\d+)/', $message, $matches);
    $startTime = isset($context['start_time']) ? $context['start_time'] : 0;
    //$endTime = isset($context['end_time']) ? $context['end_time'] : 0;
    $endTime = microtime(true);
    $errorCode = isset($matches[1]) ? $matches[1] : 200;
    Queue::push(function() use ($level, $errorCode, $message, $context, $apiName, $startTime, $endTime) {
        \App\DAO\LogDAO::getInstance()->insert(array(
            'lever'     =>$level,
            'errorCode' =>$errorCode,
            'message'   =>$message,
            'apiName'   =>$apiName,
            'create_at' => date('Y-m-d h:i:s')
        ));
    });
});
