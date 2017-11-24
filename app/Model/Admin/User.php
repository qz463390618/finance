<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //表名
    protected $table = 'zwf_admin_users';
    //没有时间字段,不自动更新
    public $timestamps = false;
    //白名单
    protected $fillable = ['user_id','user_account','user_pwd'];
    //主键
    protected $primaryKey = 'user_id';

    //用户角色
    public function roles()
    {
        return $this -> belongsToMany('App\Model\Admin\Role','zwf_admin_user_roles','user_id','role_id');
    }
}
