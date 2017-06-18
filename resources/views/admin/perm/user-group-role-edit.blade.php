@extends('admin.layouts.main')
{{--{{dd($data)}}--}}
@section('content')

    <section id="content">
        <section class="vbox">

            <section class="scrollable wrapper">

                <div id="alert" role="alert" style="display:none;" class=" main-alert alert alert-danger center-block col-md-4 pull-right alert-dismissible fade in">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <div id="msg"></div>
                </div>

                <ul class="breadcrumb">
                    @foreach($aPageMenu['aBreadMenu'] as $menu)
                        <li class="@if($menu['iLevel'] == 3) active @endif"><a href="{{$menu['sUrl']}}">@if($menu['iLevel'] == 1) <i class="fa fa-home"></i> @endif  {{$menu['sName']}}</a></li>
                    @endforeach
                </ul>

<form id="form" action="" method="post" data-parsley-validate>
    <input type="hidden" name="iAutoID" value="{{$data['user_group_role']['iAutoID']}}"/>
                <section class="panel panel-default panel-rounded4">
                    <div class="panel-heading b-dark b-b bottom20">
                        <h3 class="panel-title">修改所属角色</h3>
                    </div>

                    <div class="panel-body">
                        <div class="form-horizontal edit-form-width">

                            <div class="form-group">
                                <label class="col-sm-3 control-label">角色名称</label>
                                <div class="col-sm-9">
                                    <input type="text" name="sName" value="{{$data['user_group_role']['sGroupName']}}" required class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">角色类型</label>
                                <div class="col-sm-9">
                                    <select name="iType" required class="form-control m-t" id="iType" onchange="getRoleTree();">
                                        <option value="">--请选择--</option>
                                        @foreach($data['role_type'] as $key => $val)
                                            <option value="{{$key}}" @if($key == $data['user_group_role']['iRoleType'])selected @endif>{{$val}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="hidden" id="role_id" name="iRoleID" value="{{$data['user_group_role']['iRoleID']}}"/>
                                <label class="col-sm-3 control-label">所属角色</label>
                                <div class="col-sm-9">
                                    <div id="role_tree"></div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <footer class="panel-footer text-center bg-light lter">
                        <button id="submit" type="submit" class="btn btn-success" >提交</button>
                        <i class="fa fa-spin fa-spinner hide" id="spin"></i>
                        <button id="cancel" class="btn btn-danger margin-left-20" onclick="goBack();">取消</button>
                    </footer>

                </section>

</form>
            </section>


        </section>
        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>

@endsection


@section('before-css')
    <link rel="stylesheet" href="/admin/js/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" cache="false">
    <link rel="stylesheet" href="/admin/js/parsley/parsley.css" type="text/css" cache="false">
    <link rel="stylesheet" href="/admin/js/bootstraptreeview/bootstrap-treeview.css" type="text/css" cache="false">
    @endsection

    @section('before-js')
    @endsection

    @section('after-js')
    <!-- parsley -->
    <script src="/admin/js/parsley/parsley.js" cache="false"></script>
    <script src="/admin/js/parsley/i18n/zh_cn.js" cache="false"></script>
    <!-- datetimepicker -->
    <script src="/admin/js/datetimepicker/bootstrap-datetimepicker.js" cache="false"></script>
    <script src="/admin/js/datetimepicker/bootstrap-datetimepicker.zh-CN.js" cache="false"></script>
    <script src="/admin/js/bootstraptreeview/bootstrap-treeview.js" cache="false"></script>
    <script src="/admin/js/custom/common.js"></script>
    <script>
        var $alert = $('#alert'),
            $msg = $('#msg'),
            $submit = $('#submit'),
            $span = $('#span'),
            $cancel = $('#cancel');
        var $role_tree = null;

        function submitData()
        {
            $form = $('#form');
            var data = {
                iAutoID: $form.find("input[name='iAutoID']").val(),
                sName: $form.find("input[name='sName']").val(),
                iType: $form.find("select[name='iType']").val(),
                iParentID: $form.find("input[name='iParentID']").val()
            };
            var resultInfo = {};
            $.ajax({
                type: 'POST',
                url: '/backend/perm/user_group/update',
                cache: false,
                async: false,
                dataType: 'json',
                data: data,
                success: function(result){
                    resultInfo = result;
                },
                error: function(XMLHttpRequest, textStatus, errorThrown){
                    console.log(XMLHttpRequest.status);
                    console.log(XMLHttpRequest.readyState);
                    console.log(textStatus);
                }
            });
            alert(JSON.stringify(resultInfo));
            return resultInfo;
        }

        // 表单验证
        $('#form').parsley().on('form:success', function() {
            showLoading();
        }).on('form:submit', function() {
            var result = submitData();
            $msg.text(result.msg);
            if(result.code == 0) {
                $alert.removeClass('alert-danger')
                    .addClass('alert-success')
                    .toggle()
                    .animate({marginTop:"0"},500);
                setTimeout(function(){
                    $alert.fadeOut(300, function(){
                        $alert.css({"margin-top":"-85px"});
                        cancelLoading();
                        goBack();
                    });
                }, 2000);

            } else {
                $alert.removeClass('alert-success')
                    .addClass('alert-danger')
                    .toggle()
                    .animate({marginTop:"0"},100);
                setTimeout(function(){
                    $alert.fadeOut(300, function(){
                        $alert.css({"margin-top":"-85px"});
                        cancelLoading();
                    });
                }, 2000);
            }
            return false;
        });

        function getRoleTree()
        {
            var val = $("#iType").val();
            var iRoleId = $('#role_id').val();
            if(val > 0) {
                $.getJSON('/backend/perm/user_group_role/get_role_tree?iRoleType=' + val + '&iRoleID=' + iRoleId, function(res) {
                    if(res.code == 0) {
                        $role_tree = $('#role_tree').treeview({
                            levels: 1,
                            color: "#428bca",
                            borderColor: "#d9d9d9",
                            showTags: true,
                            showCheckbox: true,
                            highlightSelected: false,
                            data: res.data,
                            onNodeChecked: function(event, node) {
                                $('#role_id').val(node.id);
                            }
                        });
                    }

                });
            }
        }

        $(document).ready(function(){
            getRoleTree();
        });
    </script>
@endsection