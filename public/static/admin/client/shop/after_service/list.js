/**
 * Created by shengwang.yang on 2018/10/23 0023.
 */
layui.use(['form','layer','element','laydate','table','laytpl'],function () {
    var form = layui.form,
        layer = layui.layer,
        $ = layui.jquery,
        laydate = layui.laydate,
        element = layui.element,
        table = layui.table;

    var condition = {};

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

    form.on('submit(sreach)',function (data) {
        var post = data.field;
        condition['is_search'] = 'yes';
        condition['begin_time'] = post['begin_time'];
        condition['end_time'] = post['end_time'];
        condition['order_no'] = post['order_no'];
        getList();
    });
    element.on('tab(after_service)', function(data){
        $.each(condition,function (index,item) {
            delete condition[index];
        });
        switch (data.index){
            case 1:
                condition['status'] = 0;
                break;
            case 2:
                condition['status'] = 1;
                break;
            case 3:
                condition['status'] = 2;
                break;
            case 4:
                condition['status'] = 3;
                break;
            case 5:
                condition['status'] = 4;
                break;
            case 6:
                condition['status'] = -1;
                break;
            case 7:
                condition['status'] = -2;
                break;
        }
        getList();
    });
    table.on('tool(list)',function (obj) {
        var data = obj.data;
        switch (obj.event){
            case 'edit':
                $.post('isExist.html',{id:data.id},function (res) {
                    if(res.state=='error'){
                        layer.msg(res.msg,{icon:2});
                    }else{
                        var index = layer.open({
                            title : ['退货退款详情','background-color:#009688;color:#fff;font-size:16px;'],
                            type : 2,
                            content : "detail.html?id="+data.id,
                            success : function(layero, index){

                            },end: function (layero, index) {
                                $(window).unbind("resize");
                                getList();
                                $('html').css('overflow','auto');
                            }
                        });
                        layer.full(index);
                        $(window).on("resize",function(){
                            layer.full(index);
                        })
                    }
                });
                break;
            case 'del':
                $.post('delete.html',{id:data.id},function (res) {
                    if(res.state=='success'){
                        layer.msg('操作成功',{icon:1});
                    }else{
                        layer.msg(res.msg,{icon:2});
                    }
                });
                break;
            case 'order':
                var index = layer.open({
                    title : ['订单详情','background-color:#009688;color:#fff;font-size:16px;'],
                    type : 2,
                    content : "/admin/order/detail.html?id="+data.order_id,
                    end: function (layero, index) {
                        $(window).unbind("resize");
                        $('html').css('overflow','auto');
                    }
                });
                layer.full(index);
                $(window).on("resize",function(){
                    layer.full(index);
                })
                break;
        }
    });
    function getList() {
        var index = layer.msg('数据加载中......',{icon:16,time:0});
        table.render({
            elem: '#list',
            url: 'getList.html',
            where:condition,
            cellMinWidth : 95,
            page: true,
            limit:10,
            id:'dataList',
            cols : [[
                {type: "checkbox", fixed:"left", width:50},
                {field: 'id', title: 'ID', width:60, align:"center",sort:true},
                {field: 'order_no', title: '订单编号',minWidth:160,align:"center",event:'order'},
                {field: 'user', title: '申请用户',minWidth:120,templet:"#user"},
                {field: 'refund_money', title: '申请金额',align:"center"},
                {field: 'status', title: '售后状态',align:"center",templet:"#status"},
                {field: 'create_time', title: '申请时间', align:'center',minWidth:160,sort:true},
                {title: '操作', width:120, templet:'#listBar',fixed:"right",align:"center"}
            ]],
            done: function(res, curr, count){
                layer.close(index);
            }
        });
    }

})