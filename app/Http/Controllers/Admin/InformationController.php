<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InformationController extends Controller
{
    //显示文章
    public function index()
    {
        return view('admin.information.index');
    }
    //显示添加文章
    public function showAdd()
    {

    }
}
