
layui.config(
    {
        base : "/static/admin/js/"
    }
).use(['form','layer','element','laydate','table','laytpl','product'],function () {
    var form = layui.form,
        layer = layui.layer,
        $ = layui.jquery,
        laydate = layui.laydate,
        element = layui.element,
        product = layui.product,
        table = layui.table;

    var id=getUrlParam('id'),isUpdate=false;
    if(id){
        isUpdate = true;
    }

    $(document).ready(function () {
        if(isUpdate){
            $.get('/admin/shipping/getRule.html',{id:id},function (data) {
                form.val('shipping',{
                    'title':data.title,
                    'is_long_term':data.is_long_term.toString(),
                    'start_time':data.start_time,
                    'end_time':data.end_time,
                    'product_ids':data.product_ids,
                    'is_all_product':data.is_all_product.toString()
                });
                if(data.is_long_term){
                    isShowTimeRange(true);
                }else{
                    isShowTimeRange(false);
                }
                if(data.is_all_product == 1){
                    $('.select-product-btn').hide();
                }else{
                    $('.select-product-btn').show();
                    getProductList({product_ids:data.product_ids})
                }
                form.render();
            });
            setRules();
        }else{
            addRules(false);
        }
    });

    $('.add_rule').on('click',function () {
        addRules(true);
    });
    $('.rule-div').on('click','.reduce_rule',function () {
        var _this = $(this);
        layer.confirm('确定删除吗？',{icon:3, title:'提示信息'},function(index){
            _this.parent().remove();
            layer.close(index);
        });

    }).on('click','.clear_region',function () {
        $(this).prev().find('input').val('');
    }).on('click','.select_area',function () {
        var _this = $(this);
        layer.open({
            type: 2,
            title: '选择地区',
            shadeClose: true,
            shade: 0.2,
            area: ['540px', '400px'],
            content: '/admin/freight/area.html',
            success : function (layero, index) {
                var body = layer.getChildFrame('body', index);
                body.find(".confirm").click(function () {
                    var input = body.find("input[type='checkbox']:checked");
                    if (input.length == 0) {
                        layer.alert('请添加区域', {icon: 2});
                        return false;
                    }
                    var area_list = [];
                    input.each(function(i,o){
                        var area_id = $(this).attr("value");
                        var area_name = $(this).data("name");
                        var area = new Area(area_id,area_name);
                        area_list.push(area);
                    });
                    call_back(area_list,_this);
                })

            }
        });
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
    laydate.render({
        elem:'#start_time',
        type: 'datetime'
    });
    laydate.render({
        elem:'#end_time',
        type: 'datetime'
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
    form.on('radio(is_long_term)', function(data){
        if(data.value==1){
            isShowTimeRange(true)
        }else{
            isShowTimeRange(false)
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

    form.on('submit(submit)',function (data) {
        var post = data.field;
        if(isUpdate){
            post['id'] = id;
        }
        layer.msg('数据更新中......',{icon:16});
        $.post('saveData.html',post,function (res) {
            if(res.state==='success'){
                layer.msg('数据更新成功');
                parent.location.reload();
            }else{
                layer.msg(res.msg);
            }
        })
        return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
    });

    //地区对象
    function Area(id, name) {
        this.id = id;
        this.name = name;
    }
    function call_back(area_list,obj) {
        var area_list_names = [];
        var area_list_ids = [];
        $.each(area_list, function (index, item) {
            area_list_names.push(item.name);
            area_list_ids.push(item.id)
        });
        var areaNames = area_list_names.join(',');
        var areaIds = area_list_ids.join(',');
        $(obj).val(areaNames);
        $(obj).parents('.rule-list-div').find('.area_ids').val(areaIds)
        layer.closeAll('iframe');
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
    function isShowTimeRange(flag) {
        if(flag){
            $(".time_range").hide();
        }else{
            $(".time_range").show();
        }
    }
    function getProductList(where) {
        table.render({
            elem: '#products',
            where:where,
            cellMinWidth : 85,
            url : 'getProducts.html',
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
    function setRules() {
        $.get('/admin/shipping/getRuleItems.html',{id:id},function (data) {
            var html = '';
            for(var i=0;i<data.length;i++){
                html += '<div class="rule-list-div" data-id="'+i+'">';
                html += '<i class="layui-icon layui-icon-close-fill reduce_rule" data-id=""></i>';
                html += '<div class="layui-form-item">';
                html += '<label class="layui-form-label">不包邮地区:</label>';
                html += '<input type="hidden" name="item['+i+'][id]" value="'+data[i]['id']+'"/>';
                html += '<input type="hidden"  name="item['+i+'][exc_region]" value="'+data[i]['exc_region']+'" class="area_ids"/>';
                html += '<div class="layui-input-inline">';
                html += '<input type="text" value="'+data[i]['exc_region_name']+'" autocomplete="off" class="layui-input select_area">';
                html += '</div>';
                html += '<button type="button" class="layui-btn clear_region">清空</button>';
                html += '</div>';
                html += '<div class="layui-form-item">';
                html += '<div class="layui-inline">';
                html += '<label class="layui-form-label">包邮规则:</label>';
                html += '<div class="layui-input-inline" style="width: 120px;">';
                html += '<input type="text" name="item['+i+'][number]" value="'+data[i]['number']+'" placeholder="" autocomplete="off" class="layui-input">';
                html += '</div>';
                html += '<div class="layui-input-inline" style="width: 60px;">';
                html += '<select name="item['+i+'][unit]" lay-verify="required">';
                if(data[i]['unit']=='1'){
                    html += '<option value="0">元</option>';
                    html += '<option value="1" selected>件</option>';
                }else{
                    html += '<option value="0" selected>元</option>';
                    html += '<option value="1">件</option>';
                }
                html += '</select>';
                html += '</div>';
                html += '</div>';
                html += '<div class="layui-inline">';
                html += '<div class="layui-form-mid layui-word-aux">免运费</div>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
            }
            $('.rule-div').append(html);
            form.render();
        })


    }
    function addRules(isClose) {
        var html='',data_ids = [],data_id,max_data_id;
        $('.rule-list-div').each(function (index,item) {
            data_ids.push($(item).data('id'));
        });
        data_ids.sort();
        max_data_id = data_ids[data_ids.length-1];
        data_id = (parseInt(max_data_id)>=0) ? (parseInt(max_data_id)+1):0;
        html += '<div class="rule-list-div" data-id="'+data_id+'">';
        if(isClose){
            html += '<i class="layui-icon layui-icon-close-fill reduce_rule" data-id=""></i>';
        }
        html += '<div class="layui-form-item">';
        html += '<label class="layui-form-label">不包邮地区:</label>';
        html += '<input type="hidden"  name="item['+data_id+'][exc_region]" value="" class="area_ids"/>';
        html += '<div class="layui-input-inline">';
        html += '<input type="text" required lay-verify="required" placeholder="默认所有地区包邮" autocomplete="off" class="layui-input select_area">';
        html += '</div>';
        html += '<button type="button" class="layui-btn clear_region">清空</button>';
        html += '</div>';
        html += '<div class="layui-form-item">';
        html += '<div class="layui-inline">';
        html += '<label class="layui-form-label">包邮规则:</label>';
        html += '<div class="layui-input-inline" style="width: 120px;">';
        html += '<input type="text" name="item['+data_id+'][number]" placeholder="" autocomplete="off" class="layui-input">';
        html += '</div>';
        html += '<div class="layui-input-inline" style="width: 60px;">';
        html += '<select name="item['+data_id+'][unit]" lay-verify="required">';
        html += '<option value="0">元</option>';
        html += '<option value="1">件</option>';
        html += '</select>';
        html += '</div>';
        html += '</div>';
        html += '<div class="layui-inline">';
        html += '<div class="layui-form-mid layui-word-aux">免运费</div>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        $('.rule-div').append(html);
        form.render();
    }

})