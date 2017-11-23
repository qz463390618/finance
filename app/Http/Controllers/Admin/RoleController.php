<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin\Rights;
use App\Model\Admin\Role;
use App\Model\Admin\RoleRights;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    //角色管理首页
    public function index()
    {
        $roles = Role::latest('role_id')->paginate(10);
        return view('admin.role.role')->with('data',$roles);
    }

    //显示添加权限页面
    public function showAdd()
    {
        //查询出现在所有的权限
        $rights = Rights::select(['rights_name'])->get()->toArray();
        return view('admin.role.addRole')->with('rightses',$rights);
    }

    //执行添加角色,和添加权限
    public function doAdd(Request $request)
    {
        var_dump($request -> post());
        //整理权限,使用,分隔开为数组
        $rightses =explode(',',$request->post('role_rights'));
        var_dump($rightses);
        $messages = [
            'role_name.required' => '角色名不能为空',
            'role_name.unique' => '这个角色名已经存在了',
            'role_name:max' => '角色名超过:max位',

        ];

        //设置验证规则
        $validator = Validator::make($request->all(),[
            'role_name'=>'bail|required|unique:zwf_admin_role,role_name|max:30',
        ],$messages);
        //错误返回
        if($validator -> fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        //开启事务
        DB::beginTransaction();
        try{

            //添加角色进数据库,获取到角色的id
            $role_id = Role::InsertGetId([
                'role_name' => $request -> post('role_name'),
            ]);

            //根据获取到的角色id 插入数据表,角色和权限的中间表
            /*if(!empty($rightses))
            {
                //遍历权限组
                foreach($rightses as $val)
                {
                    //根据权限名,查询出权限id
                    $rights_id = Rights::select(['rights_id'])->where('rights_name',$val)->first()->rights_id;
                    RoleRoghts::create([
                        'role_id' => $role_id,
                        'rights_id' => $rights_id,
                    ]);
                }
            }*/
            //die;
            //提交事务
            DB::commit();
            return '<script>alert("增添角色成功");window.location.href="/admin/rbac/role"</script>';



        }catch (\Exception $e){

            //回滚事务
            DB::rollBack();
            return '<script>alert("因为网络原因添加失败,请稍后重试");window.location.href="/admin/rbac/role/add"</script>';
            //return back();
        }
    }

    //显示修改角色页面,也可以修改权限
    public function showEdit($id)
    {
        //根据角色id查询出角色名
        $roleInfo = Role::where('role_id',$id)->first();

        //查询出所有的权限
        $rightses = Rights::get();
        //根据角色id 查询出这个角色所有的权限
        $haveRightses  = RoleRights::where('role_id',$id)->get();

        //拥有的权限id组
        $haveRights = [];
        if(!$haveRightses -> isEmpty())
        {
            foreach($haveRightses as $v)
            {
                $haveRights[] = $v -> rights_id;
            }
        }
        return view('admin.role.editRole')->with([
            'roleInfo' => $roleInfo,
            'rightses' => $rightses,
            'haveRights' => $haveRights,
        ]);
    }

    public function doEdit(Request $request)
    {
        var_dump($request->toArray());
    }
}
