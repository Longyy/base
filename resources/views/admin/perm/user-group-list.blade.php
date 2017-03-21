@extends('admin.layouts.main')
{{--{{dd($aPageMenu)}}--}}
@section('content')

    <section id="content">
        <section class="vbox">
            <header class="header bg-white b-b clearfix">
                <div class="row m-t-sm">
                    <div class="col-sm-8 m-b-xs">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-default" title="Refresh"><i class="fa fa-refresh"></i></button>
                            <button type="button" class="btn btn-sm btn-default" title="Remove"><i class="fa fa-trash-o"></i></button>
                            <button type="button" class="btn btn-sm btn-default" title="Filter" data-toggle="dropdown"><i class="fa fa-filter"></i> <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Separated link</a></li>
                            </ul>
                        </div>
                        <a href="#modal-create" data-toggle="modal" class="btn btn-sm btn-default"><i class="fa fa-plus"></i> Create</a> </div>
                    <div class="col-sm-4 m-b-xs">
                        <div class="input-group">
                            <input type="text" class="input-sm form-control search-text" placeholder="Search">
                      <span class="input-group-btn">
                      <button class="btn btn-sm btn-default" type="button" id="data-search">Go!</button>
                      </span> </div>
                    </div>
                </div>
            </header>

            <section class="scrollable wrapper w-f">
                <section class="panel panel-default">
                    <div class="table-responsive">
                        <!--<th class="th-sortable" data-sortfield="project" data-sortstatus="desc" data-toggle="class">Project <span class="th-sort"> <i class="fa fa-sort-down text"></i> <i class="fa fa-sort-up text-active"></i> <i class="fa fa-sort"></i> </span> </th>-->
                        <table  id="datatables"  class="table table-striped table-hover m-b-none data-action">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>规则名</th>
                                <th>中文名</th>
                                <th>状态</th>
                                <th style="width:290px;">操作</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </section>
            </section>

            <footer class=" hide footer bg-white b-t">
                <div class="text-center-xs">
                    <p class="text-muted m-t">@平安科技 2017</p>
                </div>

            </footer>
        </section>
        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>

@endsection


@section('before-css')
    <link rel="stylesheet" href="/admin/js/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" cache="false">
    <link rel="stylesheet" href="/admin/js/datatables/datatables.css" type="text/css" cache="false">
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
    <script src="/admin/js/datatables/jquery.dataTables.js" cache="false"></script>

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
                dataType: 'json',
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

        // datatable
        $(document).ready( function () {
            var id = 0;
            var table = $('#datatables');

            table.dataTable({
//        "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
//        "sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
//        "sPaginationType": "bootstrap",//分页样式使用bootstrap
                "order": [[ 1, "desc" ]],
                "oLanguage": {//语言设置
                    "sLengthMenu": "每页显示  _MENU_ 条记录",
                    "sInfo": "从 _START_ 到 _END_ /共 _TOTAL_ 条数据",
                    "oPaginate": {
                        "sFirst": "首页",
                        "sPrevious": "前一页",
                        "sNext": "后一页",
                        "sLast": "尾页"
                    },
                    "sZeroRecords": "抱歉， 没有找到",
                    "sInfoEmpty": "没有数据"
                },
                "bProcessing": true, //当datatable获取数据时候是否显示正在处理提示信息。
                "bServerSide": true, //客户端处理分页
                "ajax": {
                    "url": "/datatable.php",
                    "type": "POST",
                    "data": function(d) {
                        d.myKey = "myValue"
                        // d.custom = $("#myInput").val()
                    }
                },
                "bStateSave": true, //开关，是否打开客户端状态记录功能。这个数据是记录在cookies中的，打开了这个记录后，即使刷新一次页面，或重新打开浏览器，之前的状态都是保存下来的
                "aoColumnDefs": [
                    {
                        "aTargets": [0],
                        "mData": null,
                        "mRender": function(data, type, full) {
                            var hiddenId = '<input type="hidden" name="id" value="'+full[0]+'"/>';
                            return full[0] + hiddenId;
                        }
                    },
                    { //给每个单独的列设置不同的填充，或者使用aoColumns也行
                        "aTargets": [3],
                        "mData": null,
                        "bSortable": false,
                        "bSearchable": false,
                        "mRender": function (data, type, full) {
                            if(full[3] == 1){
                                return "使用中"
                            }else if(full[3] == 0){
                                return "禁用"
                            }
                        }
                    },{
                        "aTargets": [4],
                        "mData": null,
                        "bSortable": false,
                        "bSearchable": false,
                        "mRender": function (data, type, full) {
                            return '<a data-toggle="modal" data-target="#myModal"  data-title="' + full[0] + '"  class="btn btn-success edit" href="#"><i class="icon-edit icon-white"></i>修改</a>' +'&nbsp;&nbsp;'+'<a   data-title="' + full[0] + '"  class="btn btn-primary" href="/config/edit?aid=' + full[0] + '"><i class="icon-wrench icon-white" ></i>配置</a>' +'&nbsp;&nbsp;'+'<a   alt="' + full[2] + '"  class="btn btn-info" href="#"  data-toggle="modal" data-target="#daima"><i class="icon-tasks icon-white"></i>代码</a>' +'&nbsp;&nbsp;'+'<a   data-title="' + full[0] + '"  class="btn btn-warning" href="/service/show?aid=' + full[0] + '"><i class="icon-user icon-white"></i>客服</a>';
                        }
                    }]

            });

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