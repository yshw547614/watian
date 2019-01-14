/**
 * Created by shengwang.yang on 2018/10/23 0023.
 */
layui.use(['form','layer','element','laydate','table','laytpl'],function () {
    var form = layui.form,
        layer = layui.layer,
        $ = layui.jquery,
        element = layui.element,
        laydate = layui.laydate,
        table = layui.table;

    var status = getUrlParam('status'),condition={};

    if(status){
        condition['status'] = status;
        $('.status-box').hide();
    }

    $(document).ready(function () {
       getList();
    });

    laydate.render({
        elem:'#begin_time',
        type:'date'
    });
    laydate.render({
        elem:'#end_time',
        type:'date'
    });
    form.on('submit(search)',function (data) {
        var post = data.field;
        $.each(post,function (index) {
            if(index != 'status'){
                condition[index] = post[index];
            }
        });
        condition['is_search'] = 'yse';
        getList();
    });
    table.on('tool(list)',function (obj) {
        var data = obj.data;
        if(obj.event=='edit'){
            var index = layer.open({
                title : ['订单详情','background-color:#009688;color:#fff;font-size:16px;'],
                type : 2,
                content : "detail.html?id="+data.id,
                end: function (layero, index) {
                    $(window).unbind("resize");
                    getList();
                    $('html').css('overflow','auto');
                }
            });
            layer.full(index);
            $(window).on("resize",function(){
                layer.full(index);
            })
        }else if(obj.event=='del'){
            layer.confirm('确定删除吗？',{icon:6,title:'提示信息'},function (index) {
                $.post('delete.html',{id:data.id},function (res) {
                    layer.close(index);
                    if(res.state=='success'){
                        layer.msg('删除成功',{icon:1});
                        getList();
                    }else{
                        layer.msg(res.msg,{icon:2})
                    }
                })
            })

        }
    });
    function getList() {
        var index = layer.msg('数据加载中......',{icon:16,time:0});
        table.render({
            elem: '#list',
            url: 'getList.html',
            cellMinWidth : 95,
            where:condition,
            page: true,
            limit:10,
            id:'dataList',
            cols : [[
                {type: "checkbox", fixed:"left", width:50},
                {field: 'id', title: 'ID', width:60, align:"center",sort:true},
                {field: 'order_no', title: '订单编号',width:160,align:"center"},
                {field: 'user', title: '用户信息',minWidth:120,templet:"#user"},
                {field: 'product_price', title: '商品总价',align:"center",sort:true},
                {field: 'shipping_price', title: '运费金额', align:'center',sort:true},
                {field: 'total_price', title: '订单总价',  align:'center',sort:true},
                {field: 'order_price', title: '实付金额',align:'center',sort:true},
                {field: 'status', title: '订单状态', align:'center',templet:"#status"},
                {field: 'create_time', title: '下单时间', align:'center',width:160,sort:true},
                {title: '操作', width:120, templet:'#listBar',fixed:"right",align:"center"}
            ]],
            done: function(res, curr, count){
                layer.close(index);
            }
        });
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