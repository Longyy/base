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
                    <li><a href="index.html"><i class="fa fa-home"></i> 系统设置</a></li>
                    <li class="active">权限管理</li>
                </ul>
<form id="form" action="/backend/perm/user_group/update" method="post" data-parsley-validate>
    <input type="hidden" name="iAutoID" value=""/>
                <section class="panel panel-default panel-rounded4">
                    <div class="panel-heading b-dark b-b bottom20">
                        <h3 class="panel-title">权限管理</h3>
                    </div>

                    <div class="panel-body">
                        <div class="form-horizontal edit-form-width">

                            <div class="form-group">
                                <label class="col-sm-3 control-label">名称</label>
                                <div class="col-sm-9">
                                    <input type="text" name="sName" value="" required class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">类型</label>
                                <div class="col-sm-9">
                                    <select name="iType" required class="form-control m-t">
                                        <option value="">--请选择--</option>
                                        @foreach($data['group_type'] as $key => $val)
                                            <option value="{{$key}}">{{$val}}</option>
                                        @endforeach
                                    </select>
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
    <script src="/admin/js/custom/common.js"></script>
    <script>
        function submitData()
        {
            $form = $('#form');
            var data = {
                sName: $form.find("input[name='sName']").val(),
                iType: $form.find("select[name='iType']").val()
            };
            var resultInfo = {};
            $.ajax({
                type: 'POST',
                url: '/backend/perm/user_group/save',
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
            return resultInfo;
        }
    </script>
@endsection