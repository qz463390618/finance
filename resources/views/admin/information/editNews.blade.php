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
                        <h5>编辑文章</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form action="{{url('/admin/information/doEdit')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input type="hidden" name="news_id" value="{{$news->news_id}}">
                            <div class="control-group">
                                <label class="control-label">文章名</label>
                                <div class="controls">
                                    <input type="text" name="articles_name" placeholder="请输入文章名" value="{{old('articles_name') ? old('articles_name'):$news -> title }}"/>
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
                                            <option value="{{$class->class_id}}" <?= $news -> class_id == $class->class_id ? 'selected': ''?>>{{$class -> class_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">所属栏目</label>
                                <div class="controls">
                                    <select class="form-control" name="parent">
                                        @foreach($columns as $column)
                                            <option value="{{$column->column_id}}" <?= $news -> column_id == $column->column_id ? 'selected': ''?> >{{$column -> column_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">封面图片</label>
                                <div class="controls">
                                    <input type="file" name="cover" >
                                    @if(count($errors)>0)
                                        <span class="help-block">{{$errors -> first('cover')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">简介</label>
                                <div class="controls">
                                    <textarea name="smalltext">{{$news -> smalltext}}</textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">关键词</label>
                                <div class="controls">
                                    <input type="text" name="keywords" placeholder="请输入关键词,多个词用,分隔" value="{{old('keywords') ? old('keywords'):$news -> keyboard }}"/>
                                    @if(count($errors)>0)
                                        <span class="help-block">{{$errors -> first('keywords')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">seo描述</label>
                                <div class="controls">
                                    <textarea name="seotext">{{$newsInfo -> seotext}}</textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">作者</label>
                                <div class="controls">
                                    <input type="text" name="writer" placeholder="作者" value="{{old('writer_1') ?old('writer_1') : $newsInfo->writer}}" style="width: 10%;"/>
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
                                    <input type="text" name="news_befrom" placeholder="来源网站" value="{{old('befrom') ? old('befrom') : $newsInfo -> befrom}}" style="width: 10%;"/>
                                    <select class="form-control befrom_select">
                                        <option></option>
                                        <option>南亚国际</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">正文内容</label>
                                <div class="controls" style="margin-right: 17%;">
                                    <script id="zlqEdit" name="news_content" type="text/plain"><?php echo $newsInfo -> newstext?></script>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">编辑</button>
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