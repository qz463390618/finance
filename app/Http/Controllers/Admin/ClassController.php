<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin\zClass;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClassController extends Controller
{
    public function index()
    {
        $classes = zClass::where('state',1)->latest('class_id')->paginate(10);
        return view('admin.class.class')->with([
            'data'=>$classes
        ]);
    }
    //显示添加分类页
    public function showAdd()
    {
        return view('admin.class.addClass');
    }
    //执行添加
    public function doAdd(Request $request)
    {
        //var_dump($request->toArray());die;
        $message = [
            'class_name.required' => '分类名不能为空',
            'class_name.unique'=>'分类名已存在',
            'class_name.max' => '分类名字符过多,最多max位'
        ];
        $validator = Validator::make($request->all(),[
            'class_name' => 'required|unique:zwf_admin_class,class_name|max:30',
        ],$message);
        if($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }
        DB::beginTransaction();
        try{
            zClass::create([
                'class_name' => $request->class_name,
            ]);
            DB::commit();
            return "<script>alert('添加分类成功');window.location.href='/admin/class'</script>";
        }catch (\Exception $e){

            DB::rollBack();
            return "<script>alert('添加分类失败');window.location.href='/admin/class'</script>";
        }
    }
    //显示编辑列面
    public function showEdit($id)
    {
        $classInfo = zClass::where('class_id',$id)->first();
        //var_dump($classInfo);
        return view('admin.class.editClass')->with([
            'data' => $classInfo,
        ]);
    }
    //执行编辑
    public function doEdit(Request $request)
    {
        //var_dump($request -> toArray());die;
        $message = [
            'class_name.required' => '分类名不能为空',
            'class_name.unique'=>'分类名已存在',
            'class_name.max' => '分类名字符过多,最多max位'
        ];
        $validator = Validator::make($request->all(),[
            'class_name' => 'required|unique:zwf_admin_class,class_name|max:30',
        ],$message);
        if($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try{
            zClass::where(['class_id' => $request -> post('id')])->update([
                'class_name' => $request->class_name
            ]);
            DB::commit();
            return "<script>alert('修改成功');window.location.href='/admin/class'</script>";
        }catch (\Exception $e){
            DB::rollBack();
            return "<script>alert('修改失败');window.location.href='/admin/class'</script>";
        }
    }
    //执行删除
    public function doDel(Request $request)
    {
        DB::beginTransaction();
        try{
           //$mark =  zClass::where('class_id',$request->post('id'))->delete();
           $mark = zClass::where('class_id',$request->post('id'))->update([
               'state' => 2
           ]);
            DB::commit();
            return $mark;
        }catch(\Exception $e){
            DB::rollBack();
            return 'e';
        }
    }
}
