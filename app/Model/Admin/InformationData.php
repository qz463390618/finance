<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class InformationData extends Model
{
    protected $table = 'zwf_admin_information_data';
    //有时间字段,不自动更新,手动更新
    public $timestamps = false;
    //白名单
    protected $fillable = ['news_id','class_id','writer','befrom','newstext','seotext'];
    //主键
    protected $primaryKey = 'news_id';

    //内容表一对一
    public function news()
    {
        return $this ->hasOne('App\Model\Admin\Information','news_id','news_id');
    }
}
