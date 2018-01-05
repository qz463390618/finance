<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin\Role;
use App\Model\Admin\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //用户管理首页
    public function index()
    {
        $users = User::latest('user_id')->paginate(10);
        return view('admin.user.user')->with('data',$users);
    }

    //显示添加用户页面
    public function showAdd()
    {
        return view('admin.user.addUser');
    }

    //执行添加用户
    public function doAdd(Request $request)
    {
        //var_dump($request->post());
        $message = [
            'user_name.required' => '用户名不能为空',
            'user_name.unique' => '用户名已存在',
            'user_name.max' => '用户名超过了max位',
            'password.required' => '密码不能为空',
            'password.min' => '密码最少min位',
            'password.confirmed' => '两次密码输入不一致',
            'password_confirmation.required' => '密码不能为空',
            'password_confirmation.min' =>'密码最少min位'
        ];
        $validator = Validator::make($request->all(),[
            'user_name' => 'bail|required|unique:zwf_admin_users,user_account|max:30',
            'password'  => 'bail|required|min:6|confirmed',
            'password_confirmation' =>'required|min:6'
        ],$message);
        //错误返回
        if($validator -> fails())
        {
            return back()->withErrors($validator)->withInput();
        }
        $pwd = Hash::make($request ->post('password'));
        DB::beginTransaction();
        try{
            $user_id = User::InsertGetId([
                'user_account' => $request -> post('user_name'),
                'user_pwd' => $pwd
            ]);
            //提交事务
            DB::commit();
            return '<script>alert("添加用户成功");window.location.href="/admin/rbac/user"</script>';
        }catch (\Exception $e){

            //回滚事务
            DB::rollBack();
            return '<script>alert("添加用户失败,请稍后再试");window.location.href="/admin/rbac/user"</script>';
        }
    }

    //显示编辑用户
    public function showEdit($id)
    {
        //根据用户id 查询出用户信息
        $userInfo = User::where('user_id',$id)->first();
        //查询出所有的角色
        $roles = Role::get();
        //根据用户id查询出所拥有的角色
        $haveRoles =[];
        foreach(User::find($id)->roles()->get() as $role)
        {
            $haveRoles[] = $role->pivot->role_id;
        }
        return view('admin.user.editUser')->with([
            'userInfo' => $userInfo,
            'roles' => $roles,
            'haveRoles' => $haveRoles
        ]);
    }

    //执行编辑用户
    public function doEdit(Request $request)
    {
        //var_dump($request->toArray());
        $message = [
            'user_name.required' => '用户名不能为空',
            'user_name.max' => '用户名超过了max位',
            'password.min' => '密码最少min位',
            'password.confirmed' => '两次密码输入不一致',
            'password_confirmation.min' =>'密码最少min位'
        ];
        $validator = Validator::make($request->all(),[
            'user_name' => 'bail|required||max:30',
            'password'  => 'bail|confirmed',
        ],$message);
        //错误返回
        if($validator -> fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try{
            //获取这个用户对象
            $user = User::find($request->user_id);

            $role_ids = [];
            /*var_dump($request->toArray());die;*/
            if(!empty($request->post('user_role')))
            {
                //把角色字符串换成角色数组形式
                $roles = explode(',',$request->post('user_role'));
                //根据角色名获取角色id
                foreach($roles as $role)
                {
                    $role_ids[] = Role::where('role_name',$role)->first()->role_id;

                }
            }
            //var_dump($role_ids);die;
            //删除用户所有角色
            $user -> roles()->detach();
            //添加用户角色
            $user -> roles()->attach($role_ids);

            //更新用户名
            User::where('user_id',$request->user_id)->update([
                'user_account' => $request -> user_name,
            ]);

            //如果密码不为空这更新密码
            if(!empty($request->password))
            {
                User::where('user_id',$request->user_id)->update([
                    'user_pwd' => Hash::make($request->password),
                ]);
            }
            DB::commit();
            return '<script>alert("编辑用户成功");window.location.href="/admin/rbac/user"</script>';
        }catch (\Exception $e){
            echo $e;die;
            DB::rollBack();
            //echo $e;die;
            return '<script>alert("编辑用户失败,请稍后再试");window.location.href="/admin/rbac/user"</script>';
        }

    }

    //删除用户
    public  function doDel(Request $request)
    {
        DB::beginTransaction();
        try{
            //删除这个用户所有的角色
            User::find($request->post('id'))->roles()->detach();
            $mark = User::where('user_id',$request->post('id'))->delete();
            DB::commit();
            return $mark;
        }catch (\Exception $e){
            DB::rollBack();
        }
    }
}
