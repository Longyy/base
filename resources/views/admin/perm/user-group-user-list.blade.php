@extends('admin.layouts.main')
{{--{{dd($aPageMenu)}}--}}
@section('content')

    <section id="content">
        <section class="hbox stretch">

            <aside class="aside-md bg-white b-r stretch">
                <section class="vbox">
                    <header class="header wrapper b-b ">
                        用户组结构
                        <select id="iGroupType" onchange="getUserGroupTree();">
                            <option value="">选择用户组类型</option>
                            @foreach($data['group_type'] as $key => $val)
                                <option value="{{$key}}">{{$val}}</option>
                            @endforeach
                        </select>
                    </header>
                    <seciton>
                        <div id="group-tree"></div>
                    </seciton>
                </section>

            </aside>

            <section class="scrollable wrapper stretch" style="padding:15px !important;">

                <ul class="breadcrumb">
                    @foreach($aPageMenu['aBreadMenu'] as $menu)
                        <li class="@if($menu['iLevel'] == 3) active @endif"><a href="{{$menu['sUrl']}}">@if($menu['iLevel'] == 1) <i class="fa fa-home"></i> @endif  {{$menu['sName']}}</a></li>
                    @endforeach
                </ul>

                <section class="panel panel-default panel-rounded4">
                    <div class="panel-heading b-dark b-b bottom20">
                        <h3 class="panel-title">用户组用户管理</h3>
                    </div>

                    <div id="toolbar">
                        <div class="row text-sm">
                            <div class="col-sm-4 m-b-xs">
                                <div class="btn-group">
                                    <button class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">批量设置 <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">过期时间</a></li>
                                        <li><a href="#">权限合并</a></li>
                                        <li><a href="#">添加用户组</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">删除</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-4 m-b-xs">
                                <div class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-sm btn-default active">
                                        <input type="radio" name="options" id="option1">
                                        主用户组 </label>
                                    <label class="btn btn-sm btn-default">
                                        <input type="radio" name="options" id="option2">
                                        临时用户组 </label>
                                    <label class="btn btn-sm btn-default">
                                        <input type="radio" name="options" id="option2">
                                        扩展用户组 </label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input type="text" class="input-sm form-control" placeholder="Search">
                                    <span class="input-group-btn">
                        <button class="btn btn-sm btn-default" type="button">Go!</button>
                        </span> </div>
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
    <link rel="stylesheet" href="/admin/js/bootstraptreeview/bootstrap-treeview.css" type="text/css" cache="false">

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
    <script src="/admin/js/bootstraptreeview/bootstrap-treeview.js" cache="false"></script>

        <script src="/admin/js/custom/common.js"></script>

    <script>
        var $ok = $('#ok');
        var $table = $('#table');
        var tableListUrl = "/backend/perm/user_group_user/get_list";
        var tableEditUrl = "/backend/perm/user_group_user/edit";
        var tableDelUrl = "/backend/perm/user_group_user/delete";
        var tableNewUrl = "/backend/perm/user_group_user/create";
        var tableColumns = [
            {
                field: "state",
                checkbox: true
            }, {
                field: "iAutoID",
                title: "ID",
                sortable: true
            }, {
                field: "iUserID",
                title: "用户名称"
            }, {
                field: "iGroupID",
                title: "用户组名称",
                sortable: true
            }, {
                field: "iGroupType",
                title: "用户组类型",
                sortable: true
            }, {
                field: "iExpireTime",
                title: "过期时间",
                sortable: true
            }, {
                field: "iPrepend",
                title: "是否合并权限",
                sortable: true
            }, {
                field: "iCreateTime",
                title: "创建时间",
                sortable: true
            }, {
                field: "iUpdateTime",
                title: "更新时间"
            }, {
                title: "操作",
                formatter: "addActionBtn"
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
                columns: tableColumns
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
            return '<a href="'+tableEditUrl+'?iAutoID=' + row.iAutoID + '" class="btn btn-default btn-xs">编辑</a>'
                + '&nbsp;<a href="'+tableEditUrl+'?iAutoID=' + row.iAutoID + '" class="btn btn-default btn-xs">查看用户组</a>';
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

        function getUserGroupTree()
        {
            var val = $("#iGroupType").val();
            if(val > 0) {
                $.getJSON('/backend/perm/user_group/get_user_group_tree?iGroupType=' + val, function(res) {
                    if(res.code == 0) {
                        $group_tree = $('#group-tree').treeview({
                            levels: 1,
                            color: "#428bca",
                            borderColor: "#d9d9d9",
                            showTags: false,
                            showCheckbox: false,
                            highlightSelected: true,
                            data: res.data,
                            onNodeChecked: function(event, node) {
                                $('#parent_id').val(node.id);
                            },
                            onNodeSelected: function(event, node) {
                                console.log(node);
                                loadTableData(node.id);
                            }
                        });
//                        selectNode();
                    }

                });
            }
        }

        function loadTableData(nodeId) {
            $table.bootstrapTable('refresh');
        }

    </script>
@endsection