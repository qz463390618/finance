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
        $news = DB::table('zwf_admin_education as zwf')
            ->join('zwf_admin_education_data as zlq','zwf.news_id','=','zlq.news_id')
            ->select('zwf.news_id','zwf.title','zwf.onclick','zwf.column_id','zwf.truetime','zlq.writer','zlq.befrom')
            ->latest('news_id')
            ->where('state',1)
            ->paginate(10);
        //var_dump($news->toArray());
        foreach($news as &$v)
        {

            $column_name = Column::select(['column_name'])->find($v -> column_id)->column_name;
            //var_dump($column_name);
            $v->column_name = $column_name;
        }
        //dump($news);
        //die;
        return view('admin.education.index')->with([
            'newses' => $news,
            'search' => []
        ]);
    }

    //显示添加文章
    public function showAdd()
    {
        //查询所有的分类
        $classes = zClass::where('state',1)->get();
        //查询当前栏目的所有子栏目
        $columns = Column::where('column_pid', 8)->where('state',1)->get();
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
            'articles_name.required' => '文章标题不能为空',
            'articles_name.unique' => '文章标题已存在',
            'articles_name.max' => '文章标题字符max位',
        ];
        $validator = Validator::make($request->all(), [
            'articles_name' => 'bail|required|unique:zwf_admin_education,title|max:100',
        ], $messages);
        //错误返回
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        //整理数据
        //添加数据 到新闻表
        DB::beginTransaction();
        try {

            //新闻表 获取插入的id
            $nwes_id = Education::insertGetId([
                'class_id' => $request->class_id,
                'column_id' => $request->parent,
                'title' => $request->articles_name,
                'truetime' => time(),
                'lastdotime' => time()
            ]);
            //内容表
            EducationData::create([
                'news_id' => $nwes_id,
                'class_id' => $request->class_id,
                'writer' => $request->writer,
                'befrom' => $request->news_befrom,
                'newstext' => $request->news_content,
            ]);
            DB::commit();
            return '<script>alert("添加文章成功");window.location.href="/admin/education"</script>';
        } catch (\Exception $e) {
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
        $columns = Column::where('column_pid', 8)->get();
        //查询出所有后台的用户
        $adminUsers = User::get();

        $news = Education::find($request->id);
        $newsInfo = Education::find($request->id)->newData;
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
        try {

            //新闻表 获取插入的id
            $nwes_id = Education::where('news_id', $request->news_id)->update([
                'class_id' => $request->class_id,
                'column_id' => $request->parent,
                'title' => $request->articles_name,
                'lastdotime' => time()
            ]);
            //内容表
            EducationData::where('news_id', $request->news_id)->update([
                'news_id' => $nwes_id,
                'class_id' => $request->class_id,
                'writer' => $request->writer,
                'befrom' => $request->news_befrom,
                'newstext' => $request->news_content,
            ]);
            DB::commit();
            return '<script>alert("编辑文章成功");window.location.href="/admin/information"</script>';
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e;
            //return '<script>alert("编辑文章失败");window.location.href="/admin/information"</script>';
        }
    }

    public function delNews(Request $request)
    {
        DB::beginTransaction();
        try {
            /*$mark = Education::where('news_id', $request->post('id'))->delete();
            EducationData::where('news_id', $request->post('id'))->delete();*/
            $mark = Information::where('news_id',$request->post('id'))->update([
                'state' => 2,
                'lastdotime' => time()

            ]);
            DB::commit();
            return $mark;
        } catch (\Exception $e) {
            echo $e;
            DB::rollBack();
        }

    }

    //搜索文章
    public function search(Request $request)
    {
        //查看sql语句
        DB::enableQueryLog();
        //var_dump($request ->toArray());
        $keyword = $request->keyword;
        $show = $request->show;
        $infolday = $request->infolday;
        $news = DB::table('zwf_admin_education as zwf')
            ->join('zwf_admin_education_data as zlq', 'zwf.news_id', '=', 'zlq.news_id')
            ->select('zwf.news_id', 'zwf.title', 'zwf.onclick', 'zwf.column_id', 'zwf.truetime', 'zlq.writer', 'zlq.befrom')
            ->where(function ($query) use ($request) {
                if ($request->show == 0) {
                    $query
                        ->orWhere('zwf.news_id', 'like', '%' . $request->keyboard . '%')
                        ->orWhere('zwf.title', 'like', '%' . $request->keyboard . '%')
                        ->orWhere('zlq.writer', 'like', '%' . $request->keyboard . '%')
                        ->orWhere('zlq.befrom', 'like', '%' . $request->keyboard . '%');
                } else {
                    if ($request->show == 'title' || $request->show == 'news_id') {
                        $query
                            ->orWhere('zwf.' . $request->show, 'like', '%' . $request->keyboard . '%');
                    } else if ($request->show == 'writer' || $request->show == 'befrom') {
                        $query
                            ->orWhere('zlq.' . $request->show, 'like', '%' . $request->keyboard . '%');
                    }
                }
            })
            ->where(function ($query) use ($request) {
                if ($request->infolday != 1) {
                    $d = time();
                    $sT = $d - $request->infolday;
                    $query
                        ->orWhere('zwf.truetime', '>', $sT);
                }
            })
            ->where('state',1)
            ->paginate(10);
        foreach ($news as &$v) {

            $column_name = Column::select(['column_name'])->find($v->column_id)->column_name;
            //var_dump($column_name);
            $v->column_name = $column_name;
        }
        $queries = DB::getQueryLog();
        //var_dump($news->toArray(),$queries);

        $data['news'] = $news;
        $data['search'] = ['keyboard' => $request->keyboard, 'show' => $request->show, 'infolday' => $request->infolday];
        return view('admin.education.index')->with([
            'newses' => $data['news'],
            'search' => $data['search']
        ]);

    }

}
