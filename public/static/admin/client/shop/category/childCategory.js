layui.config(
    {
        base:'/static/admin/js/'
    }
).use(['form','layer','table','jquery','category','images'],function(){
    var form = layui.form,
        layer = parent.layer === undefined ? layui.layer : top.layer,
        $ = layui.jquery,
        category = layui.category,
        images = layui.images,
        table = layui.table;

    var categoryId = getUrlParam('id');
    var parentId  = getUrlParam('parent_id');
    $(document).ready(function () {
        if(parentId){
            setParentCatogery(parentId);
        }else if(categoryId){
            $.get('/admin/category/getOneCategory.html',{id:categoryId},function (data) {
                console.log(data)
                form.val('child_category',{
                    'name':data.name,
                    'rank':data.rank,
                    'topic_img':data.topic_img,

                });
                $('.thumbImg').attr('src',data.topic_img);
                setParentCatogery(data.pid)
            })
        }

    });
    $('.thumbBox').on('click',function () {
        var _this = $(this);
        images.select(function(data) {
            _this.find('img').attr('src',data);
            _this.find('input').val(data);
        });
    });
    form.on('submit(submit)',function (data) {
        var post = data.field;
        if(categoryId){
            post['id'] = categoryId;
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
        })
        return false;
    })
    function setParentCatogery(pid) {
        $.get('/admin/category/getTopCategory.html',function (data) {
            var html = '';
            for(var i=0;i<data.length;i++){
                if(pid == data[i]['id']){
                    html += '<option value="'+data[i]['id']+'" selected>'+data[i]['name']+'</option>'
                }else{
                    html += '<option value="'+data[i]['id']+'">'+data[i]['name']+'</option>'
                }

            }
            $('#pid').append(html);
            form.render()
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
})