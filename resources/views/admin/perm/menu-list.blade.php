@extends('admin.layouts.main')
{{--{{dd($aPageMenu)}}--}}
@section('content')

    <section id="content">
        <section class="vbox">

            <section class="scrollable wrapper">

                <ul class="breadcrumb">
                    @foreach($aPageMenu['aBreadMenu'] as $menu)
                        <li class="@if($menu['iLevel'] == 3) active @endif"><a href="{{$menu['sUrl']}}">@if($menu['iLevel'] == 1) <i class="fa fa-home"></i> @endif  {{$menu['sName']}}</a></li>
                    @endforeach
                </ul>

                <section class="panel panel-default panel-rounded4">
                    <div class="panel-heading b-dark b-b bottom20">
                        <h3 class="panel-title">菜单管理</h3>
                    </div>

                    <div id="toolbar">
                        <div class="row">
                            <div class="col-sm-8">
                                <form  id="searchForm">
                                    <div class="form-inline" role="form">
                                        <div class="form-group">
                                            <input name="sName" class="form-control input-sm " type="text" placeholder="名称">
                                        </div>
                                        <div class="form-group">
                                            <button id="ok" type="submit" class="btn btn-sm btn-default">搜索</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-4 text-right">
                                <a href="/backend/perm/menu/create" class="btn btn-primary  btn-sm">新增</a>
                                <a href="#" class="btn btn-danger btn-sm delete">删除</a>
                            </div>
                        </div>

                    </div>

                    <table id="table"></table>

                </section>
            </section>

        </section>
        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>

@endsection

@section('before-css')
    <link rel="stylesheet" href="/admin/js/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" cache="false">
    <link rel="stylesheet" href="/admin/js/bootstraptable/bootstrap-table.css" type="text/css" cache="false">
    <link rel="stylesheet" href="/admin/js/jquery-confirm/jquery-confirm.css" type="text/css" cache="false">
    <link rel="stylesheet" href="/admin/js/bootstraptable/tree-columns/bootstrap-table-tree-column.css" type="text/css" cache="false">

@endsection

@section('before-js')
@endsection

@section('after-js')
        <!-- parsley -->
    <script src="/admin/js/parsley/parsley.min.js" cache="false"></script>
    {{--<script src="/admin/js/parsley/parsley.extend.js" cache="false"></script>--}}
    <!-- datetimepicker -->
    <script src="/admin/js/datetimepicker/bootstrap-datetimepicker.js" cache="false"></script>
    <script src="/admin/js/datetimepicker/bootstrap-datetimepicker.zh-CN.js" cache="false"></script>
    <!-- datatable -->
    <script src="/admin/js/bootstraptable/bootstrap-table.js" cache="false"></script>
    <script src="/admin/js/bootstraptable/bootstrap-table-zh-CN.js" cache="false"></script>
    <script src="/admin/js/jquery-confirm/jquery-confirm.js" cache="false"></script>
    <script src="/admin/js/bootstraptable/tree-columns/bootstrap-table-tree-column.js" cache="false"></script>

    <script src="/admin/js/custom/common.js"></script>

    <script>
        var $ok = $('#ok');
        var $table = $('#table');
        var tableListUrl = "/backend/perm/menu/get_list";
        var tableEditUrl = "/backend/perm/menu/edit";
        var tableDelUrl = "/backend/perm/menu/delete";
        var tableNewUrl = "/backend/perm/menu/create";
        var tableColumns = [
            {
                field: "state",
                checkbox: true
            }, {
                field: "iAutoID",
                title: "ID",
                sortable: true,
                switchable: false
            },{
                field: "sName",
                title: "菜单名称",
                width: "20%",
                sortable: true,
                switchable: false
            }, {
                field: "sType",
                title: "类型"
            }, {
                field: "sBusinessType",
                title: "业务类型",
                sortable: true
//            },{
//                field: "sAndroidPath",
//                title: "Android路径"
//            }, {
//                field: "sIosPath",
//                title: "IOS路径"
//            }, {
//                field: "sH5Path",
//                title: "H5路径"
            }, {
                field: "iGroup",
                title: "分组"
            }, {
                field: "sWebPath",
                title: "Web路径"
            }, {
                field: "sParam",
                title: "菜单参数"
            }, {
                field: "iJumpType",
                title: "跳转类型",
                formatter: function(value,row,index){return value==1 ? "内页" : "新页";}
            }, {
                field: "sRealUrl",
                title: "真实地址"
            }, {
                field: "iLeaf",
                title: "是否叶子结点",
                formatter: function(value,row,index){return value==1 ? "否" : "是";}
            }, {
                field: "iShow",
                title: "是否有效",
                formatter: function(value,row,index){return value==1 ? "否" : "是";}
            }, {
                field: "iDisplay",
                title: "是否展示",
                formatter: function(value,row,index){return value==1 ? "是" : "否";}
            }, {
                field: "sIcon",
                title: "IconFont"
            }, {
                field: "iOrder",
                title: "排序",
                sortable: true
            }, {
                field: "iHome",
                title: "是否是首页",
                formatter: function(value,row,index){return value==2 ? "是" : "否";}
            }, {
                field: "iCreateTime",
                title: "创建时间",
                sortable: true,
                visible: false
            }, {
                field: "iUpdateTime",
                title: "更新时间",
                visible: false
            }, {
                title: "操作",
                formatter: "addActionBtn",
                switchable: false
            }
        ];
        // 定义搜索规则
        var searchField = {};
        // 表格
        $(document).ready( function () {
            $table.bootstrapTable({
                dataLocale: "zh-CN",
                pagination: true,
                sidePagination: "server",
                pageSize: 10,
                paginationFirstText: "首页",
                paginationPreText: "上一页",
                paginationNextText: "下一页",
                paginationLastText: "尾页",
                toolbar: "#toolbar",
                clickToSelect: true,
                queryParams: "queryParams",
                cache: false,
                ajax: "ajaxRequestData",
                dataField: "rows",
                totalFile: "total",
                columns: tableColumns,
                treeShowField: 'sName',
                showColumns: true
            });
        });
        // 数据加载规则
        function ajaxRequestData(params) {
             var data = {};
            // 筛选参数
            $.each(params.data.search, function(key, field) {
                if(field != '') {
                    for(var i in searchField) {
                        if(i === key) {
                            data[searchField[i]] = field;
                            return true;
                        }
                    }
                    data[key] = field;
                }
            });
            // 排序参数
            if( typeof(params.data.sort) != "undefined" && typeof(params.data.order) != "undefined") {
                var sort = params.data.order == 'asc' ? '+' : '-';
                data._sOrder = sort + params.data.sort;
            }
            // 分页参数
            if(typeof(params.data.offset) != 'undefined' && typeof(params.data.limit) != 'undefined') {
                var sort = params.data.order == 'asc' ? '+' : '-';
                data.page = params.data.offset / params.data.limit + 1;
                data.page_size = params.data.limit;
            }
            console.log(data);
            $.ajax({
                type: "get",
                url: tableListUrl,
                data: data,
                success: function(res) {
                    if(res.code == 0) {
                        params.success({
                            total: res.data.total,
                            rows: res.data.data
                        });
                    }
                }
            });
        }


        $(function () {
            $ok.click(function () {
                $table.bootstrapTable('refresh');
                return false;
            });
        });

        /**
         * 添加搜索参数
         * @param params
         * @returns {*}
         */
        function queryParams(params) {
            var search = {};
            $.each($('#searchForm').serializeArray(), function(i, field) {
                search[field.name] = field.value;
            });
            params.search = search;
            return params;
        }

        /**
         * 添加操作按钮
         * @param value
         * @param row
         * @returns {string}
         */
        function addActionBtn(value, row) {
            return '<a href="'+tableEditUrl+'?iAutoID=' + row.iAutoID + '" class="btn btn-default btn-xs">编辑</a>';
        }

        // 删除操作
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
                                url: tableDelUrl,
                                cache: false,
                                async: false,
                                dataType: 'json',
                                data: data,
                                success: function(result){
                                    if(result.code == 0) {

                                    }
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

        function gotoCreate()
        {
            goTo(tableNewUrl);
            return false;
        }

    </script>
@endsection