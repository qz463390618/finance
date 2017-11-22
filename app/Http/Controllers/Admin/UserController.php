<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //用户管理首页
    public function index()
    {
        return view('admin.user');
    }
}
