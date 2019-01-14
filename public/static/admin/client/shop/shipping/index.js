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

    $('body').on('click','.invalid',function () {
        var _this = $(this),id = $(this).data('id');
        $.post('updateField.html',{id:id,status:-1},function (res) {
            if(res['state']==='success'){
                layer.msg("操作成功！",{icon: 1});
                _this.parent().empty().append('<span style="color:#e2e2e2">已失效</span>');
            }else{
                layer.msg("操作失败！",{icon: 2});
            }
        });
    });
    $('.add-rule').on('click',function () {
        var title = '添加包邮规则',
            url = 'shipping.html';
        editRule(title,url)
    });
    form.on('select(status)', function(data){
        var elem = data.elem;
        var id = $(elem).data('id');
        $.post('updateStatus.html',{id:id,status:data.value},function (res) {
            if(res['state']==='success'){
                layer.msg("操作成功！",{icon: 1});
            }else{
                layer.msg(res.msg,{icon: 2});
            }
        });
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
                var title = '编辑包邮规则',
                    url = 'shipping.html?id='+obj.data.id;
                editRule(title,url);
                break;
        }
    });
    //添加、编辑规则
    function editRule(title,url){
        var index = layer.open({
            title : [title,'background-color:#009688;color:#fff;font-size:16px;'],
            type : 2,
            content : url,
            success : function(layero, index){

            },end: function () {
                $(window).unbind("resize");
                $('html').css('overflow','auto')
            }
        })
        layer.full(index);
        $(window).on("resize",function(){
            layer.full(index);
        })
    }
    function updateField(data){
        $.post('updateField.html',data,function (res) {

            if(res['state']==='success'){
                layer.msg("操作成功！",{icon: 1});
            }else{
                layer.msg("操作失败！",{icon: 2});
            }
        })
    }
    table.render({
        elem: '#list',
        url: '/admin/shipping/getList.html',
        page: true,
        limit:10,
        cellMinWidth : 95,
        cols : [[
            {type: "checkbox", fixed:"left", width:50},
            {field: 'id', title: 'ID', width:60, align:"center",sort:true},
            {field: 'title', title: '规则名称',minWidth:160,align:"center",edit:true},
            {field: 'valid_time', title: '有效时间',minWidth:120,templet:"#valid_time",align:"center"},
            {field: 'status', title: '规则状态',align:"center",templet:"#status"},
            {title: '操作', width:100, templet:'#listBar',fixed:"right",align:"center"}
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