@extends('admin.layouts.main')
{{--{{dd($aPageMenu)}}--}}
@section('content')

    <section id="content">
        <section class="vbox">

            <section class="scrollable wrapper">

                <ul class="breadcrumb">
                    @foreach($aPageMenu['aBreadMenu'] as $menu)
                        <li class="@if($menu['level'] == 2) active @endif"><a href="{{$menu['link']}}">@if($menu['level'] == 0) <i class="fa fa-home"></i> @endif  {{$menu['title']}}</a></li>
                    @endforeach
                </ul>

                <section class="panel panel-default panel-rounded4">
                    <div class="panel-heading b-dark b-b bottom20">
                        <h3 class="panel-title">权限管理</h3>
                    </div>

                    <div id="toolbar">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-inline" role="form">
                                    <div class="form-group">
                                        <span>状态: </span>
                                        <input name="offset" class="form-control input-sm w70" type="number" value="0">
                                    </div>
                                    <div class="form-group">
                                        <span>年龄: </span>
                                        <input name="limit" class="form-control input-sm w70" type="number" value="5">
                                    </div>
                                    <div class="form-group">
                                        <input name="search" class="form-control input-sm " type="text" placeholder="名称">
                                    </div>
                                    <div class="form-group">
                                        <button id="ok" type="submit" class="btn btn-sm btn-default">OK</button>
                                    </div>

                                </div>
                            </div>
                            <div class="col-sm-4 text-right">
                                <a href="/backend/perm/user_group/create" class="btn btn-primary  btn-sm">新增</a>
                                <a href="#" class="btn btn-danger btn-sm delete">删除</a>
                            </div>
                        </div>

                    </div>


                    <table id="table"
                           data-toggle="table"
                           data-url="/backend/perm/user_group/get_list"
                           data-side-pagination="server"
                           data-pagination="true"
                           data-page-size="5"
                           data-page-list="[10, 20, 50]"
                           data-pagination-first-text="首页"
                           data-pagination-pre-text="上一页"
                           data-pagination-next-text="下一页"
                           data-pagination-last-text="尾页"
                           data-query-params="queryParams"
                           data-click-to-select="true"
                           data-toolbar="#toolbar">
                        <thead>
                        <tr>
                            <th data-field="state" data-checkbox="true"
                                data-formatter="stateFormatter"></th>
                            <th data-field="iAutoID">ID</th>
                            <th data-field="sName">名称</th>
                            <th data-field="iType">类型</th>
                            <th data-field="iCreateTime">创建时间</th>
                            <th data-field="iUpdateTime">更新时间</th>
                            <th data-formatter="addActionBtn">操作</th>
                        </tr>
                        </thead>
                    </table>
                </section>
            </section>

        </section>
        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>

@endsection


@section('before-css')
    <link rel="stylesheet" href="/admin/js/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" cache="false">
    <link rel="stylesheet" href="/admin/js/bootstraptable/bootstrap-table.css" type="text/css" cache="false">
    <link rel="stylesheet" href="/admin/js/jquery-confirm/jquery-confirm.css" type="text/css" cache="false">
@endsection

@section('before-js')
@endsection

@section('after-js')
        <!-- parsley -->
    <script src="/admin/js/parsley/parsley.min.js" cache="false"></script>
    <script src="/admin/js/parsley/parsley.extend.js" cache="false"></script>
    <!-- datetimepicker -->
    <script src="/admin/js/datetimepicker/bootstrap-datetimepicker.js" cache="false"></script>
    <script src="/admin/js/datetimepicker/bootstrap-datetimepicker.zh-CN.js" cache="false"></script>
    <!-- datatable -->
    <script src="/admin/js/bootstraptable/bootstrap-table.js" cache="false"></script>
    <script src="/admin/js/jquery-confirm/jquery-confirm.js" cache="false"></script>

    <script src="/admin/js/custom/common.js"></script>

    <script>
        // 日期
        $('.form-date').datetimepicker({
            format: 'yyyy-mm-dd',
            language:  'zh-CN',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0
        });


        var $table = $('#table');
        $ok = $('#ok');
        $(function () {
            $ok.click(function () {
                $table.bootstrapTable('refresh');
            });
        });

        function queryParams() {
            var params = {};
            $('#toolbar').find('input[name]').each(function () {
                params[$(this).attr('name')] = $(this).val();
            });
            return params;
        }

        function stateFormatter(value, row, index) {

            return value;
        }

        function addActionBtn(value, row) {
            return '<a href="/backend/perm/user_group/edit?iAutoID=' + row.iAutoID + '" class="btn btn-default btn-xs">编辑</a>';
        }

        $(document).ready( function () {

        });


        $('.delete').on('click', function () {
            $.alert({
                title: '提示',
                content: '确认删除？',
                animation: 'top',
                closeAnimation: 'bottom',
                backgroundDismiss: true,
                buttons: {
                    'confirm': {
                        text: '确定',
                        btnClass: 'btn-blue',
                        action: function () {
                            alert(JSON.stringify($table.bootstrapTable('getSelections')));
                            var selected = $table.bootstrapTable('getSelections');
                            var selectedId = [];
                            $.each(selected, function(index,value){
                                selectedId[index] = value.iAutoID;
                            });

                            var data = {
                                sAutoID: selectedId.join(',')
                            };

                            $.ajax({
                                type: 'POST',
                                url: '/backend/perm/user_group/delete',
                                cache: false,
                                async: false,
                                dataType: 'json',
                                data: data,
                                success: function(result){
                                    alert(result.msg);
                                    $table.bootstrapTable('refresh');
                                },
                                error: function(XMLHttpRequest, textStatus, errorThrown){
                                    console.log(XMLHttpRequest.status);
                                    console.log(XMLHttpRequest.readyState);
                                    console.log(textStatus);
                                }
                            });

                        }
                    },
                    'cancel': {
                        text:'取消',
                        action: function(){
                        }
                    }
                }
            });
        });

    </script>
@endsection