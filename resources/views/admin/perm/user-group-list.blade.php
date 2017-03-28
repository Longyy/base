@extends('admin.layouts.main')
{{--{{dd($aPageMenu)}}--}}
@section('content')

    <section id="content">
        <section class="vbox">



            <section class="scrollable wrapper">

                <ul class="breadcrumb">
                    <li><a href="index.html"><i class="fa fa-home"></i> 系统设置</a></li>
                    <li class="active">权限管理</li>
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
                                <a href="#" class="btn btn-primary btn-s-md btn-sm">新增</a>
                                <a href="#" class="btn btn-danger btn-s-md btn-sm">删除</a>
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
                            <th data-field="iAutoID">Name</th>
                            <th data-field="sName">Stars</th>
                            <th data-field="iType">Forks</th>
                            <th data-field="iCreateTime">Description</th>
                            <th data-field="iUpdateTime">Action</th>
                            <th>操作</th>
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

    <script>
        // 删除操作
        $('.data-action .operation a').on('click', function(){
            alert($(this).attr('class'));
            return true;
        });

        // 搜索
        $('#data-search').on('click', function(event){
            alert($('.search-text').val());
            event.preventDefault();
        });

        // 排序
        $('.th-sortable').on('click', function(event) {
            if($(this).data('sortstatus') == 'desc') {
                alert($(this).data('sortfield') + ' asc');
                $(this).data('sortstatus', 'asc');
            } else {
                alert($(this).data('sortfield') + ' desc');
                $(this).data('sortstatus', 'desc');
            }
        });

        // 创建
        $('#form-create-submit').on('click', function(event) {
            initComponent();
            var name = 'longyy';
            var age = 28;
            $.ajax({
                method: 'post',
                url: 'some.php',
                data: {name:name, age:age},
                dataType: 'json'
            }).done(function(result){
                if(result.status == 0) {
                    $('#modal-create').modal('hide');
                } else {
                    showInfo('create-warning', 'warning', result.msg);
                }
                $('#form-create-submit').button('reset');
            });
        });

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

        // 重置表单
        $('#modal-create').on('hidden.bs.modal', function(){
            initComponent();
            $('#form-create')[0].reset();
        });

        // 显示提示信息
        function showInfo(position, infoType, info){
            var infoclass = '';
            if(infoType == 'warning') {
                infoclass = 'alert-danger';
            } else {
                infoclass = 'alert-success';
            }
            $('#'+position).removeClass('alert-success alert-danger ').addClass(infoclass).show().find('div').text(info);
        }

        // 初始化模态框
        function initComponent() {
            $('#create-warning').hide();
        }

        initComponent();

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

        // datatable
        $(document).ready( function () {
//            var id = 0;





            $('#datatables tbody').on( 'click', 'tr a.edit', function () {
                var id = $(this).parent().parent().find('input').val();
                data = {id:id};
                $.ajax({
                    type: 'GET',
                    data: data,
                    url: '/json/edit.php',
                    dataType: 'json',
                    success: function(json){
                        if(json.status) {
                            $("#myModal #Id").val(json.data.Id);
                            $("#myModal #Name").val(json.data.Name);
                            $("#myModal #Title").val(json.data.Title);
                            $("#myModal #Condition").val(json.data.Condition);
                            if(json.data.Status==1){$("#myModal #Status").attr("checked","checked");
                            }else{$("#myModal #Status").attr("checked",false);}
                        } else {
                            alert(json.msg);
                        }
                    }
                });
                $('#myModal').modal({keyboard:false,show:true});
            });

        });

    </script>
@endsection