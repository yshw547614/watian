layui.config(
    {
        base : "/static/admin/js/"
    }
).use(['form','layer','element','table','help','product'],function () {
    var form = layui.form,
        layer = layui.layer,
        $ = layui.jquery,
        element = layui.element,
        help = layui.help,
        product = layui.product,
        table = layui.table;

    var id=getUrlParam('id'),isUpdate=false;
    if(id){
        isUpdate = true;
    }

    $(document).ready(function () {
        if(isUpdate){
            $.get('getTemplate.html',{id:id},function (data) {
                form.val('template',{
                    'name':data.name,
                    'is_all_product':data.is_all_product.toString(),
                    'product_ids':data.product_ids
                });

                if(data.is_all_product == 1){
                    $('.select-product-btn').hide();
                }else{
                    $('.select-product-btn').show();
                    getProductList({product_ids:data.product_ids})
                }
                form.render();
            });
            setItem();
        }else{
            addItem(false);
        }
    });

    $('.select-product-btn').on('click',function () {
        product.select('checkbox',0,function (res) {
            var product_ids = [];
            $.each(res,function (index,item) {
                product_ids.push(item.id);
            });
            $('input[name="product_ids"]').val(product_ids.join(','));
            getProductList({product_ids:product_ids});
            layer.closeAll();
        });
    });

    $('.add_item').on('click',function () {
        addItem(true);
    });

    $('.service-list').on('click','.link',function () {
        var _this = $(this);
        help.select(function (res) {
            _this.val(res);
        });
    }).on('click','.delete-btn',function () {
        var _this = $(this);
        layer.confirm('确定删除吗',{icon:6,title:'提示信息'},function (index) {
            _this.parent().remove();
            layer.close(index)
        })
    });

    form.on('submit(submit)',function (data) {
        var post = data.field;
        if(isUpdate){
            post['id'] = id;
        }
        console.log(post)
        $.post('saveData.html',post,function (res) {
            console.log(res)
            if(res.state=='success'){
                layer.msg('操作成功',{icon:1})
            }else{
                layer.msg(res.msg,{icon:2})
            }
        });

        return false;
    });
    table.on('tool(products)', function(obj){
        var data = obj.data;
        var layEvent = obj.event;
        if(layEvent === 'del'){
            layer.confirm('真的删除行么', function(index){
                var product_ids = $('input[name="product_ids"]').val();
                if(product_ids.indexOf(data.id+',')==0){
                    product_ids = product_ids.replace(data.id+',','');
                }else if(product_ids.indexOf(data.id)==0){
                    product_ids = product_ids.replace(data.id,'');
                }else{
                    product_ids = product_ids.replace(','+data.id,'');
                }
                getProductList({product_ids:product_ids})
                $('input[name="product_ids"]').val(product_ids);
                obj.del();
                layer.close(index);
                //向服务端发送删除指令
            });
        }
    });
    form.on('radio(select_product)', function(data){
        var obj = data.elem;
        if(data.value==1){
            $('.product_list,.select-product-btn').hide();
        }else{
            $('.product_list,.select-product-btn').show();

        }
    });
    function getProductList(where) {
        table.render({
            elem: '#products',
            where:where,
            cellMinWidth : 85,
            url : '/admin/shipping/getProducts.html',
            page : true,
            limit : 5,
            id:'productList',
            cols : [[
                {field: 'id', title: 'ID', width:70, align:"center",sort: true},
                {field: 'name', title: '名称',minWidth:300,edit: 'text'},
                {field: 'thumb_img', title: '缩略片',align:'center',width:100,templet:'#thumb_img'},
                {field: 'price', title: '价格',align:'center',sort:true},
                {field: 'stock', title: '库存',align:'center',sort:true},
                {field: 'is_on_sale',title:'上架状态',align:'center',width:100,templet:'#is_on_sale'},
                {title:'操作',align:'center',width:100,templet:'#listBar'},
            ]],
            done:function (res, curr, count) {
            }
        })
    }
    function addItem(isClose) {
        var html='',data_ids = [],data_id,max_data_id;
        $('.service-list li').each(function (index,item) {
            data_ids.push($(item).data('id'));
        });
        data_ids.sort();
        max_data_id = data_ids[data_ids.length-1];
        data_id = (parseInt(max_data_id)>=0) ? (parseInt(max_data_id)+1):0;
        html += '<li data-id="'+data_id+'">';
        html += '<div class="layui-form-item">';
        html += '<label class="layui-form-label">服务项名称</label>';
        html += '<div class="layui-input-block">';
        html += '<input type="text" name="item['+data_id+'][name]" required  lay-verify="required" placeholder="请输入服务项名称" autocomplete="off" class="layui-input">';
        html += '</div>';
        html += '</div>';
        html += '<div class="layui-form-item">';
        html += '<label class="layui-form-label">链接地址</label>';
        html += '<div class="layui-input-block">';
        html += '<input type="text" name="item['+data_id+'][link]" required  lay-verify="required" placeholder="请选择链接地址" autocomplete="off" class="layui-input link">';
        html += '</div>';
        html += '</div>';
        if(isClose){
            html += '<i class="layui-icon layui-icon-close-fill delete-btn"></i>';
        }
        html += '</li>';
        $('.service-list').append(html);
    }
    function setItem() {
        $.get('getItems.html',{id:id},function (data) {
            var html = '';
            for(var i=0;i<data.length;i++){
                html += '<li data-id="'+i+'">';
                html += '<input type="hidden" name="item['+i+'][id]" value="'+data[i]['id']+'">';
                html += '<div class="layui-form-item">';
                html += '<label class="layui-form-label">服务项名称</label>';
                html += '<div class="layui-input-block">';
                html += '<input type="text" name="item['+i+'][name]" required  lay-verify="required" value="'+data[i]['name']+'" autocomplete="off" class="layui-input">';
                html += '</div>';
                html += '</div>';
                html += '<div class="layui-form-item">';
                html += '<label class="layui-form-label">链接地址</label>';
                html += '<div class="layui-input-block">';
                html += '<input type="text" name="item['+i+'][link]" required  lay-verify="required" value="'+data[i]['link']+'" autocomplete="off" class="layui-input link">';
                html += '</div>';
                html += '</div>';
                html += '<i class="layui-icon layui-icon-close-fill delete-btn"></i>';
                html += '</li>';
            }
            $('.service-list').append(html);
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