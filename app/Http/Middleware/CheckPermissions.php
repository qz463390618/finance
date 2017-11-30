<?php

namespace App\Http\Middleware;

use App\Model\Admin\Rights;
use App\Model\Admin\User;
use Closure;

class CheckPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user_id = session()->get('admin')['user_id'];

        //获取访问的url
        $visitUrl = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];


        //获取权限标志
        $rightses = Rights::get();
        //var_dump($rightses);
        //遍历权限表,判断当前访问的路由需要什么权限;
        foreach ($rightses as $rights) {
            //获取出超级管理员全新权限的id
            if ($rights->rights_mark == '*') {
                $superPermissionsId = $rights->rights_id;
            }
            if (strpos($visitUrl, $rights->rights_mark)) {
                //获取需要权限的id
                //echo 111;
                $rights_id = $rights->rights_id;
            }
        }
        //var_dump($visitUrl);die;
        //如果需要权限的id 没有设置,则表示这个路由不需要权限
       if(!isset($rights_id))
       {
           return $next($request);
       }
        //var_dump($rights_id);die;
        //取出超级权限的角色id
        foreach (Rights::find($superPermissionsId)->roles()->get() as $role) {
            $superRoleId = $role->pivot->role_id;
        }

        //取出所需要权限的角色id
        $roles_ids = [];
        foreach (Rights::find($rights_id)->roles()->get() as $role) {

            $roles_ids[] = $role->pivot->role_id;
        }

        //根据当前权限id 获取有这个权限的所有角色id

        //获取当前用户所拥有的角色id
        $user_roles = User::find($user_id)->roles()->get();
        //var_dump($user_roles);die;
        if(!$user_roles->isEmpty())
        {
            //echo 222;
            foreach(User::find($user_id)->roles()->get() as $role)
            {
                $user_role_ids[] = $role -> pivot -> role_id;
            }
        }else{
            //echo 111;
            $user_role_ids = [];
        }
        //var_dump($user_role_ids);die;
        //判断是否有超级管理员角色
        if(in_array($superRoleId,$user_role_ids))
        {
            return $next($request);
            //echo '这个用户有超级管理员角色';
        }
        //遍历这个路由所需要的角色id组
        foreach($roles_ids as $role_id)
        {
            if(in_array($role_id,$user_role_ids))
            {
                return $next($request);
                //echo '这个用户有关于这个路由的角色';
            }
        }
        //echo die;
        //return redirect('/admin');
        echo  "<script>alert('您越权操作了');window.location.href='/admin';</script>";
        //return '<script>alert("您越权操作了");window.location.href="/admin"</script>';
        //die;

        /*return <<< END
    <script>

</script>
END;*/








        //return $next($request);
    }
}
