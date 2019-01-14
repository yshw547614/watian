/**
 * Created by shengwang.yang on 2018/10/23 0023.
 */
layui.use(['form','layer','element','table','laytpl'],function () {
    var form = layui.form,
        layer = layui.layer,
        $ = layui.jquery,
        element = layui.element,
        table = layui.table;

    var condition = {};

    $(document).ready(function () {
        category();
        getList();
    });
    $('.addHelp').on('click',function () {
        var title = '添加帮助文档',
            url = 'help.html';
        editHelp(title,url);
    });
    form.on('submit(sreach)', function(data){
        condition = data.field;
        getList();
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
        switch (obj.event) {
            case 'del':
                layer.confirm('确定删除吗？', {icon: 3, title: '提示信息'}, function () {
                    $.post('delete.html', {id:data.id}, function (res) {
                         if (res.state == 'success') {
                             var index = layer.msg('操作成功', {icon: 1});
                             setTimeout(function () {
                                 layer.close(index);
                                 getList();
                             },1000)
                        } else {
                            layer.msg(res.msg, {icon: 2})
                        }
                    })
                });
                break;
            case 'edit':
                var title = '编辑帮助文档',
                    url = 'help.html?id='+data.id;
                editHelp(title,url);
                break;
        }
    });

    function editHelp(title,url) {
        var index = layer.open({
            title : [title,'background-color:#009688;color:#fff;font-size:16px;'],
            type : 2,
            resize:true,
            content : url,
            success : function(layero, index){

            },end: function (layero, index) {

                $(window).unbind("resize");
                location.reload();
            }
        });
        layer.full(index);
        $(window).on("resize",function(){
            layer.full(index);
        })
    }
    function category() {
        $.get('/admin/help/getCategory.html',function (data) {
            var count = data.length;
            var options = '';
            for(var i=0;i<count;i++){
                options += '<option value="'+data[i]['id']+'">'+data[i]['title']+'</option>';
            }
            $(".select_category").append(options);
            form.render();
        })
    }

    function updateField(param) {
        $.post('updateField.html',param,function (res) {
            if(res.state=='success'){
                layer.msg('操作成功',{icon:1});
            }else{
                layer.msg(res.msg)
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
            where:condition,
            limit:10,
            id:'dataList',
            cols : [[
                {field: 'id', title: 'ID', width:80, align:"center",sort:true},
                {field: 'title', title: '标题', minWidth:200,edit:'text'},
                {field: 'clicks', title: '浏览量',width:120,sort:true},
                {title: '操作', width:120, templet:'#listBar',fixed:"right",align:"center"}
            ]],
            done: function(res, curr, count){
                layer.close(index);
            }
        });
    }


})