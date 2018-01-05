<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function index()
    {

        $contact = DB::table('zwf_admin_contact as zwf')
            ->select('zwf.news_id','zwf.department','zwf.position','zwf.truetime')
            ->latest('news_id')
            ->where('state',1)
            ->paginate(10);

        return view('admin.contact.index')->with([
            'newses' => $contact,
            'search' => []
        ]);
    }
    //显示添加文章
    public function showAdd()
    {
        //var_dump($classes);die;
        return view('admin.contact.addNews');
    }
    //执行添加文章
    public function doAdd(Request $request)
    {
        $messages = [
            'department.required'=>'招聘部门不能为空',
            'department.max' => '招聘部门字符最多max位',
            'position.required'=>'招聘职位不能为空',
            'position.max' => '招聘职位字符最多max位',
            'duty.required' => '工作职责不能为空',
            'demand.required' => '工作职责不能为空',
        ];
        $validator  = Validator::make($request -> all(),[
            'department' => 'bail|required|max:50',
            'position' => 'bail|required|max:50',
            'duty' => 'bail|required',
            'demand' => 'bail|required',
        ],$messages);
        //错误返回
        if($validator -> fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        //添加数据 到新闻表
        DB::beginTransaction();
        try{

            //新闻表 获取插入的id
            $nwes_id = Contact::insertGetId([
                'department' => $request -> department,
                'position' => $request -> position,
                'duty' => $request ->duty,
                'demand' => $request -> demand,
                'truetime' => time(),
                'lastdotime' => time()
            ]);
            DB::commit();
            return '<script>alert("添加文章成功");window.location.href="/admin/contact"</script>';
        }catch (\Exception $e){
            DB::rollBack();
            echo $e;
            //return '<script>alert("添加文章失败");window.location.href="/admin/contact"</script>';
        }
    }
    //显示编辑页面
    public function showEdit(Request $request)
    {
        $news = Contact::find($request ->id);
        return view('admin.contact.editNews')
            ->with([
                'news' => $news,
            ]);
    }
    //执行编辑
    public function doEdit(Request $request)
    {
        $messages = [
            'department.required'=>'招聘部门不能为空',
            'department.max' => '招聘部门字符最多max位',
            'position.required'=>'招聘职位不能为空',
            'position.max' => '招聘职位字符最多max位',
            'duty.required' => '工作职责不能为空',
            'demand.required' => '工作职责不能为空',
        ];
        $validator  = Validator::make($request -> all(),[
            'department' => 'bail|required|max:50',
            'position' => 'bail|required|max:50',
            'duty' => 'bail|required',
            'demand' => 'bail|required',
        ],$messages);
        //错误返回
        if($validator -> fails())
        {
            return back()->withErrors($validator)->withInput();
        }
        DB::beginTransaction();
        try{
            //新闻表 获取插入的id
            $nwes_id = Contact::where('news_id',$request->news_id)->update([
                'department' => $request -> department,
                'position' => $request -> position,
                'duty' => $request ->duty,
                'demand' => $request -> demand,
                'lastdotime' => time()
            ]);
            DB::commit();
            return '<script>alert("编辑文章成功");window.location.href="/admin/contact"</script>';
        }catch (\Exception $e){
            DB::rollBack();
            echo $e;
        }
    }
    //删除修改文章
    public function delNews(Request $request)
    {
        DB::beginTransaction();
        try{
            $mark = Contact::where('news_id',$request->post('id'))->update([
                'state' => 2,
                'lastdotime' => time()
            ]);
            //$mark =  Contact::where('news_id',$request->post('id'))->delete();
            DB::commit();
            return $mark;
        }catch (\Exception $e){
            echo $e;
            DB::rollBack();
        }

    }
    //查询数据
    public function search(Request $request)
    {
        $keyword = $request ->keyword;
        $show = $request ->show;
        $infolday = $request -> infolday;
        $news = DB::table('zwf_admin_contact as zwf')
            ->select('zwf.news_id','zwf.department','zwf.position','zwf.truetime')
            -> where(function($query) use ($request) {
                if ($request->show == 0 )
                {
                    $query
                        ->orWhere('zwf.news_id', 'like', '%' . $request->keyboard . '%')
                        ->orWhere('zwf.department','like','%' . $request->keyboard . '%')
                        ->orWhere('zwf.position','like','%' . $request->keyboard . '%');
                }else {
                    $query
                        ->orWhere('zwf.' . $request->show, 'like', '%' . $request->keyboard . '%');

                }
            })
            ->where(function($query) use ($request)
            {
                if($request ->infolday != 1)
                {
                    $d = time();
                    $sT = $d - $request ->infolday;
                    $query
                        ->orWhere('zwf.truetime','>',$sT);
                }
            })
            ->where('state',1)
            ->paginate(10);
        $data['news'] = $news;
        $data['search'] = ['keyboard'=>$request->keyboard,'show'=>$request ->show,'infolday'=>$request ->infolday ];
        return view('admin.contact.index')->with([
            'newses' => $data['news'],
            'search' => $data['search']
        ]);
    }
}
