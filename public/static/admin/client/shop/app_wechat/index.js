/**
 * Created by shengwang.yang on 2018/10/23 0023.
 */
layui.config(
    {
        base:'/static/admin/js/'
    }
).use(['form','layer','element','layedit'],function () {
    var form = layui.form,
        layer = layui.layer,
        $ = layui.jquery,
        layedit = layui.layedit,
        element = layui.element;

    layedit.set({
        uploadImage: {
            url: 'upload.html',
            type: 'post'
        }
    });

    var app = layedit.build('app');
    var wechat = layedit.build('wechat');

    $.get('getData.html',function (data) {
        $('#app').text(data.appHtml)
        $('#wechat').text(data.wechatHtml)
        app = layedit.build('app');
        wechat = layedit.build('wechat');
    });

    $('.submit').on('click',function (res) {
        var appHtml = layedit.getContent(app),
            wechatHtml = layedit.getContent(wechat);
        var post = {};
        post['appHtml'] = appHtml;
        post['wechatHtml'] = wechatHtml;
        $.post('saveData.html',post,function (res) {
            if(res.state == 'success'){
                layer.msg('操作成功',{icon:1});
                form.render();
            }else{
                layer.msg(res.msg,{icon:2})
            }
        });
        return false;
    });
});