<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin\Column;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ColumnController extends Controller
{
    //显示栏目管理列面
    public function index()
    {
        $columns = Column::where('state',1)->latest('column_id')->paginate(10);
        return view('admin.column.column')->with('data',$columns);
    }
    //显示添加页面
    public function showAdd()
    {
        $columns = Column::where('column_pid',0)->where('state',1)->get();
        return view('admin.column.addColumn')->with([
            'columns' => $columns,
        ]);
    }
    //执行添加栏目
    public function doAdd(Request $request)
    {
        $messages = [
            'column_name.required' => '栏目名不能为空',
            'column_name.unique' => '栏目名已存在',
            'column_name.max' => '栏目名最长max位',
            'column_chaining.required' => '文件名不能为空',
            'column_chaining.unique' => '文件名重复',
            'column_chaining.max' => '文件名最长max位',
        ];
        $validator=Validator::make($request->all(),[
            'column_name' => 'bail|required|unique:zwf_admin_column,column_name|max:50',
            'column_filename' =>'bail|required|unique:zwf_admin_column,column_filename|max:50',
        ],$messages);

        if($validator -> fails())
        {
            return back()->withErrors($validator)->withInput();
        }
        DB::beginTransaction();
        try{
            //整理数据

            $data = [];
            //栏目名
            $data['column_name'] = $request -> column_name;
            //父级id
            $data['column_pid'] = $request -> parent;
            //文件名
            $data['column_filename'] = $request ->column_filename;
            if($data['column_pid'] == 0)
            {
                $data['column_path'] = '0,';
                $data['column_chaining'] = '/'.$request->column_filename;
            }else{
                $parentInfo = Column::select(['column_id','column_path','column_chaining'])->where('column_id',$request->parent)->first();
                $data['column_path'] = $parentInfo->column_path.$parentInfo->column_id;
                $data['column_chaining'] = $parentInfo -> column_chaining .'/'.$request->column_filename;
            }
            $data['column_display'] = $request -> display;
            Column::create([
                'column_name' => $data['column_name'],
                'column_pid' => $data['column_pid'],
                'column_path' => $data['column_path'],
                'column_filename'=>$data['column_filename'],
                'column_chaining' => $data['column_chaining'],
                'column_display' => $data['column_display']
            ]);
            DB::commit();
            return "<script>alert('添加栏目成功');window.location.href='/admin/column'</script>";
        }catch (\Exception $e){

            DB::rollBack();
            //echo $e;
            return "<script>alert('添加栏目失败');window.location.href='/admin/column'</script>";
        }
    }
    //显示编辑页面
    public function showEdit($id)
    {
        //获取所有的一级栏目
        $columns = Column::where('column_pid',0)->where('state',1)->get();
        $columnInfo = Column::where('column_id',$id)->first();
        return view('admin.column.editColumn')->with([
            'columns' => $columns,
            'columnInfo' => $columnInfo
        ]);
    }
    //执行编辑页面
    public function doEdit(Request $request)
    {
        //var_dump($request->toArray());die;
        //查询原来的数据
        $yColumnInfo = Column::where('column_id',$request->column_id)->first();
        $messages = [
            'column_name.required' => '栏目名不能为空',
            'column_name.max' => '栏目名最长max位',
        ];
        $validator=Validator::make($request->all(),[
            'column_name' => 'bail|required|max:50',
        ],$messages);

        if($validator -> fails())
        {
            return back()->withErrors($validator)->withInput();
        }
        DB::beginTransaction();
        try{
            Column::where(['column_id'=>$request->column_id])->update([
                'column_name' =>$request -> column_name,
                'column_display' => $request ->display,
            ]);
            DB::commit();
            return "<script>alert('修改栏目成功');window.location.href='/admin/column'</script>";
        }catch (\Exception $e){
            DB::rollBack();
            return "<script>alert('修改栏目失败');window.location.href='/admin/column'</script>";
        }

    }
    //简单修改显隐
    public function editDisplay($id)
    {
        $columnInfo = Column::where('column_id',$id)->first();
        $displayVal = $columnInfo -> column_display == 1 ? 2: 1;
        Column::where('column_id',$id)->update([
            'column_display' => $displayVal,
        ]);
        return back();
    }
    //执行删除栏目
    public function doDel(Request $request)
    {
        //var_dump($request->toArray());
        $columnInfo = Column::where('column_id',$request->id)->first();
        $columns = Column::get();
        foreach($columns as $column)
        {
            $column_path_arr = explode(',',$column->column_path);
            if(in_array($columnInfo->column_id,$column_path_arr)){
                return '108';
            }
        }
        //Column::where('column_id',$request->id)->delete();
        Column::where('column_id',$request->id)->update([
            'state' => 2
        ]);
        return '200';
    }
}
