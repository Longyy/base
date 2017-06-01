
var $alert = $('#alert'),
    $msg = $('#msg'),
    $submit = $('#submit'),
    $span = $('#span'),
    $cancel = $('#cancel');

function goBack() {
    window.location.href = document.referrer;
}
$(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });



    function showLoading()
    {
        $submit.button('loading', '处理中');
        $span.addClass('show inline');
        $cancel.attr('disabled','disabled');
    }
    function cancelLoading()
    {
        $submit.button('reset');
        $span.removeClass('show inline');
        $cancel.removeAttr('disabled');
    }
    //
    // $('#form').parsley().on('form:success', function() {
    //     showLoading();
    // }).on('form:submit', function() {
    //     var result = submitData();
    //     $msg.text(result.msg);
    //     if(result.code == 0) {
    //
    //         $alert.removeClass('alert-danger')
    //             .addClass('alert-success')
    //             .toggle()
    //             .animate({marginTop:"0"},500);
    //         setTimeout(function(){
    //             $alert.fadeOut(300, function(){
    //                 $alert.css({"margin-top":"-85px"});
    //                 cancelLoading();
    //                 goBack();
    //             });
    //         }, 2000);
    //
    //     } else {
    //         $alert.removeClass('alert-success')
    //             .addClass('alert-danger')
    //             .toggle()
    //             .animate({marginTop:"0"},100);
    //         setTimeout(function(){
    //             $alert.fadeOut(300, function(){
    //                 $alert.css({"margin-top":"-85px"});
    //                 cancelLoading();
    //             });
    //         }, 2000);
    //     }
    //     return false;
    // });


});

function submitGroupChange(obj)
{
    var group_id = $(obj).data("id");
    $("#group_id").val(group_id);
    $("#form_change_group").submit();
}