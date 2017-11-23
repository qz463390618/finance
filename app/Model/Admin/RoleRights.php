<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class RoleRights extends Model
{
    //表名
    protected $table = 'zwf_admin_role_rights';
    //没有时间字段,不自动更新
    public $timestamps = false;
    //白名单
    protected $fillable = ['role_id','rights_id'];
}
