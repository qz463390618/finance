@extends('layouts.admin')
@section('title', '分类列表')
@section('my-css')

@endsection
@section('content')
    <div id="content-header">
        <h1>分类管理</h1>
        <div class="btn-group">
            <a class="btn btn-large tip-bottom" title="Manage Files"><i class="icon-file"></i></a>
            <a class="btn btn-large tip-bottom" title="Manage Users"><i class="icon-user"></i></a>
            <a class="btn btn-large tip-bottom" title="Manage Comments"><i class="icon-comment"></i><span class="label label-important">5</span></a>
            <a class="btn btn-large tip-bottom" title="Manage Orders"><i class="icon-shopping-cart"></i></a>
        </div>
    </div>
    <div id="breadcrumb">
        <a href="#" title="返回后台首页" class="tip-bottom"><i class="icon-home"></i> 后台</a>
        <a href="#" class="current">分类管理</a>
    </div>
    <div class="container-fluid">
        <p style="margin-top: 15px;">
            <button class="btn btn-large" onclick="window.location.href='{{url('admin/class/add')}}'">添加分类</button>
        </p>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
								<span class="icon">
									<i class="icon-th"></i>
								</span>
                        <h5>分类列表</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>分类名</th>
                                <th>创建时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
                            @foreach($data as $val)
                                <tr>
                                    <td>{{$val -> class_id}}</td>
                                    <td>{{$val -> class_name}}</td>

                                    <td>{{$val -> created_at}}</td>
                                    <td >
                                        <a href="{{url('/admin/class/edit').'/'.$val -> class_id}}" style="margin-right:10%">编辑</a>
                                        <a href="javascript:delClass('class',{{$val -> class_id}})">删除</a>

                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div style="text-align: center;">
                        {{$data -> links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('my-js')
    <script src="{{url('js/admin/zAdmin.js')}}"></script>
@endsection