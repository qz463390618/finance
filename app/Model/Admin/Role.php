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
}
