layui.use(['form','layer','table','jquery'],function(){
    var form = layui.form,
        layer = layui.layer,
        $ = layui.jquery,
        table = layui.table;

    form.on('submit(submit)',function (data) {
        var post = data.field;
        $.post('saveAdd.html',post,function (res) {
            if(res.state=='success'){
                var index = layer.msg('操作成功');
                setTimeout(function () {
                    parent.layer.closeAll();
                    parent.location.reload();
                },500)
            }else{
                layer.msg(res.msg);
            }
        })
    })

})