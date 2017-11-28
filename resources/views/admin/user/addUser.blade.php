@extends('layouts.admin')
@section('title', '添加用户')
@section('my-css')
    <link rel="stylesheet" href="{{url('css/admin/select2.css')}}" class="skin-color" />
@endsection
@section('content')
    <div id="content-header">
        <h1>首页</h1>
        <div class="btn-group">
            <a class="btn btn-large tip-bottom" title="Manage Files"><i class="icon-file"></i></a>
            <a class="btn btn-large tip-bottom" title="Manage Users"><i class="icon-user"></i></a>
            <a class="btn btn-large tip-bottom" title="Manage Comments"><i class="icon-comment"></i><span class="label label-important">5</span></a>
            <a class="btn btn-large tip-bottom" title="Manage Orders"><i class="icon-shopping-cart"></i></a>
        </div>
    </div>
    <div id="breadcrumb">
        <a href="#" title="返回后台首页" class="tip-bottom"><i class="icon-home"></i> 后台</a>
        <a href="{{url('/admin/rbac/user')}}" class="tip-bottom">用户管理</a>
        <a href="#" class="current">添加用户</a>
    </div>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
								<span class="icon">
									<i class="icon-align-justify"></i>
								</span>
                        <h5>添加新的用户</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form action="{{url('/admin/rbac/user/doAdd')}}" method="post" class="form-horizontal" >
                            {{csrf_field()}}
                            <div class="control-group">
                                <label class="control-label">用户名</label>
                                <div class="controls">
                                    <input type="text" name="user_name" placeholder="请输入用户名" value="{{old('user_name')}}"/>
                                    @if(count($errors)>0)
                                        <span class="help-block">{{$errors -> first('user_name')}}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">密&nbsp;&nbsp;码</label>
                                <div class="controls">
                                    <input type="password" name="password" placeholder="请输入密码" value="{{old('password')}}"/>
                                    @if(count($errors)>0)
                                        <span class="help-block">{{$errors -> first('password')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">确认密码</label>
                                <div class="controls">
                                    <input type="password" name="password_confirmation" placeholder="请再次输入密码" value="{{old('password_confirmation')}}"/>
                                    @if(count($errors)>0)
                                        <span class="help-block">{{$errors -> first('password_confirmation')}}</span>
                                    @endif
                                </div>
                            </div>

                            {{--<div class="control-group">
                                <label class="control-label">所拥有权限</label>
                                <div class="controls">
                                    <select multiple="">
                                        @foreach($rightses as $rights)
                                            <option >{{$rights['rights_name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>--}}
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary" {{--onclick="addRoleCollatingRights()"--}}>添加</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('my-js')
    <script src="{{url('js/admin/bootstrap.min.js')}}"></script>
    <script src="{{url('js/admin/bootstrap-colorpicker.js')}}"></script>
    <script src="{{url('js/admin/jquery.uniform.js')}}"></script>
    <script src="{{url('js/admin/select2.min.js')}}"></script>
    <script src="{{url('js/admin/unicorn.form_common.js')}}"></script>
    <script src="{{url('js/admin/zAdmin.js')}}"></script>
@endsection