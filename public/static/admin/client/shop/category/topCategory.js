layui.use(['form','layer','table','jquery'],function(){
    var form = layui.form,
        layer = layui.layer,
        $ = layui.jquery,
        table = layui.table;

    var categoryId = getUrlParam('id');

    $(document).ready(function () {
        if(categoryId){
            $.get('/admin/category/getOneCategory.html',{id:categoryId},function (data) {
                console.log(data)
                form.val('top_category',{
                    'name':data.name,
                    'rank':data.rank
                });
                form.render();
            })
        }
    })
    form.on('submit(submit)',function (data) {
        var post = data.field;
        if(categoryId){
            post['id'] = categoryId;
        }else{
            post['pid'] = 0;
        }
        $.post('saveData.html',post,function (res) {
            if(res.state=='success'){
                layer.msg('操作成功',{
                    end:function () {
                        parent.layer.closeAll();
                        parent.location.reload();
                    }
                })

            }else{
                layer.msg(res.msg,{
                    end:function () {
                        parent.layer.closeAll();
                    }
                });
            }
        });
        return false;
    })
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
})