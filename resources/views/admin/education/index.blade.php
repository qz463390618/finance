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
        <div class="clearfix" style="margin-top: 15px;">
            <p class="" style="float: left; width:20%;" >
                <button class="btn btn-large" onclick="window.location.href='{{url('admin/education/add')}}'">添加资讯</button>
            </p>
            <div class="" style="float: left;width:80%;height:44px;text-align: -webkit-right;line-height: 44px;">
                <form action="{{url('/admin/education/search')}}" id="searchForm" {{--onsubmit="return searchData();"--}}>
                    搜索:
                    <select style="margin-bottom: 0;width: 100px;">
                        <option value="0" selected="">不限属性</option>
                    </select>
                    <input name="keyboard" type="text" id="keyboard" value="" size="16" style="margin-bottom: 0;">
                    <select name="show" style="margin-bottom: 0; width: 110px;">
                        <option value="0" selected="">不限字段</option>
                        <option value="title">标题</option>
                        <option value="writer">作者</option>
                        <option value="befrom">来源</option>
                        <option value="news_id">id</option>
                    </select>
                    <select name="infolday" style="margin-bottom: 0;width: 110px;">
                        <option value="1">全部时间</option>
                        <option value="86400">1 天</option>
                        <option value="172800">2 天</option>
                        <option value="604800">1 周</option>
                        <option value="2592000">1 个月</option>
                        <option value="7948800">3 个月</option>
                        <option value="15897600">6 个月</option>
                        <option value="31536000">1 年</option>
                    </select>
                    <input type="submit" name="Submit2" value="搜索">
                </form>
            </div>
        </div>
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
                                        <td>{{$news -> news_id}}</td>
                                        <td>{{$news ->title}}</td>
                                        <td>{{$news->column_name}}</td>
                                        <td>{{$news ->writer}}</td>
                                        <td>{{date('Y-m-d H:i:s',$news ->truetime)}}</td>
                                        <td>{{$news->onclick}}</td>
                                        <td><a href="{{url('/admin/education/edit').'/'.$news ->news_id}}">修改</a><span style="margin:0 10px;">|</span><a href="javascript:delNews({{$news ->news_id}})">删除</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div style="text-align: center;">
                        <?php

                        if(!empty($search))
                        {
                            echo $newses ->appends(
                                [
                                    'show'=> isset($search['show']) ? $search['show']: '',
                                    'keyboard'=> isset($search['keyboard']) ? $search['keyboard']: '',
                                    'infolday'=> isset($search['infolday']) ? $search['infolday']: '',
                                ]
                            )-> links();
                        }else{
                            echo $newses -> links();
                        }


                        ?>
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