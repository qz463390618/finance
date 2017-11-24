<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Rights extends Model
{
    //表名
    protected $table = 'zwf_admin_rights';
    //没有时间字段,不自动更新
    public $timestamps = false;
    //白名单
    protected $fillable = ['rights_id','rights_name','rights_mark'];
    //主键
    protected $primaryKey = 'rights_id';

    //权限对应角色
    public function roles()
    {
        return $this ->belongsToMany('App\Model\Admin\Role','zwf_admin_role_rights','rights_id','role_id');
    }
}
