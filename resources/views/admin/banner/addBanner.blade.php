@extends('layouts.admin')
@section('title', '添加轮播图')
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
        <a href="{{url('/admin/index/banner')}}" class="tip-bottom">轮播图列表</a>
        <a href="#" class="current">添加轮播图</a>
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
                        <form action="{{url('/admin/index/slide/doAdd')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="control-group">
                                <label class="control-label">标题</label>
                                <div class="controls">
                                    <input type="text" name="title" placeholder="请输入文章名" value="{{old('title')}}"/>
                                    @if(count($errors)>0)
                                        <span class="help-block">{{$errors -> first('title')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">封面图片</label>
                                <div class="controls">
                                    <input type="file" name="img" id="xdaTanFileImg" onchange="xmTanUploadImg(this)" accept="image/*">
                                    <input type="button" value="隐藏图片" onclick="document.getElementById('xmTanImg').style.display = 'none';"/>
                                    <input type="button" value="显示图片" onclick="document.getElementById('xmTanImg').style.display = 'block';"/>
                                </div>
                                图片预览：<div style="height: 200px;border:1px solid red;">
                                    <img id="xmTanImg" style="max-height: 200px;"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">跳转地址</label>
                                <div class="controls">
                                    <input type="text" name="key_word" placeholder="请输入轮播图需要跳转的页面路由" value="{{old('key_word')}}"/>
                                    @if(count($errors)>0)
                                        <span class="help-block">{{$errors -> first('key_word')}}</span>
                                    @endif
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
    <script src="{{url('js/admin/jquery.ui.custom.js')}}"></script>
    <script src="{{url('js/admin/bootstrap.min.js')}}"></script>
    <script src="{{url('js/admin/bootstrap-colorpicker.js')}}"></script>
    <script src="{{url('js/admin/jquery.uniform.js')}}"></script>
    <script src="{{url('js/admin/unicorn.form_common.js')}}"></script>
    <script src="{{url('js/admin/addNews.js')}}"></script>
    <script>
        //选择图片，马上预览
        function xmTanUploadImg(obj) {
            var file = obj.files[0];
            console.log(obj);
            console.log(file);
            console.log("file.size = " + file.size);  //file.size 单位为byte
            var reader = new FileReader();
            //读取文件过程方法
            reader.onloadstart = function (e) {
                console.log("开始读取....");
            }
            reader.onprogress = function (e) {
                console.log("正在读取中....");
            }
            reader.onabort = function (e) {
                console.log("中断读取....");
            }
            reader.onerror = function (e) {
                console.log("读取异常....");
            }
            reader.onload = function (e) {
                console.log("成功读取....");

                var img = document.getElementById("xmTanImg");
                img.src = e.target.result;
                //或者 img.src = this.result;  //e.target == this
            }

            reader.readAsDataURL(file)
        }
    </script>
@endsection