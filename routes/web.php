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
    Route::group(['middleware'=>['admin.check.id','admin.check.permissions'],'prefix'=>'rbac'],function()
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
            Route::get('add','Admin\UserController@showAdd');
            Route::post('doAdd','Admin\UserController@doAdd');
            Route::get('edit/{id}','Admin\UserController@showEdit');
            Route::post('doEdit','Admin\UserController@doEdit');
            Route::post('doDel','Admin\UserController@doDel');

        });
        //角色管理
        Route::group(['prefix'=>'role'],function()
        {
            Route::get('/','Admin\RoleController@index');
            Route::get('add','Admin\RoleController@showAdd');
            Route::post('doAdd','Admin\RoleController@doAdd');
            Route::get('edit/{id}','Admin\RoleController@showEdit');
            Route::post('doEdit','Admin\RoleController@doEdit');
            Route::post('doDel','Admin\RoleController@doDel');
        });
    });
    //栏目管理
    Route::group(['middleware' => ['admin.check.id','admin.check.permissions'],'prefix'=>'column'],function()
    {
        Route::get('/','Admin\ColumnController@index');
        Route::get('add','Admin\ColumnController@showAdd');
        Route::post('doAdd','Admin\ColumnController@doAdd');
        Route::get('edit/{id}','Admin\ColumnController@showEdit');
        Route::post('doEdit','Admin\ColumnController@doEdit');
        Route::get('editDisplay/{id}','Admin\ColumnController@editDisplay');
        Route::post('doDel','Admin\ColumnController@doDel');
    });
    //分类管理
    Route::group(['middleware' => ['admin.check.id','admin.check.permissions'],'prefix'=>'class'],function()
    {
        Route::get('/','Admin\ClassController@index');
        Route::get('add','Admin\ClassController@showAdd');
        Route::post('doAdd','Admin\ClassController@doAdd');
        Route::get('edit/{id}','Admin\ClassController@showEdit');
        Route::post('doEdit','Admin\ClassController@doEdit');
        Route::post('doDel','Admin\ClassController@doDel');
    });
    //信息中心
    Route::group(['middleware' => ['admin.check.id','admin.check.permissions'],'prefix'=>'information'],function()
    {
        //显示信息中心文章列表
        Route::get('/','Admin\InformationController@index');
        //显示添加文章页面
        Route::get('add','Admin\InformationController@showAdd');
        //执行添加文章
        Route::post('doAdd','Admin\InformationController@doAdd');
        //显示修改文章页面
        Route::get('edit/{id}','Admin\InformationController@showEdit');
        //执行修改
        Route::post('doEdit','Admin\InformationController@doEdit');
        //删除
        Route::post('del','Admin\InformationController@delNews');

        //查询数据
        Route::get('search','Admin\InformationController@search');
    });
    //投资者教育
    Route::group(['middleware' => ['admin.check.id','admin.check.permissions'],'prefix'=>'education'],function()
    {
        //显示信息中心文章列表
        Route::get('/','Admin\EducationController@index');
        //显示添加文章页面
        Route::get('add','Admin\EducationController@showAdd');
        //执行添加文章
        Route::post('doAdd','Admin\EducationController@doAdd');
        //显示修改文章页面
        Route::get('edit/{id}','Admin\EducationController@showEdit');
        //执行修改
        Route::post('doEdit','Admin\EducationController@doEdit');
        //删除
        Route::post('del','Admin\EducationController@delNews');
        //查询数据
        Route::get('search','Admin\EducationController@search');
    });
    //联系我们
    Route::group(['middleware' => ['admin.check.id','admin.check.permissions'],'prefix'=>'contact'],function()
    {
        //显示信息中心文章列表
        Route::get('/','Admin\ContactController@index');
        //显示添加文章页面
        Route::get('add','Admin\ContactController@showAdd');
        //执行添加文章
        Route::post('doAdd','Admin\ContactController@doAdd');
        //显示修改文章页面
        Route::get('edit/{id}','Admin\ContactController@showEdit');
        //执行修改
        Route::post('doEdit','Admin\ContactController@doEdit');
        //删除
        Route::post('del','Admin\ContactController@delNews');
        //查询数据
        Route::get('search','Admin\ContactController@search');
    });
    //首页管理
    Route::group(['middleware' => ['admin.check.id','admin.check.permissions'],'prefix'=>'index'],function()
    {
        //轮播图管理
        Route::group(['middleware' => ['admin.check.id','admin.check.permissions'],'prefix'=>'slide'],function()
        {
            //显示轮播图列表
            Route::get('/','Admin\BannerController@index');
            //显示添加轮播图列表
            Route::get('add','Admin\BannerController@showAdd');
            //执行添加轮播图
            Route::post('doAdd','Admin\BannerController@doAdd');
            //删除
            Route::post('del','Admin\BannerController@delNews');
        });
    });



});


//前台页面

//首页
//Route::get('/',);