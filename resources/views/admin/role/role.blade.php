@extends('layouts.admin')
@section('title', '角色列表')
@section('my-css')

@endsection
@section('content')
    <div id="content-header">
        <h1>角色管理</h1>
        <div class="btn-group">
            <a class="btn btn-large tip-bottom" title="Manage Files"><i class="icon-file"></i></a>
            <a class="btn btn-large tip-bottom" title="Manage Users"><i class="icon-user"></i></a>
            <a class="btn btn-large tip-bottom" title="Manage Comments"><i class="icon-comment"></i><span class="label label-important">5</span></a>
            <a class="btn btn-large tip-bottom" title="Manage Orders"><i class="icon-shopping-cart"></i></a>
        </div>
    </div>
    <div id="breadcrumb">
        <a href="#" title="返回后台首页" class="tip-bottom"><i class="icon-home"></i> 后台</a>
        <a href="#" class="current">角色管理</a>
    </div>
    <div class="container-fluid">
        <p style="margin-top: 15px;">
            <button class="btn btn-large" onclick="window.location.href='{{url('admin/rbac/role/add')}}'">添加角色</button>
        </p>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
								<span class="icon">
									<i class="icon-th"></i>
								</span>
                        <h5>角色列表</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>角色名</th>
                                <th>拥有权限</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $val)
                                <tr>
                                    <td>{{$val -> role_id}}</td>
                                    <td>{{$val -> role_name}}</td>
                                    <td>{{getRights($val -> role_id)}}</td>
                                    <td >
                                        <a href="{{url('/admin/rbac/role/edit').'/'.$val -> role_id}}" style="margin-right:20%">编辑</a>
                                        <a href="javascript:doDel('role',{{$val -> role_id}})">删除</a></td>
                                    <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div style="text-align: center;">
                            {{$data -> links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('my-js')
    <script src="{{url('js/admin/unicorn.tables.js')}}"></script>
    <script src="{{url('js/admin/zAdmin.js')}}"></script>
@endsection