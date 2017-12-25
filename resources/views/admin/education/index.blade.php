@extends('layouts.admin')
@section('title', '信息中心')
@section('my-css')

@endsection
@section('content')
    <div id="content-header">
        <h1>信息中心</h1>
        <div class="btn-group">
            <a class="btn btn-large tip-bottom" title="Manage Files"><i class="icon-file"></i></a>
            <a class="btn btn-large tip-bottom" title="Manage Users"><i class="icon-user"></i></a>
            <a class="btn btn-large tip-bottom" title="Manage Comments"><i class="icon-comment"></i><span class="label label-important">5</span></a>
            <a class="btn btn-large tip-bottom" title="Manage Orders"><i class="icon-shopping-cart"></i></a>
        </div>
    </div>
    <div id="breadcrumb">
        <a href="#" title="返回后台首页" class="tip-bottom"><i class="icon-home"></i> 后台</a>
        <a href="#" class="current">信息中心</a>
    </div>
    <div class="container-fluid">
        <p style="margin-top: 15px;">
            <button class="btn btn-large" onclick="window.location.href='{{url('admin/education/add')}}'">添加资讯</button>
        </p>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
								<span class="icon">
									<i class="icon-th"></i>
								</span>
                        <h5>资讯列表</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>标题</th>
                                <th>栏目</th>
                                <th>发布人</th>
                                <th>发布时间</th>
                                <th>点击</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                                <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
                                @foreach($newses as $news)
                                    <tr>
                                        <td>{{$news ['news_id']}}</td>
                                        <td>{{$news [ 'title']}}</td>
                                        <td>{{$news['column_id']}}</td>
                                        <td>{{$news ['writer']}}</td>
                                        <td>{{date('Y-m-d H:i:s',$news [ 'truetime'])}}</td>
                                        <td>{{$news['onclick']}}</td>
                                        <td><a href="{{url('/admin/education/edit').'/'.$news ['news_id']}}">修改</a><span style="margin:0 10px;">|</span><a href="javascript:delNews({{$news ['news_id']}})">删除</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div style="text-align: center;">
                        {{--{{$data -> links()}}--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('my-js')
    <script>

        function delNews(id)
        {
            var con = confirm('请问是否是要删除这条数据');
            if(con == true)
            {
                data = {
                    id :id,
                    _token:$('#token').val()
                };
                $.ajax({
                    url:'/admin/education/del',
                    type:'post',
                    async:false,
                    data:data,
                    success:function(data){
                        if(data == 1)
                        {
                            location.replace(location.href);
                        }else{
                            alert('删除失败');
                        }
                    }
                });
            }else{
                return false;
            }
        }
    </script>
@endsection