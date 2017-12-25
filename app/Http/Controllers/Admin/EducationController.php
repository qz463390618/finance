<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin\Column;
use App\Model\Admin\Education;
use App\Model\Admin\EducationData;
use App\Model\Admin\User;
use App\Model\Admin\zClass;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EducationController extends Controller
{
    public function index()
    {
        $news = Education::latest('news_id')->get();
        if(!$news->isEmpty())
        {
            $news = $news->toArray();
            $mark = 0;
            foreach($news as $v)
            {
                $writer = Education::find($v['news_id'])->newData;
                $news[$mark]['writer'] = $writer -> writer;
                $mark++;
            }
        }
        return view('admin.education.index')->with([
            'newses' => $news
        ]);
    }
    //显示添加文章
    public function showAdd()
    {
        //查询所有的分类
        $classes = zClass::get();
        //查询当前栏目的所有子栏目
        $columns = Column::where('column_pid',8)->get();
        //查询出所有后台的用户
        $adminUsers = User::get();
        return view('admin.education.addNews')->with([
            'allClass' => $classes,
            'columns' => $columns,
            'adminUsers' => $adminUsers,
        ]);
    }

    //执行添加文章
    public function doAdd(Request $request)
    {
        //echo '<img src="'.str_replace("[!--img.hosts--]",config('filesystems.hosts'),$data['cover']).'">';
        $messages = [
            'articles_name.required'=>'文章标题不能为空',
            'articles_name.unique' => '文章标题已存在',
            'articles_name.max' => '文章标题字符max位',
        ];
        $validator  = Validator::make($request -> all(),[
            'articles_name' => 'bail|required|unique:zwf_admin_education,title|max:100',
        ],$messages);
        //错误返回
        if($validator -> fails())
        {
            return back()->withErrors($validator)->withInput();
        }
        //整理数据
        //添加数据 到新闻表
        DB::beginTransaction();
        try{

            //新闻表 获取插入的id
            $nwes_id = Education::insertGetId([
                'class_id' => $request -> class_id,
                'column_id' => $request -> parent,
                'title' => $request -> articles_name,
                'truetime' => time(),
                'lastdotime' => time()
            ]);
            //内容表
            EducationData::create([
                'news_id' =>  $nwes_id,
                'class_id' => $request -> class_id,
                'writer' => $request -> writer,
                'befrom' => $request -> news_befrom,
                'newstext' => $request -> news_content,
            ]);
            DB::commit();
            return '<script>alert("添加文章成功");window.location.href="/admin/education"</script>';
        }catch (\Exception $e){
            DB::rollBack();
            //echo $e;
            return '<script>alert("添加文章失败");window.location.href="/admin/education"</script>';
        }
    }

    public function showEdit(Request $request)
    {
        //查询所有的分类
        $classes = zClass::get();
        //查询当前栏目的所有子栏目
        $columns = Column::where('column_pid',8)->get();
        //查询出所有后台的用户
        $adminUsers = User::get();

        $news = Education::find($request -> id);
        $newsInfo = Education::find($request -> id)->newData;
        return view('admin.education.editNews')->with([
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
            $nwes_id = Education::where('news_id',$request->news_id)->update([
                'class_id' => $request -> class_id,
                'column_id' => $request -> parent,
                'title' => $request -> articles_name,
                'lastdotime' => time()
            ]);
            //内容表
            EducationData::where('news_id',$request->news_id)->update([
                'news_id' =>  $nwes_id,
                'class_id' => $request -> class_id,
                'writer' => $request -> writer,
                'befrom' => $request -> news_befrom,
                'newstext' => $request -> news_content,
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
            $mark =  Education::where('news_id',$request->post('id'))->delete();
            EducationData::where('news_id',$request->post('id'))->delete();
            DB::commit();
            return $mark;
        }catch (\Exception $e){
            echo $e;
            DB::rollBack();
        }

    }

}
