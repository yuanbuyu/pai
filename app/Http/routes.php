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

Route::any('wx' , 'WeChat\WxController@index');
Route::get('login' , 'WeChat\UserController@login');
Route::get('logout' , 'WeChat\UserController@logout');
Route::get('center' , 'WeChat\UserController@center');
Route::get('menu' , 'WeChat\MenuController@read_menu');
Route::get('add_menu' , 'WeChat\MenuController@add_menu');