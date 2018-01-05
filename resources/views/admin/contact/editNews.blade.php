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
        <a href="{{url('/admin/')}}" class="tip-bottom">文章列表</a>
        <a href="#" class="current">修改文章</a>
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
                        <form action="{{url('/admin/contact/doEdit')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input type="hidden" name="news_id" value="{{$news->news_id}}">
                            <div class="control-group">
                                <label class="control-label">招聘部门</label>
                                <div class="controls">
                                    <input type="text" name="department" placeholder="请输入需要招聘的部门" value="{{old('department') ? old('department'): $news -> department}}"/>
                                    @if(count($errors)>0)
                                        <span class="help-block">{{$errors -> first('department')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">招聘职位</label>
                                <div class="controls">
                                    <input type="text" name="position" placeholder="请输入需要招聘的职位" value="{{old('position') ? old('position'): $news -> position}}"/>
                                    @if(count($errors)>0)
                                        <span class="help-block">{{$errors -> first('position')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">工作职责</label>
                                <div class="controls">
                                    <textarea name="duty" rows="7"><?php echo  old('duty') ? old('duty'):$news -> duty ?></textarea>
                                    @if(count($errors)>0)
                                        <span class="help-block">{{$errors -> first('duty')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">工作需求</label>
                                <div class="controls">
                                    <textarea name="demand" rows="7"><?= old('demand') ? old('demand'):$news -> demand ?></textarea>
                                    @if(count($errors)>0)
                                        <span class="help-block">{{$errors -> first('demand')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">创建时间</label>
                                <div class="controls">
                                    <input type="text" name="truetime"  value="{{date('Y-m-d H:i:s',$news->truetime)}}" readonly/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">最后修改时间</label>
                                <div class="controls">
                                    <input type="text" name="truetime"  value="{{date('Y-m-d H:i:s',$news->lastdotime)}}" readonly/>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="button" class="btn btn-primary submit">编辑</button>
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
    <!--格式话文本-->
    <script>
        $(function()
        {
            var demand1 = $('textarea[name=demand]').val();
            var duty1 = $('textarea[name=duty]').val();
            var reg=new RegExp("<br>","g"); //创建正则RegExp对象

            duty1 = duty1.replace(new RegExp("<br>", "gm"), "\n");
            demand1 = demand1.replace(new RegExp("<br>", "gm"), "\n");
            console.log(demand1);
            console.log(duty1);
            $('textarea[name=demand]').val(demand1);
            $('textarea[name=duty]').val(duty1);

        });
        $('button.submit').click(function(){
            var demand = $('textarea[name=demand]').val();
            var duty = $('textarea[name=duty]').val();
            demand = demand.replace(new RegExp("\n", "gm"), "<br>");
            duty = duty.replace(new RegExp("\n", "gm"), "<br>");
            $('textarea[name=demand]').val(demand);
            $('textarea[name=duty]').val(duty);
            $('form').submit();
        });
    </script>
@endsection