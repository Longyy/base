<!DOCTYPE html>
<html lang="en" class="app">
<head>
    <meta charset="utf-8" />
    <title>TITLE - @yield('title')</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="stylesheet" href="/admin/css/app.v2.css" type="text/css" />
    <link rel="stylesheet" href="/admin/css/common.css" type="text/css" />
    <!--[if lt IE 9]>
    <script src="/admin/js/ie/html5shiv.js" cache="false"></script>
    <script src="/admin/js/ie/respond.min.js" cache="false"></script>
    <script src="/admin/js/ie/excanvas.js" cache="false"></script>
    <![endif]-->

    @yield('before-css')
    @yield('before-js')
</head>

<body>

    <section class="vbox">
        @include('admin.public.header')

        <section>
            <section class="hbox stretch">
                @include('admin.public.left-side')
                @yield('content')
                @include('admin.public.right-side')
            </section>
        </section>

        @include('admin.public.footer')
    </section>

    <script src="/admin/js/app.v2.js"></script>
    @yield('after-js')
</body>
</html>