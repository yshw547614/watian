/**
 * Created by shengwang.yang on 2018/10/23 0023.
 */
layui.use(['form','layer','element','laydate','table','laytpl'],function () {
    var form = layui.form,
        layer = layui.layer,
        $ = layui.jquery,
        element = layui.element,
        table = layui.table;

    var index = layer.msg('数据加载中......',{icon:16,time:0});

    $('.addHotWord').on('click',function () {
        layer.open({
            title:'添加热门搜索关键词',
            type:2,
            area: ['360px', '205px'],
            content:'add.html'
        })
    });

    table.on('tool(list)',function (obj) {
        var data = obj.data;
        if(obj.event=='del'){
            layer.confirm('确定删除吗？',{icon:3,title:'提示信息'},function () {
               $.post('/admin/keyword/del',{id:data.id},function (res) {
                   if(res.state=='success'){
                       var index = layer.msg('操作成功,数据重载...',{icon:16});
                       setTimeout(function () {
                           table.reload('dataList',{
                               done:function () {
                                   layer.close(index);
                               }
                           },2000);
                       })

                   }else{
                       layer.msg(res.msg,{icon:2})
                   }
               })
            });
        }
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
            {field: 'title', title: '关键词',align:"left",edit:'text'},
            {title: '操作', width:120, templet:'#listBar',fixed:"right",align:"center"}
        ]],
        done: function(res, curr, count){
            layer.close(index);
        }
    });
    function updateIsPass(data,index) {
        $.post('/admin/product_comment/updateIsPass.html',data,function (res) {
            if(index){
                layer.close(index);
            }
            if(res.state === 'success'){
                layer.msg('操作成功,数据重新加载...',{icon:16})
                table.reload('commentList');
            }else{
                layer.msg(res.msg,{icon:2})
            }
        })
    }

})