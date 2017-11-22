<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    //角色管理首页
    public function index()
    {
        return view('admin.role');
    }
}
