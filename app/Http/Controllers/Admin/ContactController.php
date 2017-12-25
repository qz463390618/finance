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

        $contact = Contact::get();

        //var_dump($contact -> toArray());


        return view('admin.contact.index')->with([
            'contact' => $contact
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
        var_dump($request->toArray());
        echo str_replace(' ','<br>',$request->demand);

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
}
