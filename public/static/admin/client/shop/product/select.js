var getProduct,selectType,category_id;
layui.config({
    base : "/static/admin/js/"
}).use(['table','form','laypage','jquery','category'],function(){
    var form = layui.form,
        $ = layui.jquery,
        table = layui.table,
        category = layui.category;

    var condition = {};

    $(document).ready(function () {
        selectType = getUrlParam('type');
        category_id = getUrlParam('category_id');
        category.select_option(category_id,'.select_category');
        condition['category'] = category_id;
        products();
    });
    form.on('submit(sreach)', function(data){
        var post = data.field;
        condition['product_name'] = post['product_name'];
        condition['category'] = post['category'];
        condition['nation'] = post['nation'];
        condition['is_free_shipping'] = post['is_free_shipping'];
        products();
        return false;
    });

    getProduct = function(){
        var checkStatus,product;
        checkStatus = table.checkStatus('product');
        product = checkStatus.data;
        return product;
    };
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
    function products() {
        var index = layer.msg('数据加载中......',{icon:16});
        table.render({
            elem: '#list',
            where:condition,
            method:'post',
            url : '/admin/product/getList.html',
            page : true,
            limit : 10,
            id:'product',
            cols : [[
                {type: selectType, fixed:"left", width:50},
                {field: 'id', title: 'ID', width:60, align:"center",sort: true},
                {field: 'name', title: '名称', minWidth:260,templet:function (d) {
                    return d.name.substring(0,50);
                }},
                {field: 'thumb_img', title: '缩略片',width:80,align:'center',templet:function(d){
                    return '<img src="'+d.thumb_img+'" width="40" height="52">'
                }},
                {field: 'price', title: '价格',minWidth:80,align:'center',sort:true},
                {field: 'stock', title: '库存',minWidth:80,align:'center',sort:true},
                {field: 'sales_volume',title:'销售量',minWidth:100,align:'center',sort:true}

            ]],
            done:function () {
                layer.close(index);
            }

        })
    }


});