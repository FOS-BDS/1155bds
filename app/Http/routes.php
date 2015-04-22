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

Route::get('testInput', 'HomeController@testInput');
Route::get('home', 'HomeController@index');

/* Admin */
Route::get('admin/rules', 'Admin\RulesController@index');
Route::get('admin/rules/getRules', 'Admin\RulesController@getRules');
/* End Admin */

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
