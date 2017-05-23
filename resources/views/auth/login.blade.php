<!DOCTYPE html>
<html lang="en" class="bg-dark">
<head>
    <meta charset="utf-8" />
    <title>Notebook | Web Application</title>
    <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="stylesheet" href="/admin/css/app.v2.css" type="text/css" />
    <link rel="stylesheet" href="/admin/css/common.css" type="text/css" />
    <!--[if lt IE 9]>
    <script src="/admin/js/ie/html5shiv.js" cache="false"></script>
    <script src="/admin/js/ie/respond.min.js" cache="false"></script>
    <script src="/admin/js/ie/excanvas.js" cache="false"></script>
    <![endif]-->

</head>
<body>
<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
    <div class="container aside-xxl"> <a class="navbar-brand block" href="index.html">Notebook</a>
        <section class="panel panel-default bg-white m-t-lg">
            <header class="panel-heading text-center"> <strong>登录</strong> </header>
            <form action="/auth/login" method="post" class="panel-body wrapper-lg">
                {!! csrf_field() !!}
                <div class="form-group">
                    <label class="control-label">用户</label>
                    <input type="username" name="email" placeholder="请输入用户名" class="form-control input-lg">
                </div>
                <div class="form-group">
                    <label class="control-label">密码</label>
                    <input type="password" name="password" id="inputPassword" placeholder="请输入密码" class="form-control input-lg">
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember">
                        记住我 </label>
                </div>
                <a href="#" class="pull-right m-t-xs"><small>忘记密码?</small></a>
                <button type="submit" class="btn btn-primary">登录</button>
                <div class="line line-dashed"></div>
                <p class="text-muted text-center"><small>还没有账号?</small></p>
                <a href="/auth/register" class="btn btn-default btn-block">注册账号</a>
            </form>
        </section>
    </div>
</section>

<script src="/admin/js/app.v2.js"></script>
</body>
</html>

