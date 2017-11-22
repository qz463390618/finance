<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //后台首页
    public function index()
    {
       return view('admin.index');
    }

    //后台登录页
    public function login()
    {
        return view('admin.login');
    }

    //执行后台登录
    public function doLogin(Request $request)
    {
        $userInfo = User::where('user_account',$request->account)->first();
        if($userInfo == null)
        {
            return "<script>alert('账号或密码错误');window.location.href='/admin/login';</script>";
        }
        if(Hash::check($request->pwd,$userInfo->user_pwd))
        {
            //存session值,把用户id存下来
           // echo 111;
            session(['admin'=>['user_id'=>$userInfo->user_id]]);
            return redirect('/admin');
        }else{
            return "<script>alert('账号或密码错误');window.location.href='/admin/login';</script>";
        }
    }

    //执行退出
    public function doLogout()
    {
        session()->forget('admin');
        return redirect('/admin');
    }
}
