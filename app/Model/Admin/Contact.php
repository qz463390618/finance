<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'zwf_admin_contact';
    //有时间字段,不自动更新,手动更新
    public $timestamps = false;
    //白名单
    protected $fillable = ['news_id','department','position','duty','demand','truetime','lastdotime'];
    //主键
    protected $primaryKey = 'news_id';
}
