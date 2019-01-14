/**
 * Created by shengwang.yang on 2018/10/23 0023.
 */
layui.use(['form','layer','element','table','laytpl'],function () {
    var form = layui.form,
        layer = layui.layer,
        $ = layui.jquery,
        element = layui.element,
        table = layui.table;

    var index = layer.msg('数据加载中......',{icon:16,time:0});
    
    $(document).ready(function () {
        
    })
    //监听工具条
    form.on('select(express_type)', function(data){
        var elem = data.elem;
        var id = $(elem).data('id');
        updateField({id:id,type:data.value})
    });

    form.on('submit(submit)',function (data) {
        var post = data.field;
        $.post('saveAdd.html',post,function (res) {
            if(res.state=='success'){
                layer.msg('操作成功',{icon:1});
                table.reload('dataList');
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
                        table.reload('dataList');
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
    table.render({
        elem: '#list',
        url: 'getList.html',
        cellMinWidth : 95,
        page: true,
        limit:10,
        id:'dataList',
        cols : [[
            {field: 'id', title: 'ID', width:80, align:"center",sort:true},
            {field: 'title', title: '公司名称', minWidth:200,edit:'text'},
            {field: 'code', title: '快递编码',edit:'text'},
            {field: 'type', title: '接口类型',  align:'center',width:200,templet:'#type'},
            {title: '操作', width:80, templet:'#listBar',fixed:"right",align:"center"}
        ]],
        done: function(res, curr, count){
            layer.close(index);
            var tableElem = this.elem.next('.layui-table-view');
            layui.each(tableElem.find('tbody select'),function (index,item) {
                var elem = $(item);
                elem.parents('div.layui-table-cell').css('overflow','visible');
            });


        }
    });

})