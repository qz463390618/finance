@extends('layouts.admin')
@section('title', '添加文章')
@section('my-css')
    <link rel="stylesheet" href="{{url('css/admin/uniform.css')}}" />
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
        <a href="{{url('/admin/information')}}" class="tip-bottom">文章列表</a>
        <a href="#" class="current">添加文章</a>
    </div>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
								<span class="icon">
									<i class="icon-align-justify"></i>
								</span>
                        <h5>添加新的文章</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form action="{{url('/admin/education/doAdd')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="control-group">
                                <label class="control-label">文章名</label>
                                <div class="controls">
                                    <input type="text" name="articles_name" placeholder="请输入文章名" value="{{old('articles_name')}}"/>
                                    @if(count($errors)>0)
                                        <span class="help-block">{{$errors -> first('articles_name')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">文章类型</label>
                                <div class="controls">
                                    <select class="form-control" name="class_id">
                                        @foreach($allClass as $class)
                                        <option value="{{$class->class_id}}">{{$class -> class_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">所属栏目</label>
                                <div class="controls">
                                    <select class="form-control" name="parent">
                                        @foreach($columns as $column)
                                            <option value="{{$column->column_id}}">{{$column -> column_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">作者</label>
                                <div class="controls">
                                    <input type="text" name="writer" placeholder="作者" value="{{old('writer_1')}}" style="width: 10%;"/>
                                    <select class="form-control weiter_select">
                                        <option></option>
                                        @foreach($adminUsers as $writer)
                                            <option>{{$writer -> user_account}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">来源</label>
                                <div class="controls">
                                    <input type="text" name="news_befrom" placeholder="来源网站" value="{{old('befrom')}}" style="width: 10%;"/>
                                    <select class="form-control befrom_select">
                                        <option></option>
                                        <option>南亚国际</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">正文内容</label>
                                <div class="controls" style="margin-right: 17%;">
                                    <script id="zlqEdit" name="news_content" type="text/plain" ></script>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">添加</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('my-js')
    <script src="{{url('plugIn/editor/ueditor.config.js')}}"></script>
    <script src="{{url('plugIn/editor/ueditor.all.js')}}"></script>
    <script src="{{url('js/admin/jquery.ui.custom.js')}}"></script>
    <script src="{{url('js/admin/bootstrap.min.js')}}"></script>
    <script src="{{url('js/admin/bootstrap-colorpicker.js')}}"></script>
    <script src="{{url('js/admin/jquery.uniform.js')}}"></script>
    <script src="{{url('js/admin/unicorn.form_common.js')}}"></script>
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue = UE.getEditor('zlqEdit',{
            initialFrameHeight:500,
            scaleEnabled:true,
            enterTag : 'br'
        });
    </script>
    <script src="{{url('js/admin/addNews.js')}}"></script>
@endsection