<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\UploadFileController;
use App\Model\Admin\Column;
use App\Model\Admin\Information;
use App\Model\Admin\InformationData;
use App\Model\Admin\User;
use App\Model\Admin\zClass;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Qiniu\Auth;

class InformationController extends Controller
{
    //显示文章
    public function index()
    {
        $news = Information::latest('news_id')->get();
        if(!$news->isEmpty())
        {
            $news = $news->toArray();
            $mark = 0;
            foreach($news as $v)
            {
                $writer = Information::find($v['news_id'])->newData;
                $news[$mark]['writer'] = $writer -> writer;
                $mark++;
            }
        }
        return view('admin.information.index')->with([
            'newses' => $news
        ]);
    }
    //显示添加文章
    public function showAdd()
    {
        //查询所有的分类
        $classes = zClass::get();
        //查询当前栏目的所有子栏目
        $columns = Column::where('column_pid',4)->get();
        //查询出所有后台的用户
        $adminUsers = User::get();



        //var_dump($classes);die;
        return view('admin.information.addNews')->with([
            'allClass' => $classes,
            'columns' => $columns,
            'adminUsers' => $adminUsers,
        ]);
    }
    //执行添加文章
    public function doAdd(Request $request,UploadFileController $file)
    {
        //echo '<img src="'.str_replace("[!--img.hosts--]",config('filesystems.hosts'),$data['cover']).'">';
        $messages = [
            'articles_name.required'=>'文章标题不能为空',
            'articles_name.unique' => '文章标题已存在',
            'articles_name.max' => '文章标题字符max位',
            'smalltext.max' => '简介最多max字符',
        ];
        $validator  = Validator::make($request -> all(),[
            'articles_name' => 'bail|required|unique:zwf_admin_information,title|max:100',
            'smalltext' => 'bail|max:255',
        ],$messages);
        //错误返回
        if($validator -> fails())
        {
            return back()->withErrors($validator)->withInput();
        }
        //整理数据
        //上传图片
        $data['cover'] = $file -> upFile($_FILES['cover']);
        //添加数据 到新闻表
        DB::beginTransaction();
        try{

            //新闻表 获取插入的id
            $nwes_id = Information::insertGetId([
                'class_id' => $request -> class_id,
                'column_id' => $request -> parent,
                'title' => $request -> articles_name,
                'titlepic' => $data['cover'],
                'smalltext' => $request ->smalltext,
                'keyboard' => $request -> keywords,
                'truetime' => time(),
                'lastdotime' => time()
            ]);
            //内容表
            InformationData::create([
                'news_id' =>  $nwes_id,
                'class_id' => $request -> class_id,
                'writer' => $request -> writer,
                'befrom' => $request -> news_befrom,
                'newstext' => $request -> news_content,
                'seotext' => $request -> seotext
            ]);
            DB::commit();
            return '<script>alert("添加文章成功");window.location.href="/admin/information"</script>';
        }catch (\Exception $e){
            DB::rollBack();
            //echo $e;
           return '<script>alert("添加文章失败");window.location.href="/admin/information"</script>';
        }
    }

    public function showEdit(Request $request)
    {
        //查询所有的分类
        $classes = zClass::get();
        //查询当前栏目的所有子栏目
        $columns = Column::where('column_pid',4)->get();
        //查询出所有后台的用户
        $adminUsers = User::get();

        $news = Information::find($request -> id);
        $newsInfo = Information::find($request -> id)->newData;
        return view('admin.information.editNews')->with([
            'allClass' => $classes,
            'columns' => $columns,
            'adminUsers' => $adminUsers,
            'news' => $news,
            'newsInfo' => $newsInfo
        ]);
    }

    public function doEdit(Request $request)
    {
        DB::beginTransaction();
        try{

            //新闻表 获取插入的id
            $nwes_id = Information::where('news_id',$request->news_id)->update([
                'class_id' => $request -> class_id,
                'column_id' => $request -> parent,
                'title' => $request -> articles_name,
                'smalltext' => $request ->smalltext,
                'keyboard' => $request -> keywords,
                'lastdotime' => time()
            ]);
            //内容表
            InformationData::where('news_id',$request->news_id)->update([
                'news_id' =>  $request->news_id,
                'class_id' => $request -> class_id,
                'writer' => $request -> writer,
                'befrom' => $request -> news_befrom,
                'newstext' => $request -> news_content,
                'seotext' => $request -> seotext
            ]);
            DB::commit();
            return '<script>alert("编辑文章成功");window.location.href="/admin/information"</script>';
        }catch (\Exception $e){
            DB::rollBack();
            echo $e;
            //return '<script>alert("编辑文章失败");window.location.href="/admin/information"</script>';
        }
    }

    public function delNews(Request $request)
    {
        DB::beginTransaction();
        try{
            $mark =  Information::where('news_id',$request->post('id'))->delete();
            InformationData::where('news_id',$request->post('id'))->delete();
            DB::commit();
            return $mark;
        }catch (\Exception $e){
            echo $e;
            DB::rollBack();
        }

    }

}
