<!DOCTYPE html>
<html lang="en">
<!-- container-fluid -->
<head>
    <title>后台首页</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{url('css/admin/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{url('css/admin/bootstrap-responsive.min.css')}}" />
    <link rel="stylesheet" href="{{url('css/admin/unicorn.main.css')}}" />
    <link rel="stylesheet" href="{{url('css/admin/unicorn.grey.css')}}" class="skin-color" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
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

    </ul>

</div>


<div id="content">
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
        <a href="{{url('/admin/rights')}}" class="tip-bottom">权限管理</a>
        <a href="#" class="current">添加权限</a>
    </div>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
								<span class="icon">
									<i class="icon-align-justify"></i>
								</span>
                        <h5>添加新的权限</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form action="#" method="" class="form-horizontal" >

                            <div class="control-group">
                                <label class="control-label">权限名</label>
                                <div class="controls">
                                    <input type="text" name="" placeholder="请输入权限的简称"/>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">权限特征</label>
                                <div class="controls">
                                    <input type="text" placeholder="请输入权限的路由" />
                                    <span class="help-block"></span>
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
</div>

<script src="{{url('js/admin/jquery.min.js')}}"></script>
<script src="{{url('js/admin/unicorn.js')}}"></script>

</body>
</html>
