/**
 * Created by shengwang.yang on 2019/1/17 0017.
 */
layui.use(['form','table','layer'],function () {
    var form = layui.form,
        layer = layui.layer,
        $ = layui.jquery,
        table = layui.table;

    var id = getUrlParam('id');

    $(document).ready(function () {
        if(id){
            $.get('getOneData.html',{id:id},function (data) {
                form.val('form',{
                    'name':data.name
                });
                setGroup(data.group_id)
            });
        }else{
            setGroup();
        }

    });

    form.verify({
        password: function (value,item) {
            var rule = /^[\S]{6,12}$/;
            if(!id){
                if(!rule.test(value)){
                    return '密码必须6到12位，且不能出现空格';
                }
            }
      }
    });

    form.on('submit(submit)',function (data) {
        var post = data.field;
        if(id){
            post['id'] = id;
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

    function setGroup(group_id) {
        $.get('getGroup.html',function (data) {
            var html = '';
            for(var i=0;i<data.length;i++){
                if(data[i]['id'] == group_id){
                    html += '<option value="'+data[i]['id']+'" selected>'+data[i]['title']+'</option>';
                }else{
                    html += '<option value="'+data[i]['id']+'">'+data[i]['title']+'</option>';
                }

            }
            $('select[name="group_id"]').append(html);
            form.render();
        })
    }

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