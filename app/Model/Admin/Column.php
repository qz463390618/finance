<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Column extends Model
{
    //表名
    protected $table = 'zwf_admin_column';
    //没有时间字段,不自动更新
    public $timestamps = true;
    //白名单
    protected $fillable = ['column_id','column_name','column_pid','column_path','column_display','created_at','updated_at'];
    //主键
    protected $primaryKey = 'column_id';
}
