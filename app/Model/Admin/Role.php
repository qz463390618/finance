<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //表名
    protected $table = 'zwf_admin_role';
    //没有时间字段,不自动更新
    public $timestamps = false;
    //白名单
    protected $fillable = ['role_id','role_name'];
    //主键
    protected $primaryKey = 'role_id';

    //角色权限
    public function rightses()
    {
        return $this->belongsToMany('App\Model\Admin\Rights','zwf_admin_role_rights','role_id','rights_id');
    }

    //角色对应用户
    public function users()
    {
        return $this -> belongsToMany('App\Model\Admin\user','zwf_admin_user_roles','role_id','user_id');
    }

}
