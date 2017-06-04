
function goBack() {
    window.location.href = document.referrer;
}

function goTo(url) {
    window.location.href = url;
}

$(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

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

function submitGroupChange(obj)
{
    var group_id = $(obj).data("id");
    alert('group_id:'+group_id);
    $.ajax({
        type:"post",
        url:"/backend/change_group",
        data:{group_id:group_id},
        success: function(res) {
            alert(JSON.stringify(res));
            if(res.code == 0) {
                if(res.data.url != '') {
                    goTo(res.data.url);
                }
            }
        }
    });
    return false;
}