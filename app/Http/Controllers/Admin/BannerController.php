<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\UploadFileController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BannerController extends Controller
{
    //显示轮播图列表
    public function index()
    {
        $news = DB::table('banner_item')->where('delete_time',null)->get();

        return view('admin.banner.index')->with([
            'news' => $news
        ]);
    }
    //显示添加轮播图列表
    public function showAdd()
    {
        return view('admin.banner.addBanner');
    }
    //执行添加轮播图
    public function doAdd(Request $request,UploadFileController $file)
    {

        $img = $file -> upFile($_FILES['img']);
        //添加数据
        //开启事务
        DB::beginTransaction();
        try{
            $img_id =DB::table('zwf_images')->insertGetId([
                'url' => $img,
                'update_time' => time()
            ]);
            DB::table('banner_item')->insert([
                'img_id' => $img_id,
                'title' => $request -> title,
                'key_word' => $request -> key_word,
                'update_time' => time()
            ]);
            DB::commit();
            return '<script>alert("添加幻灯片成功");window.location.href="/admin/index/slide"</script>';
        }catch (\Exception $e)
        {
            echo $e;
            DB::rollBack();
        }
    }

    //执行删除轮播图
    public function delNews(Request $request)
    {
        $img_id = DB::table('banner_item')->select('img_id')->where('id',$request->id)->first()->img_id;
        DB::beginTransaction();
        try{
            //修改一个删除时间的值
           $mark =  DB::table('banner_item')->where('id',$request->id)->update([
                'delete_time' => time(),
            ]);
            DB::table('zwf_images')->where('img_id',$img_id)->update([
                'delete_time' => time(),
            ]);
            DB::commit();
            return $mark;
        }catch (\Exception $e)
        {
            echo $e;
            DB::rollBack();
        }
    }


}
