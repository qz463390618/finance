<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $table = 'zwf_admin_education';
    //有时间字段,不自动更新,手动更新
    public $timestamps = false;
    //白名单
    protected $fillable = ['news_id','class_id','cloumn_id','title','onclick','truetime','lastdotime'];
    //主键
    protected $primaryKey = 'news_id';

    //内容表一对一
    public function newData()
    {
        return $this ->hasOne('App\Model\Admin\EducationData','news_id','news_id');
    }
}
