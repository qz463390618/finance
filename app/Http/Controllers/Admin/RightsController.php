<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RightsController extends Controller
{
    //权限管理首页
    public function index()
    {
        return view('admin.rights');
    }

    //显示添加权限页面
    public function showAdd()
    {
        return view('admin.addRights');
    }
}
