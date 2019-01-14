/**
 * Created by shengwang.yang on 2018/10/23 0023.
 */
layui.use(['form','layer','element','laydate','table','laytpl'],function () {
    var form = layui.form,
        layer = layui.layer,
        $ = layui.jquery,
        element = layui.element,
        table = layui.table;

    var index = layer.msg('数据加载中......',{icon:16,time:0});

    $(document).ready(function () {
        $.get('getData.html',function (data) {
            form.val('return_address',{
                'name':data.name,
                'mobile':data.mobile,
                'address':data.address,
                'zipcode':data.zipcode
            });
            form.render();
            layer.close(index);
        })
    });

    form.on('submit(submit)',function (data) {
        var post = data.field;
        $.post('saveData.html',post,function (res) {
            if(res.state=='success'){
                layer.msg('操作成功',{icon:1});
            }else{
                layer.msg(res.msg,{icon:2});
            }
        });
        return false;
    })

});