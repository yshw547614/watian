/**
 * Created by shengwang.yang on 2018/12/14 0014.
 */
layui.use(['table','element','laypage','form'],function () {
    var form = layui.form,
        layer = layui.layer,
        $ = layui.jquery,
        element = layui.element,
        table = layui.table;

    $(document).ready(function () {
       getList();
    });

    $('.add_template').on('click',function () {
        var title = '添加模板',
            url = 'template.html';
        editTemplate(title,url);
    });
    table.on('tool(list)',function (obj) {

        var data = obj.data;
        if(obj.event=='edit'){
            var title = '编辑模板',
                url = 'template.html?id='+data.id;
            editTemplate(title,url);
        }else if(obj.event == 'del'){
            $.post('delete.html',{id:data.id},function (res) {
                if(res.state=='success'){
                    layer.msg('操作成功',{icon:1});
                    getList();
                }else{
                    layer.msg(res.msg,{icon:2});
                }
            })
        }
    });
    function editTemplate(title,url) {
        var index = layer.open({
            title:[title,'background-color:#009688;color:#fff;font-size:16px;'],
            type:2,
            content:url,
            end:function (layero,index) {
                $(window).unbind('resize');
                location.reload();
            }

        });
        layer.full(index);
        $(window).on('resize',function () {
            layer.full(index);
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
                {field: 'name', title: '模板名称',minWidth:160,align:"center"},
                {field: 'item_str', title: '售后服务项',minWidth:120,templet:"#user"},
                {title: '操作', width:120, templet:'#listBar',fixed:"right",align:"center"}
            ]],
            done: function(res, curr, count){
                layer.close(index);
            }
        });
    }
});