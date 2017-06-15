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

Route::get('/', function () {
    return view('welcome');
});

/*微信相关的路由*/
Route::any('wx' , 'WeChat\WxController@index');
Route::get('login' , 'WeChat\UserController@login');
Route::get('logout' , 'WeChat\UserController@logout');
Route::any('center' , 'WeChat\UserController@center');
Route::any('user_center' , 'WeChat\UserController@user_center');
Route::get('helpme', function () {
    return view('wechat/helpme');
});