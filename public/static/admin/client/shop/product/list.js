layui.config({
    base : "/static/admin/js/"
}).use(['table','form','layer','jquery','laypage','category','images','element'],function(){
    var form = layui.form,
        layer = layui.layer,
        table = layui.table,
        $ = layui.jquery,
        images = layui.images,
        element = layui.element,
        category = layui.category;

    var condition = {};
        condition['is_on_sale'] = 1;
        condition['stock'] = 'yes';
    var active = {
        upperShelf: function () {
            var productIds = selectProduct();
            batchUpdate({productIds:productIds,is_on_sale:1},true)
        },
        lowerShelf: function () {
            var productIds = selectProduct();
            batchUpdate({productIds:productIds,is_on_sale:-1},true)
        },
        freeShipping: function () {
            var productIds = selectProduct();
            batchUpdate({productIds:productIds,is_free_shipping:1})
        },
        recommend: function () {
            var productIds = selectProduct();
            batchUpdate({productIds:productIds,is_vouch:1})
        },
        addFreightTemplate: function () {
            var productIds = selectProduct();
            if(productIds){
                var templateId;
                layer.open({
                    title : "请选择运费模板",
                    type : 2,
                    area : ["336px","300px"],
                    content : 'freightTempView.html',
                    btn:['确定', '取消'],
                    btn1: function(index, layero){
                        var body = layer.getChildFrame('body', index);
                        templateId = body.find("select[name='template']").val();
                        batchUpdate({productIds:productIds,template_id:templateId,is_free_shipping:0});
                        layer.close(index)
                    }
                });
            }
        },
        addAfterServiceTemplate: function () {
            var productIds = selectProduct();
            if(productIds){
                var templateId;
                layer.open({
                    title : "请选售后服务模板",
                    type : 2,
                    area : ["336px","300px"],
                    content : 'afterServiceTempView.html',
                    btn:['确定', '取消'],
                    btn1: function(index, layero){
                        var body = layer.getChildFrame('body', index);
                        templateId = body.find("select[name='template']").val();
                        batchUpdate({productIds:productIds,service_template_id:templateId});
                        layer.close(index)
                    }
                });
            }
        }
    };
    $(document).ready(function () {
        category.select_option(0,'.select_category');
        products();
    });
    $('.batchUpdate .layui-btn').on('click', function(){
        var type = $(this).data('type');
        active[type] ? active[type].call(this) : '';
    });
    form.on('submit(sreach)', function(data){
        var post = data.field;
        condition['is_search'] = 'yes';
        condition['product_name'] = post['product_name'];
        condition['category'] = post['category'];
        condition['nation'] = post['nation'];
        condition['is_free_shipping'] = post['is_free_shipping'];
        products();
        return false;
    });
    element.on('tab(after_service)', function(data){
        $.each(condition,function (index,item) {
            delete condition[index];
        });
        switch (data.index){
            case 0:
                condition['is_on_sale'] = 1;
                condition['stock'] = 'yes';
                break;
            case 1:
                condition['is_on_sale'] = 1;
                condition['stock'] = 'no';
                break;
            case 2:
                condition['is_on_sale'] = -1;
                break;
            case 3:
                condition['is_on_sale'] = 0;
                break;
        }
        products();
    });
    form.on('switch(nation)', function(data){
        var obj = data.elem,
            product_id = $(obj).data('id'),
            nation = data.elem.checked?1:0;
        updateField({id:product_id,nation:nation});
    });
    form.on('switch(is_on_sale)', function(data){
        var obj = data.elem,
            product_id = $(obj).data('id'),
            is_on_sale = data.elem.checked?1:-1;
        updateField({id:product_id,is_on_sale:is_on_sale});
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
            case 'setNaem':
                layer.prompt({
                    formType: 2
                    ,title: '修改ID为'+ data.id +'的商品名称'
                    ,value: data.name
                }, function(value, index){
                    layer.close(index);
                    updateField({id:data.id,name:value})
                    obj.update({
                        name: value
                    });
                });
                break;
            case 'change_thumb':
                images.select(function(src) {
                    updateField({id:data.id,thumb_img:src})
                    obj.update({
                        thumb_img: src
                    });
                });
                break;
            case 'edit':
                editProduct(data);
                break;
            case 'del':
                layer.confirm('确定删除吗？',{icon:3,title:'提示信息'},function () {
                    $.post('delete.html',{id:data.id},function (res) {
                        if(res.state=='success'){
                            layer.msg('操作成功');
                            table.reload('productList');
                        }else{
                            layer.msg(res.msg);
                        }
                    })
                })

                break;
        }
    });
    //添加、编辑商品
    function editProduct(data){
        var index = layer.open({
            title : ['编辑商品','background-color:#009688;color:#fff;font-size:16px;'],
            type : 2,
            resize:true,
            content : "product.html?id="+data.id,
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

    function updateField(data){
        $.post('updateField.html',data,function (res) {
            if(res['state']==='error'){
                layer.msg("操作失败！",{icon: 2});
            }
        })
    }
    function updateResult(res) {
        var index = layer.msg('修改中，请稍候',{icon: 16,time:false});
        setTimeout(function(){
            if(res['state']==='success'){
                layer.msg("数据已更新！",{icon: 1});
            }else{
                layer.msg("操作失败！",{icon: 2});
            }
        },1000)
    }
    function selectProduct() {
        var checkStatus = table.checkStatus('productList'),
            data = checkStatus.data,
            productIds = [];
        if(data.length<1){
            layer.alert('请选择商品',{title:'温馨提示',icon:2});
        }else{
            for(var i=0;i<data.length;i++){
                productIds.push(data[i]['id']);
            }
            return productIds;
        }
    }
    function batchUpdate(data,isReload) {
        $.post('batchUpdate.html',data,function (res) {
            var index = layer.msg('修改中，请稍候',{icon: 16,time:false});
            isReload && table.reload('productList');
            setTimeout(function(){
                if(res['state']==='success'){
                    layer.msg("数据已更新！",{icon: 1});
                }else{
                    layer.msg("操作失败！",{icon: 2});
                }
            },1000)
        })
    }
    function products() {
        var index = layer.msg('数据加载中......',{icon:16,time:0})
        table.render({
            elem: '#list',
            where:condition,
            method:'post',
            cellMinWidth : 85,
            //height: 'full-168',
            url : 'getList.html',
            page : true,
            limit : 10,
            id:'productList',
            cols : [[
                {type: "checkbox", fixed:"left", width:50},
                {field: 'product_sn', title: '编号',align:"center",sort: true},
                {field: 'name', title: '名称',minWidth:300,edit: 'text',event:'setNaem'},
                {field: 'thumb_img', title: '缩略片',align:'center',templet:'#thumb_img'},
                {field: 'original_price', title: '划线价',align:'center',sort:true,edit: 'text'},
                {field: 'price', title: '价格',align:'center',sort:true,edit: 'text'},
                {field: 'stock', title: '库存',align:'center',sort:true,edit: 'text'},
                {field: 'is_on_sale',title:'上架状态',align:'center',width:100,templet:'#is_on_sale'},
                {field: 'nation', title: '商品地域',align:'center',width:100,templet:"#nation"},
                {field: 'weight', title: '重量(g)',align:'center',edit: 'text'},
                {field: 'volume',title:'体积(m³)',align:'center',edit: 'text'},
                {field: 'clicks', title: '浏览量',align:'center',sort:true},
                {field: 'sales_volume',title:'销售量',align:'center',sort:true},
                {title: '操作', width:120, templet:'#listBar',fixed:"right",align:"center"}
            ]],
            done:function (res) {
                console.log(res)
                layer.close(index)
            }
        })
    }


});