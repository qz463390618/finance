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
    Route::get('/','Admin\AdminController@index')->middleware('admin.check.id');
    //后台登入页
    Route::get('login','Admin\AdminController@login');
    //执行后台登录
    Route::post('doLogin','Admin\AdminController@doLogin');
    //执行后台退出登录
    Route::get('logout','Admin\AdminController@doLogout');
    //权限管理系统
    Route::group(['middleware'=>'admin.check.id','prefix'=>'rbac'],function()
    {
        //权限管理
        Route::group(['prefix'=>'rights'],function()
        {
            Route::get('/','Admin\RightsController@index');
            Route::get('add','Admin\RightsController@showAdd');
            Route::post('doAdd','Admin\RightsController@doAdd');
            Route::get('edit/{id}','Admin\RightsController@showEdit');
            Route::post('doEdit','Admin\RightsController@doEdit');
            Route::post('doDel','Admin\RightsController@doDel');
        });
        //用户管理
        Route::group(['prefix'=>'user'],function()
        {
            Route::get('/','Admin\UserController@index');

        });
        //角色管理
        Route::group(['prefix'=>'role'],function()
        {
            Route::get('/','Admin\RoleController@index');
            Route::get('add','Admin\RoleController@showAdd');
            Route::post('doAdd','Admin\RoleController@doAdd');
            Route::get('edit/{id}','Admin\RoleController@showEdit');
            Route::post('doEdit','Admin\RoleController@doEdit');
        });
    });
});