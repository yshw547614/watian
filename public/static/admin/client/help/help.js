/**
 * Created by shengwang.yang on 2018/10/23 0023.
 */
layui.use(['form','layer','element','table','laytpl','layedit'],function () {
    var form = layui.form,
        layer = layui.layer,
        $ = layui.jquery,
        element = layui.element,
        layedit = layui.layedit,
        table = layui.table;

    var id = getUrlParam('id');
    var content = '';

    $(document).ready(function () {
        if(id){
            $.get('getData.html',{id:id},function (data) {
                var recommend = data.recommend == 1 ? true : false;
                form.val('article',{
                    'title':data.title,
                    'recommend':recommend
                });
                getCategory(data.type_id);
                $('#content').text(data.content);
                content = layedit.build('content');
            });

        }else{
            getCategory();
        }
    });

    layedit.set({
        uploadImage: {
            url: '/admin/config/upload.html',
            type: 'post'
        }
    });

    content = layedit.build('content');

    form.on('submit(submit)', function(data){
        var post = data.field;
        if(id){
            post['id'] = id;
        }
        post['content'] = layedit.getContent(content);
        $.post('saveData.html',post,function (res) {
            if(res.state=='success'){
                layer.msg('操作成功',{icon:1})
            }else{
                layer.msg(res.msg,{icon:2})
            }
        });
        return false;
    });

    function getCategory(currentId) {
        $.get('getCategory.html',function (data) {
            var html = '';
            for(var i=0;i<data.length;i++){
                if(data[i]['id'] == currentId){
                    html += '<option value="'+data[i]['id']+'" selected>'+data[i]['title']+'</option>';
                }else{
                    html += '<option value="'+data[i]['id']+'">'+data[i]['title']+'</option>';
                }
            }

            $('select[name="type_id"]').append(html);
            form.render();
        })
    }

    function getUrlParam(paramName)
    {
        var query = window.location.search.substring(1);
        var vars = query.split("&");
        for (var i=0;i<vars.length;i++) {
            var pair = vars[i].split("=");
            if(pair[0] == paramName){return pair[1];}
        }
        return(false);
    }
});