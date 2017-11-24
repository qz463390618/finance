<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin\Rights;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RightsController extends Controller
{
    //权限管理首页
    public function index()
    {
        $rightses = Rights::latest('rights_id')->paginate(10);
        return view('admin.rights.rights')->with('data',$rightses);
        //return view('admin.rights');
    }

    //显示添加权限页面
    public function showAdd()
    {
        return view('admin.rights.addRights');
    }

    //执行添加权限
    public function doAdd(Request $request)
    {
        $messages = [
            'rights_name.required' => '权限名不能为空',
            'rights_name.unique' => '这个权限名已经存在了',
            'rights_name:max' => '权限名超过:max位',
            'rights_mark.required' => '权限标志不能为空',
            'rights_mark.unique' => '这个权限标志已经存在',
            'rights_mark.max' => '权限标志超过:max位',
        ];

        //设置验证规则
        $validator = Validator::make($request->all(),[
            'rights_name'=>'bail|required|unique:zwf_admin_rights,rights_name|max:20',
            'rights_mark'=>'bail|required|unique:zwf_admin_rights,rights_mark|max:50',
        ],$messages);
        //错误返回
        if($validator -> fails())
        {
            return back()->withErrors($validator)->withInput();
        }
        DB::beginTransaction();
        try{
            $rights_id = Rights::insertGetId([
                'rights_name' => $request -> rights_name,
                'rights_mark' => $request -> rights_mark,
            ]);
            DB::commit();
            return '<script>
var con = confirm("是否要继续添加权限");
if(con == true)
    {
        window.location.href="/admin/rbac/rights/add";
    }else{
        window.location.href="/admin/rbac/rights";
    }
</script>';
        }catch (\Exception $e)
        {
            //回滚
            DB::rollBack();
            return '<script>alert("因为网络原因添加失败,请稍后重试");window.location.href="/admin/rbac/rights/add"</script>';
        }
    }

    //显示修改权限页面
    public function showEdit($id)
    {
        //根据id获取数据
        $rightsInfo = Rights::where('rights_id',$id)->first();
        return view('admin.rights.editRights')->with('rightsInfo',$rightsInfo);
    }

    //执行编辑权限
    public function doEdit(Request $request)
    {
        $messages = [
            'rights_name.required' => '权限名不能为空',
            'rights_name:max' => '权限名超过:max位',
            'rights_mark.required' => '权限标志不能为空',
            'rights_mark.max' => '权限标志超过:max位',
        ];

        //设置验证规则
        $validator = Validator::make($request->all(),[
            'rights_name'=>'bail|required|max:20',
            'rights_mark'=>'bail|required|max:50',
        ],$messages);
        //错误返回
        if($validator -> fails())
        {
            return back()->withErrors($validator)->withInput();
        }
        //开启事务
        DB::beginTransaction();
        try{
            Rights::where(['rights_id'=>$request->post('reight_id')])->update([
                'rights_name' => $request -> post('rights_name'),
                'rights_mark' => $request -> post('rights_mark'),
            ]);
            //提交事务
            DB::commit();
            return '<script>
alert("编辑权限成功");window.location.href="/admin/rbac/rights";
                    </script>';
        }catch (\Exception $e)
        {
            //回滚事务
            DB::rollBack();
            return '<script>alert("因为网络原因编辑失败,请稍后重试");window.location.href="/admin/rbac/rights/edit"</script>';
        }
    }

    //删除权限
    public function doDel(Request $request)
    {
        DB::beginTransaction();
        try{
            //删除所有的权限
            Rights::find($request->post('id'))->roles()->detach();
            $mark =  Rights::where('rights_id',$request->post('id'))->delete();
            DB::commit();
            return $mark;
        }catch (\Exception $e){

            DB::rollBack();
            return  $e;
        }
        /*Rights::find($request->post('id'))->roles()->detach();
        $mark =  Rights::where('rights_id',$request->post('id'))->delete();
        return $mark;*/
    }
}
