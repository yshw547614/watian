/**
 * Created by shengwang.yang on 2018/10/23 0023.
 */
layui.config(
    {
        base:'/static/admin/js/'
    }
).use(['form','layer','element','laydate','table','laytpl','help'],function () {
    var form = layui.form,
        layer = layui.layer,
        $ = layui.jquery,
        element = layui.element,
        help = layui.help,
        table = layui.table;

    var index = layer.msg('数据加载中......',{icon:16,time:0});

    $('input[name="link"]').on('click',function () {
        var _this = $(this);
        help.select(function (link) {
            _this.val(link)
        })
    });
    form.on('submit(submit)',function (data) {
        var post = data.field;
        $.post('saveAdd.html',post,function (res) {
            if(res.state=='success'){
                layer.msg('操作成功',{icon:1});
                table.reload('dataList');
            }else{
                layer.msg('操作失败',{icon:2})
            }
        });
        return false;
    })
    table.on('tool(list)', function(obj){
        var data = obj.data;
        if(obj.event === 'jump'){
            help.select(function (res) {
                updateField({id:data.id,link:res});
                obj.update({
                    link: res
                });
            })

        }else if(obj.event === 'del'){
            $.post('delete.html',{id:data.id},function (res) {
                if(res.state=='success'){
                    layer.msg('操作成功',{icon:1});
                    table.reload('dataList');
                }else{
                    layer.msg(res.msg,{icon:2})
                }
            })
        }
    });
    //监听单元格编辑
    table.on('edit(list)', function(obj){
        var data = obj.data;
        var post = {};
        post['id'] = data.id;
        post[obj.field] = obj.value;
        updateField(post)

    });
    table.render({
        elem: '#list',
        url: 'getList.html',
        cellMinWidth : 95,
        page: true,
        limit:10,
        id:'dataList',
        cols : [[
            {type: "checkbox", fixed:"left", width:50},
            {field: 'id', title: 'ID', width:60, align:"center",sort:true},
            {field: 'name', title: '服务项名称',minWidth:160,edit:'text'},
            {field: 'link', title: '跳转地址',minWidth:120,event:'jump'},
            {title: '操作', width:120, templet:'#listBar',fixed:"right",align:"center"}
        ]],
        done: function(res, curr, count){
            layer.close(index);
        }
    });
    function updateField(post) {
        var index = layer.msg('数据修改中...',{icon:16});
        $.post('updateField.html',post,function (res) {
            if(res.state=='success'){
                layer.msg('修改成功');
            }else{
                layer.msg(res.msg);
            }
        })
    }

})