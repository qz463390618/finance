<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ColumnController extends Controller
{
    public function index()
    {
        return view('admin.column.column')->with('data',[]);
    }

    public function showAdd()
    {
        return view('admin.column.addColumn');
    }

    public function doAdd(Request $request)
    {
        var_dump($request -> toArray());
    }
}
