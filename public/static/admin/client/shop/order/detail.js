layui.use(['form','layer','element','table'],function () {
    var form = layui.form,
        layer = layui.layer,
        element = layui.element,
        table = layui.table,
        $ = layui.jquery;

    $(".delivery").on('click',function () {
        var post = {};
        post['order_id'] = $('input[name="order_id"]').val();
        post['company'] = $("select[name='company']").find("option:selected").val();
        post['odd_number'] = $("input[name='odd_number']").val();
        $.post(
            "delivery.html",post,function (res) {
                console.log(res)
                if(res.state=='success'){
                    layer.msg('操作成功', {icon:1});
                    setTimeout(function(){location.reload();},3000);
                }else{
                    layer.msg(res.msg,{icon:2});
                }
            }
        )
    });

    /*form.on('submit(submit)',function (data) {
        $.post('delivery.html',data.field,function (res) {
            if(res.state=='success'){
                layer.msg('操作成功', {icon:1});
                setTimeout(function(){location.reload();},3000);
            }else{
                layer.msg(res.msg,{icon:2});
            }
        })
        return false;
    });*/

});