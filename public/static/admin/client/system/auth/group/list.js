/**
 * Created by shengwang.yang on 2019/1/16 0016.
 */
layui.use(['form','element','table','layer'],function () {
    var table = layui.table,
        $ = layui.jquery,
        form = layui.form,
        layer = layui.layer;

    $(document).ready(function () {
        getList();
    });

    $('.add-btn').on('click',function () {
        var title = '添加用户组',
            url = 'edit.html';
        edit(url,title);
    });
    form.on('switch(status)', function(data){
        var obj = data.elem,
            id = $(obj).data('id'),
            status = data.elem.checked?1:0;
        updateField({id:id,status:status});
    });

    table.on('edit(list)', function(obj){
        var data = obj.data,
            param = {};
        param['id'] = data.id;
        param[obj.field] = obj.value;
        updateField(param);
    });
    table.on('tool(list)', function(obj){
        var layEvent = obj.event,data = obj.data;
        switch (layEvent){
            case 'edit':
                var url = 'edit.html?id='+data.id,
                    title = '编辑用户组';
                edit(url,title);
                break;
            case 'del':
                layer.confirm('确定删除吗？',{icon:3,title:'提示信息'},function () {
                    $.post('delete.html',{id:data.id},function (res) {
                        if(res.state=='success'){
                            var index = layer.msg('操作成功',{icon:1,time:0});
                            setTimeout(function () {
                                layer.close(index);
                                getList();
                            },500)

                        }else{
                            layer.msg(res.msg);
                        }
                    })
                });
                break;
        }
    });
    
    function edit(url,title) {
        var index = layer.open({
            title:[title,'background-color:#009688;color:#fff;font-size:16px;'],
            type:2,
            content:url,
            end: function () {
                $(window).unbind("resize");
                $('html').css('overflow','auto');
                getList();
            }
        });
        layer.full(index);
        $(window).on("resize",function(){
            layer.full(index);
        })

    }
    function updateField(param) {
        $.post('updateField.html',param,function (res) {
            if(res['state']==='error'){
                layer.msg("操作失败！",{icon: 2});
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
                {type: "checkbox", fixed:"left", width:50},
                {field: 'id', title: 'ID', width:60, align:"center",sort:true},
                {field: 'title', title: '名称',align:"left",edit:'text'},
                {field: 'status',title:'状态',align:'center',width:100,templet:'#status'},
                {title: '操作', width:120, templet:'#listBar',fixed:"right",align:"center"}
            ]],
            done: function(res, curr, count){
                layer.close(index);
            }
        });
    }
});