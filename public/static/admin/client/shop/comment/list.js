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
    $(document).ready(function () {

    });
    $('body').on('click','.bigPic',function () {
        var imgSrc = $(this).attr('src')
        layer.open({
            type: 1,
            title: false,
            area: 'auto,auto',
            skin: 'layui-layer-nobg', //没有背景色
            shadeClose: true,
            content: '<div><img src="'+imgSrc+'"></div>'
        })
    }).on('click','.shenghe',function () {
        var id = $(this).data('id');
        layer.msg('请选择通过或者拒绝', {
            icon: 3,
            time:0,
            closeBtn:1,
            btn: ['通过','拒绝'],
            yes: function(index){
                updateIsPass({id:id,is_pass:1})
            },
            btn2: function(index){
                updateIsPass({id:id,is_pass:-1})
            }
        });
    });
    form.on('switch(changeIsPass)', function(data){
        alert(data.elem.checked)
        var obj = data.elem,
            product_id = $(obj).data('id'),
            is_pass = data.elem.checked?1:-1;
        updateIsPass({id:product_id,is_pass:is_pass});
    });

    element.on('tab(tab_comment)', function(data){
        //执行重载
        var is_pass = 0;
        switch (data.index){
            case 0:
                is_pass = 0;
                break;
            case 1:
                is_pass = -1;
                break;
            case 2:
                is_pass = 1;
                break;
        }
        table.reload('commentList', {
            page: {curr: 1 },
            where: {is_pass:is_pass}
        });

    });
    table.render({
        elem: '#comments',
        url: '/admin/product_comment/getList.html',
        cellMinWidth : 95,
        page: true,
        where:{is_pass:0},
        limit:10,
        id:'commentList',
        cols : [[
            {type: "checkbox", fixed:"left", width:50},
            {field: 'id', title: 'ID', width:60, align:"center"},
            {field: 'product_name', title: '商品名称', minWidth:300},

            {field: 'evaluate', title: '评价等级', align:'center'},
            {field: 'star', title: '满意度',  align:'center',templet:"#star"},
            {field: 'is_pass', title: '审核状态',align:'center',width:120,templet:'#is_pass'},
            {field: 'create_time', title: '发布时间', align:'center', minWidth:160},
            {field: 'content', title: '评价内容', minWidth:250},
            {field: 'images', title: '评价图片', minWidth:200,templet:function (d) {
                var data = d.images;
                var html = '';
                for(var i=0;i<data.length;i++){
                    html += '<img class="bigPic" src="'+data[i]+'" width="40" height="40" style="margin-left: 6px;"/>';
                }
                return html;
            }},
            {title: '操作', width:120, templet:'#commentListBar',fixed:"right",align:"center"}
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