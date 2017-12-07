<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin\Column;
use App\Model\Admin\zClass;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Qiniu\Auth;

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
        //查询所有的分类
        $classes = zClass::get();
        //查询当前栏目的所有子栏目
        $columns = Column::where('column_pid',4)->get();
        //var_dump($classes);die;
        return view('admin.information.addNews')->with([
            'allClass' => $classes,
            'columns' => $columns
        ]);
    }
    //执行添加文章
    public function doAdd(Request $request)
    {
        var_dump($request->toArray());
    }
}
