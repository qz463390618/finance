<!doctype html>
<html lang="en">
<header></header>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{url('css/admin/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{url('css/admin/bootstrap-responsive.min.css')}}" />
    <link rel="stylesheet" href="{{url('css/admin/unicorn.main.css')}}" />
    <link rel="stylesheet" href="{{url('css/admin/unicorn.grey.css')}}" class="skin-color" />
    <title>@yield('title', '后台')</title>
    @yield('my-css')
</head>
<body>

<div id="header">
<h1><a href="{{url('/admin')}}">Unicorn Admin</a></h1>
</div>

<div id="search">
    <input type="text" placeholder="搜索内容..." /><button type="submit" class="tip-right" title="Search"><i class="icon-search icon-white"></i></button>
</div>
<div id="user-nav" class="navbar navbar-inverse">
    <ul class="nav btn-group">
        <li class="btn btn-inverse"><a title="" href="#"><i class="icon icon-user"></i> <span class="text">整体</span></a></li>
        <li class="btn btn-inverse dropdown" id="menu-messages"><a href="#" data-toggle="dropdown" data-target="#menu-messages" class="dropdown-toggle"><i class="icon icon-envelope"></i> <span class="text">信息</span> <span class="label label-important">5</span> <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a class="sAdd" title="" href="#">最新信息</a></li>
                <li><a class="sInbox" title="" href="#">收件箱</a></li>
                <li><a class="sOutbox" title="" href="#">发件箱</a></li>
                <li><a class="sTrash" title="" href="#">垃圾箱</a></li>
            </ul>
        </li>
        <li class="btn btn-inverse"><a title="" href="#"><i class="icon icon-cog"></i> <span class="text">设置</span></a></li>
        <li class="btn btn-inverse"><a title="" href="{{url('/admin/logout')}}"><i class="icon icon-share-alt"></i> <span class="text">退出</span></a></li>
    </ul>
</div>

<div id="sidebar">
    <a href="#" class="visible-phone"><i class="icon icon-home"></i> 控制台</a>
    <ul>
        <li class="active"><a href="{{url('/admin')}}"><i class="icon icon-home"></i> <span>首页</span></a></li>
        <li class="submenu">
            <a href="#"><i class="icon icon-th-list"></i> <span>权限系统</span> <span class="label">3</span></a>
            <ul>
                <li><a href="{{url('/admin/rbac/user')}}">用户管理</a></li>
                <li><a href="{{url('/admin/rbac/role')}}">角色管理</a></li>
                <li><a href="{{url('/admin/rbac/rights')}}">权限管理</a></li>
            </ul>
        </li>
        <li><a href="{{url('admin/column')}}"><i class="icon icon-th"></i> <span>栏目管理</span></a></li>
        <li><a href="{{url('admin/class')}}"><i class="icon icon-th"></i> <span>分类管理</span></a></li>
        <li><a href="{{url('admin/information')}}"><i class="icon icon-th"></i> <span>信息中心</span></a></li>
        <li><a href="{{url('admin/education')}}"><i class="icon icon-th"></i> <span>投资者教育</span></a></li>
        <li><a href="{{url('admin/contact')}}"><i class="icon icon-th"></i> <span>联系我们</span></a></li>
        <li class="submenu">
            <a href="#"><i class="icon icon-th-list"></i> <span>首页管理</span> <span class="label">1</span></a>
            <ul>
                <li><a href="{{url('/admin/index/slide')}}">轮播图管理</a></li>
            </ul>
        </li>
        {{--<li class="submenu">
            <a href="#"><i class="icon icon-th-list"></i> <span>信息中心</span> <span class="label">3</span></a>
            <ul>
                <li><a href="{{url('/admin/information/announcement')}}">中心公告</a></li>
                <li><a href="{{url('/admin/information/dynamics')}}">中心动态</a></li>
                <li><a href="{{url('/admin/information/impnews')}}">资讯要闻</a></li>
            </ul>
        </li>--}}
    </ul>

</div>


<div id="content">
    @section('content')

    @show
</div>

<script src="{{url('js/admin/jquery.min.js')}}"></script>
<script src="{{url('js/admin/unicorn.js')}}"></script>
@yield('my-js')
</body>
</html>