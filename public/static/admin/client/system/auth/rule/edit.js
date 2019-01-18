/**
 * Created by shengwang.yang on 2019/1/16 0016.
 */
layui.use(['form','element','layer'],function () {
    var layer = layui.layer,
        $ = layui.jquery,
        form = layui.form;

    var id = getUrlParam('id'),
        pid = getUrlParam('pid');

    $(document).ready(function () {
        if(id){
            $.get('getOneData.html',{id:id},function (data) {
                form.val('edit_form',{
                    'title':data.title,
                    'name':data.name
                });
                form.render();
            });

        }
    });
    form.on('submit(submit)',function (data) {
        var post = data.field;
        if(id){
            post['id'] = id;
        }
        if(pid){
            post['pid'] = pid;
        }
        $.post('saveData.html',post,function (res) {
            if(res.state=='success'){
                layer.msg('操作成功',{
                    end:function () {
                        parent.layer.closeAll();
                        parent.location.reload();
                    }
                });
            }else{
                layer.msg(res.msg,{
                    end:function () {
                        parent.layer.closeAll();
                    }
                });
            }
        });
        return false;
    });
    

    function getUrlParam(paramName){
        var query = window.location.search.substring(1);
        var vars = query.split("&");
        for (var i=0;i<vars.length;i++) {
            var pair = vars[i].split("=");
            if(pair[0] == paramName){return pair[1];}
        }
        return(false);
    }
});