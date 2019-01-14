/**
 * Created by shengwang.yang on 2018/10/23 0023.
 */
layui.config(
    {
        base:'/static/admin/js/'
    }
).use(['form','layer','element','table','laytpl','product','category','images'],function () {
    var form = layui.form,
        layer = layui.layer,
        $ = layui.jquery,
        element = layui.element,
        product = layui.product,
        category = layui.category,
        images = layui.images,
        table = layui.table;

    var advert_id = 4;

    $(document).ready(function () {
        getList();
        category.select_option(0,'#category');
    });

    $('.thumbBox').on('click',function () {
        var _this = $(this);
        images.select(function(data) {
            _this.find('img').attr('src',data);
            _this.find('input').val(data);
        });
    });
    element.on('tab(advert)', function(data){

        switch (data.index){
            case 0:
                advert_id = 4;
                break;
            case 1:
                advert_id = 2;
                break;
            case 2:
                advert_id = 3;
                break;
        }
        getList();
    });
    form.on('select(link-type)', function(data){
        var optionValue = data.value;
        $(this).parents('.layui-form-item').next().addClass('layui-hide');
        switch (optionValue){
            case '1':
                $(this).parents('.layui-form-item').next().removeClass('layui-hide');
                break;
            case '2':
                var _this = $(this);
                product.select('radio','',function (res) {
                    var data = res[0];
                    var product_id = data['id'];
                    var text = '商品：'+data['name'];
                    var link = 'pages/shop/product/product?id='+product_id;
                    _this.parents('.layui-form-item').siblings('.link-url').find('input[type="text"]').val(text);
                    _this.parents('.layui-form-item').siblings('.link-url').find('input[type="hidden"]').val(link);
                    layer.closeAll();
                });
                break;
        }
    });
    form.on('select(category)', function(data){
        var obj = data.elem;
        var text = '分类：'+obj.options[obj.options.selectedIndex]['innerText'];
        var bannerLink = 'pages/shop/product/list?id='+data.value;
        $(this).parents('.layui-form-item').next().find('input[type="text"]').val(text);
        $(this).parents('.layui-form-item').next().find('input[type="hidden"]').val(bannerLink);
    });
    form.on('submit(submit)',function (data) {
        var post = data.field;
        post['advert_id'] = advert_id;
        $.post('saveData.html',post,function (res) {
            if(res.state == 'success'){
                layer.msg('操作成功',{icon:1});
                getList();
            }else{
                layer.msg(res.msg,{icon:2})
            }
        });
        return false;
    });
    table.on('tool(list)',function (obj) {
        var data = obj.data;
        if(obj.event == 'edit'){
            var index = layer.open({
                title:['广告编辑','background-color:#009688;color:#fff;font-size:16px;'],
                type:2,
                content:'edit.html?id='+data.id,
                end:function (layero,index) {
                    $(window).unbind("resize");
                    getList();
                }
            })
            layer.full(index);
            $(window).on('resize',function () {
                layer.full(index)
            })
        }else if(obj.event == 'del'){
            layer.confirm('确定删除吗？',{icon:3,title:'提示信息'},function (index) {
                $.post('delete.html',{id:data.id},function (res) {
                    layer.close(index);
                    if(res.state=='success'){
                        layer.msg('操作成功',{icon:1});
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
            where:{advert_id:advert_id},
            cellMinWidth : 95,
            id:'dataList',
            cols : [[
                {type: "checkbox", fixed:"left", width:50},
                {field: 'id', title: 'ID', width:60, align:"center",sort:true},
                {field: 'img_url', title: '广告图片',width:200,templet:'#img'},
                {field: 'link_type',title: '链接页面'},
                {field: 'link',title: '链接地址'},
                {title: '操作', width:120, templet:'#listBar',fixed:"right",align:"center"}
            ]],
            done: function(res, curr, count){
                layer.close(index);
            }
        });
    }

})