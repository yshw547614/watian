/**
 * Created by shengwang.yang on 2018/10/23 0023.
 */
layui.use(['form','layer','element','laydate','table','laytpl'],function () {
    var form = layui.form,
        layer = layui.layer,
        $ = layui.jquery,
        laydate = layui.laydate,
        element = layui.element,
        table = layui.table;

    $(".bigPic").on('click',function () {
        var imgSrc = $(this).attr('src')
        layer.open({
            type: 1,
            title: false,
            closeBtn: 1,
            area: 'auto,auto',
            skin: 'layui-layer-nobg', //没有背景色
            shadeClose: true,
            content: '<div><img src="'+imgSrc+'"></div>'
        })
    });

    $("#through").on('click',function () {
        action('through');
    });

    $("#confirm").on('click',function () {
        action('confirm');
    });

    $("#return").on('click',function () {
        action('refund');
    });

    function action(type) {
        var service_id = $('input[name="service_id"]').val();

        $.post(type+'.html',{service_id:service_id},function (res) {
            if(res.state=='success'){
                layer.msg('操作成功！', {icon:1});
                setTimeout(function(){location.reload();},3000);
            }else{
                layer.msg(res.msg)
            }


        })
    }

})