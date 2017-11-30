<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class zClass extends Model
{
    //表名
    protected $table = 'zwf_admin_class';
    //白名单
    protected $fillable = ['class_id','class_name','created_at','updated_at'];
    //主键
    protected $primaryKey = 'class_id';
}
