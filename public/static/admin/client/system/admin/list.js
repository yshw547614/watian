/**
 * Created by shengwang.yang on 2019/1/17 0017.
 */
layui.use(['form','table','layer'],function () {
    var form = layui.form,
        layer = layui.layer,
        $ = layui.jquery,
        table = layui.table;

    $(document).ready(function () {
       getList();
    });
    $('.add-btn').on('click',function () {
        var title = '添加管理员',
            url = 'edit.html';
        edit(title,url);
    });
    table.on('tool(list)',function (obj) {
        var data = obj.data;
        if(obj.event=='del'){
            layer.confirm('确定删除吗？',{icon:3,title:'提示信息'},function () {
                $.post('delete.html',{id:data.id},function (res) {
                    if(res.state=='success'){
                        var index = layer.msg('操作成功,数据重载...',{icon:16});
                        setTimeout(function () {
                            layer.close(index);
                            getList();
                        },600);
                    }else{
                        layer.msg(res.msg,{icon:2})
                    }
                })
            });
        }
        if(obj.event=='edit'){
            var title = '编辑管理员信息',
                url = 'edit.html?id='+data.id;
            edit(title,url);
        }
    });
    function edit(title,url) {
        var index = layer.open({
            title : title,
            type : 2,
            area: ['300px', '365px'],
            content : url
        });
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
                {type: "checkbox", fixed:"left", width:50},
                {field: 'id', title: 'ID', width:60, align:"center",sort:true},
                {field: 'name', title: '用户名',align:"left"},
                {field: 'group_name', title: '用户组',align:"left"},
                {title: '操作', width:120, templet:'#listBar',fixed:"right",align:"center"}
            ]],
            done: function(res, curr, count){
                layer.close(index);
            }
        })
    }
});