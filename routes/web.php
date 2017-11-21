<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//后台分组
Route::group(['prefix'=>'admin'],function()
{
    //后台首页
    Route::get('/','Admin\AdminController@index');
    //后台登入页
    Route::get('login','Admin\AdminController@login');
    //执行后胎登录
    Route::post('doLogin','Admin\AdminController@doLogin');
});