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
        images = layui.images;

    var id = getUrlParam('id');

    $(document).ready(function () {
        $.get('getData.html',{id:id},function (data) {
           form.val('advert-edit',{
                'img_url':data.img_url,
                'link_type':data.link_type,
                'link':data.link
           });
           $('.thumbImg').attr('src',data.img_url);
           form.render();
        });
        category.select_option(0,'#category');
    });

    $('.thumbBox').on('click',function () {
        var _this = $(this);
        images.select(function(data) {
            _this.find('img').attr('src',data);
            _this.find('input').val(data);
        });
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
        post['id'] = id;
        $.post('saveData.html',post,function (res) {
            if(res.state == 'success'){
                layer.msg('操作成功',{icon:1});
                form.render();
            }else{
                layer.msg(res.msg,{icon:2})
            }
        });
        return false;
    });

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