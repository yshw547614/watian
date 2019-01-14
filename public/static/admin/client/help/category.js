/**
 * Created by shengwang.yang on 2018/10/23 0023.
 */
layui.use(['form','layer','element','table','laytpl'],function () {
    var form = layui.form,
        layer = layui.layer,
        $ = layui.jquery,
        element = layui.element,
        table = layui.table;

    $(document).ready(function () {
        getList();
    });
    form.on('submit(submit)',function (data) {
        var post = data.field;
        $.post('saveAdd.html',post,function (res) {
            if(res.state=='success'){
                var index = layer.msg('操作成功',{icon:1});
                setTimeout(function () {
                    layer.close(index);
                    getList();
                },500);
            }else{
                layer.msg(res.msg,{icon:2})
            }
        });
        return false;
    });

    table.on('edit(list)', function(obj){
        var data = obj.data,
            param = {};
        param['id'] = data.id;
        param[obj.field] = obj.value;
        updateField(param);
    });
    table.on('tool(list)', function(obj){
        var data = obj.data;
        if(obj.event=='del'){
            layer.confirm('确定删除吗？',{icon:3,title:'提示信息'},function () {
                $.post('delete.html',{id:data.id},function (res) {
                    if(res.state=='success'){
                        layer.msg('操作成功',{icon:1});
                        getList();
                    }else{
                        layer.msg(res.msg,{icon:2})
                    }
                })
            });

        }
    });

    function updateField(param) {
        $.post('updateField.html',param,function (res) {
            if(res.state=='success'){
                layer.msg('操作成功',{icon:1});
            }else{
                layer.msg(res.msg)
            }
        })
    }
    function getList() {
        var index = layer.msg('数据加载中......',{icon:16,time:0});
        table.render({
            elem: '#list',
            url: 'getList.html',
            cellMinWidth : 95,
            page: true,
            limit:10,
            id:'dataList',
            cols : [[
                {field: 'id', title: 'ID', width:80, align:"center",sort:true},
                {field: 'title', title: '分类名称', minWidth:200,edit:'text'},
                {title: '操作', width:80, templet:'#listBar',fixed:"right",align:"center"}
            ]],
            done: function(res, curr, count){
                layer.close(index);
            }
        });
    }


})