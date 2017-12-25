<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    protected $table = 'zwf_admin_information';
    //有时间字段,不自动更新,手动更新
    public $timestamps = false;
    //白名单
    protected $fillable = ['news_id','class_id','cloumn_id','title','onclick','titlepic','smalltext','keyboard','truetime','lastdotime'];
    //主键
    protected $primaryKey = 'news_id';

    //内容表一对一
    public function newData()
    {
        return $this ->hasOne('App\Model\Admin\InformationData','news_id','news_id');
    }
}
