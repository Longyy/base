<!DOCTYPE html>
<html lang="en" class="app">
<head>
    <meta charset="utf-8" />
    <title>TITLE - @yield('title')</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="stylesheet" href="/admin/css/app.v2.css" type="text/css" />
    <link rel="stylesheet" href="/admin/css/font.css" type="text/css" cache="false">
    <!--[if lt IE 9]>
    <script src="/admin/js/ie/html5shiv.js" cache="false"></script>
    <script src="/admin/js/ie/respond.min.js" cache="false"></script>
    <script src="/admin/js/ie/excanvas.js" cache="false"></script>
    <![endif]-->
    <style>
        .dataTables_length {
            float:left;
        }
        .dataTables_wrapper {
            overflow:hidden;
        }
        .dataTables_info {
            float:left;
        }
        .dataTables_paginate {
            float:right;
        }

        .breadcrumb {
            background-color: inherit;
            border:none;
            padding: 0;
        }
        .b-b5 {
            border-bottom: 5px solid #74ad46;
        }
        .nav>li.active>a {
            border-bottom: 3px solid #74ad46;
            padding-bottom:12px;
            background: none !important;
        }
        .nav>li>a:hover {
            background: none !important;
        }

        .panel-rounded4 {
            border-radius:4px;
        }
        .panel-heading {
            background: none !important;
            color: #717171 !important;
            padding: 10px 0;
        }
        .panel-default {
            padding:15px;
        }
        .panel-title {
            font-weight:bold;
        }
        .b-dark {
            border-color:#717171 !important;
        }
        .w70 {
            width: 70px !important;
        }
        .bottom20 {
            margin-bottom:20px !important;
        }

        #toolbar {
            width:100%;
        }

        .bs-bars {
            float:none !important;
        }

    </style>

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
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
    </script>
    @yield('after-js')
</body>
</html>