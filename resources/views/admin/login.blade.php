<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>login</title>
    <link rel="stylesheet" type="text/css" href="{{url('css/admin/normalize.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{url('css/admin/demo.css')}}" />
    <!--必要样式-->
    <link rel="stylesheet" type="text/css" href="{{url('css/admin/component.css')}}" />

    <script src="{{url('js/admin/html5.js')}}"></script>

</head>
<body>
<div class="container demo-1">
    <div class="content">
        <div id="large-header" class="large-header">
            <canvas id="demo-canvas"></canvas>
            <div class="logo_box">
                <h3>欢迎你</h3>
                <form action="{{url('/admin/doLogin')}}" name="f" method="post" id="user_form">
                    <div class="input_outer">
                        <span class="u_user"></span>
                        <input name="account" class="text" style="color: #FFFFFF !important" type="text" placeholder="请输入账户">
                    </div>
                    {{csrf_field()}}
                    <div class="input_outer">
                        <span class="us_uer"></span>
                        <input name="pwd" class="text" style="color: #FFFFFF !important; position:absolute; z-index:100;"value="" type="password" placeholder="请输入密码">
                    </div>
                    <div class="mb2"><a class="act-but submit" href="javascript:;" onclick="doSubmit()" style="color: #FFFFFF">登录</a></div>
                </form>
            </div>
        </div>
    </div>
</div><!-- /container -->
<script src="{{url('js/admin/TweenLite.min.js')}}"></script>
<script src="{{url('js/admin/EasePack.min.js')}}"></script>
<script src="{{url('js/admin/rAF.js')}}"></script>
<script src="{{url('js/admin/demo-1.js')}}"></script>
</body>
<script>
    function doSubmit(){
        document.getElementById('user_form').submit();
    }

</script>
</html>