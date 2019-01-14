layui.config({
    base : "/static/admin/js/"
}).extend({
    "swiper" : "swiper"
}).use(['carousel','form','layer','jquery','category','images','product','help'], function(){
    var carousel = layui.carousel,
        form = layui.form,
        $ = layui.jquery,
        layer = layui.layer,
        category = layui.category,
        images = layui.images,
        help = layui.help,
        product = layui.product;

    var num = 0,index = layer.msg('数据加载中......',{icon:16,time:0})
    $(document).ready(function () {

        $.get('/admin/advert_item/getBanners.html',function (data) {
            setBanner(data);
            countNum();
        });
        $.get('/admin/Slogan/getList.html',function (data) {
            setSlogan(data);
            countNum();
        });
        $.get('/admin/Navigation/getList.html',function (data) {
            setCatNav(data);
            countNum();
        });
        $.get('/admin/shop_home/catProduct.html',function (data) {
            setCatProduct(data);
            countNum();
        });
        $.get('/admin/shop_home/recommend.html',function (data) {
            var products = data['products'];
            $('#recommend_id').val(data['id']);
            setRecommend(products,0);
            countNum();
        });
    });

    var options = {
        elem: '#banner',
        width:'100%',
        height:'100%',
        arrow:'none',
        interval: 5000
    };
    var myswiper;
    var ins = carousel.render(options);

    $(".edit-item,.category-porduct").on("click",'.design-show',function () {
        $(".design-item").hide();
        $(this).next('.design-item').show();
    });

    $(".design-slogan").on('click','.slogan-link',function () {
        var _this = $(this);
        help.select(function (res) {
            _this.val(res);
        });

    }).on('mousemove','ul li',function () {
        var _this = $(this);
        $(this).parent().sortable({
            stop: function(event, ui){
                var order = [];
                var html = '';
                _this.parent().children().each(function () {
                    order.push($(this).data('content-id'))
                });
                for(var i in order ){
                    html += $(".slogan ul li[data-content-id='"+order[i]+"']").prop('outerHTML');
                }
                $('.slogan ul').empty().append(html);
            }
        });
    }).on('input','.set_slogan_title',function () {
        var slogan_title = $(this).val();
        var content_id = $(this).parents('li').data('content-id');
        $(this).parents('.design-item').prev().find("ul li[data-content-id='"+content_id+"'] span").html(slogan_title);
    });

    $('.design-nav-cat').on('mousemove','ul li',function () {
        var _this = $(this);
        $(this).parent().sortable({
            stop: function(event, ui){
                var order = [];
                var html = '';
                _this.parent().children().each(function () {
                    order.push($(this).data('content-id'))
                });
                for(var i in order ){
                    html += $(".cat-nav ul li[data-content-id='"+order[i]+"']").prop('outerHTML');
                }
                $('.cat-nav ul').empty().append(html);
                setCatNavSort();
            }
        });
    }).on('click','.thumbBox',function () {
        var _this = $(this);
        var li_count_id = $(this).parents('li').data('content-id');
        images.select(function(data) {
            _this.find('img').attr('src',data);
            _this.find('input').val(data);
            $(".cat-nav ul li[data-content-id='"+li_count_id+"']").find('img').attr('src',data);
        });

    }).on('input','.set_cat_name',function () {
        var cat_name = $(this).val();
        var content_id = $(this).parents('li').data('content-id');
        $(this).parents('.design-item').prev().find('ul li[data-content-id="'+content_id+'"] span').html(cat_name)
    });

    $(".add-banner").click(function () {
        var content_ids = [];
        $(this).prev().find('li').each(function () {
            content_ids.push($(this).data('content-id'))
        });
        var content_id = sortDataId(content_ids);
        addBanner(content_id);
    });

    $(".banner-list").on("click",".item-delete-btn",function () {
        var _this = $(this);
        var length = $('.banner-list li').length;
        if(length<2){
            layer.msg('不能全部删除哦',{icon:2});
        }else{
            layer.confirm('确定删除吗？',{icon:3, title:'提示信息'},function(index){
                var order = [];
                _this.parent().siblings('li').each(function () {
                    order.push($(this).data('content-id'))
                });
                var html = '<div carousel-item>';
                for(var i in order ){
                    html += $("#banner div[data-content-id='"+order[i]+"']").prop('outerHTML');
                }
                html += '</div>';
                $('#banner').empty().append(html);
                ins.reload(options);
                _this.parent().hide(1000);
                setTimeout(function(){_this.parent().remove();},950);
                layer.close(index);
            });
        }

    }).on('mousemove','li',function () {
        var _this = $(this);
        $(this).parent().sortable({
            stop: function(event, ui){
                var order = [];
                _this.parent().children().each(function () {
                    order.push($(this).data('content-id'))
                });
                var html = '<div carousel-item>';
                for(var i in order ){
                    html += $("#banner div[data-content-id='"+order[i]+"']").prop('outerHTML');
                }
                html += '</div>';
                $('#banner').empty().append(html);
                ins.reload(options);
            }
        });

    }).on('click','.thumbBox',function () {
        var _this = $(this);
        var li_count_id = $(this).parents('li').data('content-id');
        images.select(function(data) {
            _this.find('img').attr('src',data);
            _this.find('input').val(data);
            $("#banner div[data-content-id='"+li_count_id+"']").find('img').attr('src',data);
        });

    });

    $(".category-porduct").on("click",".delete-cat-product-item",function () {

        var _this = $(this);
        var length = $('.category-porduct-list').length;
        if(length<2){
            layer.msg('不能全部删除哦',{icon:2});
        }else{
            deleteElement(_this,'.category-porduct-list');
        }
    }).on('click','.active-add-next-btn',function () {

        addCatProduct();
        form.render();

    }).on("click",".item-delete-btn",function () {

        var _this = $(this);
        deleteElement(_this,'li');

    }).on('click','.top-product-link',function () {
        var _this = $(this);
        var category_id = $(this).parents('.category-porduct-list').data('id');
        product.select('radio',category_id,function (res) {
            var data = res[0];
            var product_id = data['id'];
            var product_link = 'pages/shop/product/product?id='+product_id;
            _this.val(product_link);
            _this.prev().val(product_id);
            layer.closeAll();
        });

    }).on('click','.add-product-list',function () {
        var _this = $(this);
        var category_id = $(this).parents('.category-porduct-list').data('id');
        product.select('checkbox',category_id,function (data) {
            var content_ids = [];
             _this.prev().find('li').each(function () {
                content_ids.push($(this).data('content-id'))
            });
            var content_id = sortDataId(content_ids);
            var list_content_id = _this.parents('.category-porduct-list').data('content-id');
            var result = setProductList(data,content_id,list_content_id);
            _this.prev().append(result['design_html']);
            if(content_id){
                _this.parents('.design-item').prev().find('ul').append(result['html']);
            }else{
                _this.parents('.design-item').prev().find('ul').empty().append(result['html']);
            }
            myswiper = new Swiper('.swiper-container', {
                slidesPerView: 4.6,
            })
            layer.closeAll();
        });

    }).on('mousemove','.category-porduct-list',function () {
        var _this = $(this);
        $(this).parent().sortable({
            stop: function(event, ui){

            }
        });
    }).on('mousemove','.product_sort li',function () {
        var _this = $(this);
        $(this).parent().sortable({
            stop: function(event, ui){
                var order = [];
                var html = '';
                _this.parent().children().each(function () {
                    order.push($(this).data('content-id'))
                });
                for(var i in order ){
                    html += _this.parents('.design-item').prev().find("ul li[data-content-id='"+order[i]+"']").prop('outerHTML');
                }
                _this.parents('.design-item').prev().find('ul').empty().append(html);
            }
        });
    }).on('click','.thumbBox',function () {
        var _this = $(this);
        var li_count_id = $(this).parents('li').data('content-id');
        images.select(function(data) {
            _this.find('img').attr('src',data);
            _this.parents('.design-item').prev().find('img').attr('src',data);
            _this.find('input').val(data)
        });
    }).on('input','.en_category',function () {
        var en_category = $(this).val();
        $(this).parents('.design-item').prev().find('h2 em').html(en_category);
    }).on('click','.item-delete-btn',function () {
        var content_id = $(this).parent().data('content-id');
         var _this = $(this);
         layer.confirm('确定删除吗？',{icon:3, title:'提示信息'},function(index){
         _this.parents('.design-item').prev().find("ul li[data-content-id='"+content_id+"']").remove();
         _this.parent().hide(1000);
         setTimeout(function(){_this.parent().remove();},950);
         layer.close(index);
         });
    }).on('input','.set_short_name',function () {
        var content_id = $(this).parents('li').data('content-id');
        var short_name = $(this).val();
        $(this).parents('.design-item').prev().find("ul li[data-content-id='"+content_id+"'] span").html(short_name)
    });

    $('.design-reccomend').on('click','.add-product-recommend',function () {
        var content_ids = [],_this = $(this);
        _this.prev().find('li').each(function () {
            content_ids.push($(this).data('content-id'));
        });
        var content_id = sortDataId(content_ids);
        product.select('checkbox','',function (data) {
            setRecommend(data,content_id);
            layer.closeAll();
        });
    }).on('click','.item-delete-btn',function () {
        var content_id = $(this).parent().data('content-id');
        var _this = $(this);
        layer.confirm('确定删除吗？',{icon:3, title:'提示信息'},function(index){
            _this.parents('.design-item').prev().find("ul li[data-content-id='"+content_id+"']").remove();
            _this.parent().hide(1000);
            setTimeout(function(){_this.parent().remove();},950);
            setRecommendProducts();
            layer.close(index);
        });
    }).on('mousemove','ul li',function () {
        var _this = $(this);
        $(this).parent().sortable({
            stop: function(event, ui){
                var order = [];
                var html = '';
                _this.parent().children().each(function () {
                    order.push($(this).data('content-id'))
                });
                for(var i in order ){
                    html += $(".recommend-list li[data-content-id='"+order[i]+"']").prop('outerHTML');
                }
                $('.recommend-list').empty().append(html);
                setRecommendProducts();
            }
        });
    });

    form.on('select(banner-link-type)', function(data){
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
                    var banner_link = 'pages/shop/product/product?id='+product_id;
                    _this.parents('.layui-form-item').siblings('.banner-link').find('input[type="text"]').val(text);
                    _this.parents('.layui-form-item').siblings('.banner-link').find('input[type="hidden"]').val(banner_link);
                    layer.closeAll();
                });
                break;
        }
    });
    form.on('select(category)', function(data){
        var obj = data.elem;
        var text = '分类：'+obj.options[obj.options.selectedIndex]['innerText'];
        var link = 'pages/shop/product/list?id='+data.value;
        $(this).parents('.layui-form-item').next().find('input[type="text"]').val(text);
        $(this).parents('.layui-form-item').next().find('input[type="hidden"]').val(link);
    });

    form.on('select(category-nav)', function(data){
        var cat_nav_link = 'pages/shop/product/list?id='+data.value;
        $(this).parents('.layui-form-item').next().find('.cat-nav-link').val(cat_nav_link);
    });

    form.on('submit(submit)', function(data){
        var index = layer.msg('数据修改中......',{icon:16,time:0});
        $.post('/admin/shop_home/handle.html',data.field,function (data) {
            layer.close(index);
            layer.msg('操作成功', {icon: 1,shade: 0.01,time: 3000});
        });
        return false;
    });

    form.on('select(set_category)',function(data){
        var category_text = data.elem.options[data.elem.options.selectedIndex]['innerText'];
        $(this).parents('.design-item').prev().find('h2 strong').html(category_text);
        $(this).parents('.category-porduct-list').data('id',data.value);
    });

    function countNum() {
        num = num+1;
        if(num>=5){
            layer.close(index);
        }
    }

    function deleteElement(_this,parentElement) {
        layer.confirm('确定删除吗？',{icon:3, title:'提示信息'},function(index){
            _this.parents(parentElement).hide(1000);
            setTimeout(function(){_this.parents(parentElement).remove();},950);
            layer.close(index);
        });
    }

    function sortDataId(content_ids) {
        var max_content_id,content_id;
        content_ids.sort();
        max_content_id = parseInt(content_ids[content_ids.length-1]);
        content_id = max_content_id>=0?(max_content_id+1):0;
        return content_id;
    }
    function setRecommendProducts() {
        var product_ids = [];
        $('.recommend-list li').each(function () {
            var prodcut_id = $(this).data('id');
            product_ids.push(prodcut_id);
        });
        $("#recommend_product_ids").val(product_ids);
    }

    function setCatNavSort() {
        var sort = [];
        $('.design-nav-cat ul li').each(function () {
            var conent_id = $(this).data('content-id');
            sort.push(conent_id);
        });
        $("input[name='cat_nav_sort']").val(sort);
    }

    function setBanner(data){
        var design_html = '';
        var html = '<div carousel-item>';
        for(var i=0;i<data.length;i++){
            html += '<div data-content-id="'+i+'"><img src="'+data[i]['img_url']+'"></div>';
            design_html += '<li data-content-id="'+i+'">';
            design_html += '<input type="hidden" value="'+data[i]['id']+'"  name="banner['+i+'][id]">';
            design_html += '<div class="layui-form-item">';
            design_html += '<label class="layui-form-label">广告图片：</label>';
            design_html += '<div class="layui-input-inline width60">';
            design_html += '<div class="thumbBox">';
            design_html += '<i class="layui-icon layui-icon-add-1"></i>';
            design_html += '<img src="'+data[i]['img_url']+'" class="layui-upload-img thumbImg">';
            design_html += '<input type="hidden" value="'+data[i]['img_url']+'"  name="banner['+i+'][img]">';
            design_html += '</div>';
            design_html += '<div class="layui-form-mid layui-word-aux">图片尺寸为：750px*540px</div>';
            design_html += '</div>';
            design_html += '</div>';
            design_html += '<div class="layui-form-item">';
            design_html += '<label class="layui-form-label">链接类型：</label>';
            design_html += '<div class="layui-input-inline">';
            design_html += '<select  lay-filter="banner-link-type" >';
            design_html += '<option value="0">请选择链接类型</option>';
            design_html += '<option value="1">跳转到分类</option>';
            design_html += '<option value="2">跳转到商品</option>';
            design_html += '</select>';
            design_html += '</div>';
            design_html += '</div>';
            design_html += '<div class="layui-form-item layui-hide">';
            design_html += '<label class="layui-form-label">选择分类：</label>';
            design_html += '<div class="layui-input-inline">';
            design_html += '<select lay-filter="category" id="banner_select_category'+i+'" onload="'+category.select_option(0,"#banner_select_category"+i)+'">';
            design_html += '<option value="">请选择分类</option>';
            design_html += '</select>';
            design_html += '</div>';
            design_html += '</div>';
            design_html += '<div class="layui-form-item banner-link">';
            design_html += '<label class="layui-form-label">链接页面：</label>';
            design_html += '<div class="layui-input-inline">';
            design_html += '<input type="text" name="banner['+i+'][link_type]" value="'+data[i]['link_type']+'"  disabled="disabled" placeholder="请编辑链接地址" class="layui-input" >';
            design_html += '<input type="hidden" name="banner['+i+'][link]" value="'+data[i]['link']+'">';
            design_html += '</div>';
            design_html += '</div>';
            design_html += '<div class="icon-btn item-delete-btn">';
            design_html += '<i class="layui-icon layui-icon-close"></i>';
            design_html += '</div>';
            design_html += '</li>';

        }
        html += '</div>';
        $('#banner').append(html);
        $('.banner-list').append(design_html);
        ins.reload(options);
        form.render();
    }
    function setSlogan(data) {
        var html = '';
        var design_html = '';
        for(var i=0;i<data.length;i++){
            html += '<li data-content-id="'+i+'"><i class="layui-icon layui-icon-ok-circle"></i><span>'+data[i]['title']+'</span></li>';
            design_html += '<li data-content-id="'+i+'">';
            design_html += '<input type="hidden" name="slogan['+i+'][id]" value="'+data[i]['id']+'">';
            design_html += '<div class="layui-form-item">';
            design_html += '<label class="layui-form-label">标题：</label>';
            design_html += '<div class="layui-input-inline">';
            design_html += '<input type="text" name="slogan['+i+'][title]" value="'+data[i]['title']+'" placeholder="请输入广告标题" class="set_slogan_title layui-input" >';
            design_html += '</div>';
            design_html += '</div>';
            design_html += '<div class="layui-form-item">';
            design_html += '<label class="layui-form-label">链接：</label>';
            design_html += '<div class="layui-input-inline">';
            design_html += '<input type="text" name="slogan['+i+'][link]" value="'+data[i]['link']+'" placeholder="请选择广告跳转页面" class="slogan-link layui-input" >';
            design_html += '</div>';
            design_html += '</div>';
            design_html += '</li>';
        }
        $('.slogan ul').append(html);
        $('.design-slogan ul').append(design_html);
    }

    function setCatNav(data) {
        var html = '';
        var design_html = '';
        for(var i=0;i<data.length;i++){
            html += '<li data-content-id="'+i+'">';
            html += '<img src="'+data[i]['icon']+'">';
            html += '<span>'+data[i]['title']+'</span>';
            html += '</li>';
            design_html += '<li data-content-id="'+i+'">';
            design_html += '<input type="hidden" name="cat_nav['+i+'][id]" value="'+data[i]['id']+'">';
            design_html += '<input type="hidden" name="cat_nav['+i+'][category_id]" value="'+data[i]['category_id']+'">';
            design_html += '<div class="layui-form-item">';
            design_html += '<label class="layui-form-label">分类名称：</label>';
            design_html += '<div class="layui-input-inline">';
            design_html += '<input type="text" name="cat_nav['+i+'][title]" value="'+data[i]['title']+'" placeholder="请输入分类名称" class="set_cat_name layui-input">';
            design_html += '</div>';
            design_html += '</div>';
            design_html += '<div class="layui-form-item">';
            design_html += '<label class="layui-form-label">缩略图片：</label>';
            design_html += '<div class="layui-input-inline">';
            design_html += '<div class="thumbBox">';
            design_html += '<i class="layui-icon layui-icon-add-1"></i>';
            design_html += '<img src="'+data[i]['icon']+'" class="layui-upload-img thumbImg">';
            design_html += '<input type="hidden" value="'+data[i]['icon']+'"  name="cat_nav['+i+'][img]">';
            design_html += '</div>';
            design_html += '<div class="layui-form-mid layui-word-aux">图片尺寸为：300px*300px</div>';
            design_html += '</div>';
            design_html += '</div>';
            design_html += '<div class="layui-form-item">';
            design_html += '<label class="layui-form-label">链接分类：</label>';
            design_html += '<div class="layui-input-inline">';
            design_html += '<select lay-filter="category-nav" id="nav_select_category'+i+'" data-id="0" onload="'+category.select_option(data[i]["category_id"],"#nav_select_category"+i)+'">';
            design_html += '<option>请选择链接分类</option>';
            design_html += '</select>';
            design_html += '</div>';
            design_html += '</div>';
            design_html += '<div class="layui-form-item">';
            design_html += '<label class="layui-form-label">链接地址：</label>';
            design_html += '<div class="layui-input-inline">';
            design_html += '<input type="text" name="cat_nav['+i+'][link]" value="'+data[i]['link']+'"  placeholder="自动获取链接地址" class="cat-nav-link layui-input"  disabled="disabled">';
            design_html += '</div>';
            design_html += '</div>';
            design_html += '</li>';
        }
        $('.cat-nav ul').append(html);
        $('.design-nav-cat ul').append(design_html);
        setCatNavSort();

    }
    function setCatProduct(data) {
        var html = '';
        for(var i=0;i<data.length;i++){
            html += '<div class="category-porduct-list" data-content-id="'+i+'" data-id="'+data[i]['category']['id']+'">';
            html += '<input type="hidden" name="cat_product['+i+'][id]" value="'+data[i]['id']+'">';
            html += '<div class="edit-item">';
            html += '<div class="design-show category">';
            html += '<h2><strong>'+data[i]['category']['name']+'</strong><em>'+data[i]['category']['en_name']+'</em><span>更多</span></h2>';
            html += '</div>';
            html += '<div class="design-item">';
            html += '<div class="design-category">';
            html += '<h2>请编辑商品分类</h2>';
            html += '<div class="design-content">';
            html += '<div class="layui-form-item">';
            html += '<label class="layui-form-label">分类名称：</label>';
            html += '<div class="layui-input-inline">';
            html += '<select id="cat_product_select_option'+i+'" onload="'+category.select_option(data[i]["category"]["id"],"#cat_product_select_option"+i)+'" ' +
                'lay-filter="set_category"  name="cat_product['+i+'][cat][id]" data-id="'+data[i]['category']['id']+'">';
            html += '<option>请选择商品分类</option>';
            html += '</select>';
            html += '</div>';
            html += '</div>';
            html += '<div class="layui-form-item">';
            html += '<label class="layui-form-label">英文名称：</label>';
            html += '<div class="layui-input-inline">';
            html += '<input type="text" name="cat_product['+i+'][cat][en_name]" value="'+data[i]['category']['en_name']+'" placeholder="请输入分类英文名称" class="en_category layui-input" >';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '<div class="product">';
            html += '<div class="edit-item">';
            html += '<div class="design-show top">';
            html += '<img src="'+data[i]['top_product']['big_thumb_img']+'">';
            html += '</div>';
            html += '<div class="design-item">';
            html += '<h2>请编辑头条商品</h2>';
            html += '<div class="design-content">';
            html += '<div class="layui-form-item">';
            html += '<label class="layui-form-label">上传图片：</label>';
            html += '<div class="layui-input-inline">';
            html += '<div class="thumbBox">';
            html += '<i class="layui-icon layui-icon-add-1"></i>';
            html += '<img src="'+data[i]['top_product']['big_thumb_img']+'" class="layui-upload-img thumbImg">';
            html += '<input type="hidden" value="'+data[i]['top_product']['big_thumb_img']+'"  name="cat_product['+i+'][top_product][big_thumb_img]">';
            html += '</div>';
            html += '<div class="layui-form-mid layui-word-aux">图片尺寸为：750px*360px</div>';
            html += '</div>';
            html += '</div>';
            html += '<div class="layui-form-item">';
            html += '<label class="layui-form-label">链接地址：</label>';
            html += '<div class="layui-input-inline">';
            html += '<input type="hidden" name="cat_product['+i+'][top_product][id]" value="'+data[i]['top_product']['id']+'" >';
            html += '<input type="text" value="pages/shop/product/product?id='+data[i]['top_product']['id']+'" placeholder="请输入链接地址" class="top-product-link layui-input" >';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '<div class="edit-item">';
            html += '<div class="design-show product_list swiper-container">';
            html += '<ul class="swiper-wrapper">';
            for(var j=0;j<data[i]['list_products'].length;j++){
                html += '<li data-content-id="'+j+'" class="swiper-slide">';
                html += '<img src="'+data[i]['list_products'][j]['thumb_img']+'">';
                html += '<span>'+data[i]['list_products'][j]['short_name']+'</span>';
                html += '</li>';
            }
            html += '</ul>';
            html += '</div>';
            html += '<div class="design-item">';
            html += '<h2>请编辑列表商品</h2>';
            html += '<div class="design-product">';
            html += '<ul class="product_sort">';
            for(var j=0;j<data[i]['list_products'].length;j++){
                html += '<li data-content-id="'+j+'">';
                html += '<div class="layui-form-item">';
                html += '<label class="layui-form-label">商品名称：</label>';
                html += '<div class="product-name">'+data[i]['list_products'][j]['name']+'</div>';
                html += '</div>';
                html += '<div class="layui-form-item">';
                html += '<label class="layui-form-label">缩略图片：</label>';
                html += '<div class="layui-input-inline">';
                html += '<img src="'+data[i]['list_products'][j]['thumb_img']+'">';
                html += '</div>';
                html += '</div>';
                html += '<div class="layui-form-item">';
                html += '<label class="layui-form-label">缩略名称：</label>';
                html += '<div class="layui-input-inline">';
                html += '<input type="hidden" name="cat_product['+i+'][list_product]['+j+'][id]" value="'+data[i]['list_products'][j]['id']+'">';
                html += '<input type="text" name="cat_product['+i+'][list_product]['+j+'][short_name]" value="'+data[i]['list_products'][j]['short_name']+'" placeholder="请输入商品缩略名称（四个汉字）" class="set_short_name layui-input">';
                html += '</div>';
                html += '</div>';
                html += '<div class="icon-btn item-delete-btn"><i class="layui-icon layui-icon-close"></i></div>';
                html += '</li>';
            }
            html += '</ul>';
            html += '<div class="design-add-btn add-product-list">';
            html += '<div class="desing-add-img-text">';
            html += '<i class="layui-icon layui-icon-add-1">请选择添加商品</i>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '<div class="icon-btn active-add-next-btn"><i class="layui-icon layui-icon-add-circle"></i></div>';
            html += '<div class="icon-btn delete-cat-product-item"><i class="layui-icon layui-icon-close"></i></div>';
            html += '</div>';
        }
        $('.category-porduct').append(html);
        myswiper = new Swiper('.swiper-container', {
            slidesPerView: 4.6,
        })
    }
    function setRecommend(products,start) {
        var design_html = '';
        var html = '';
        for(var i=0;i<products.length;i++){
            var new_start = start + i;
            html += '<li data-content-id="'+new_start+'" data-id="'+products[i]['id']+'">';
            html += '<img src="'+products[i]['thumb_img']+'">';
            html += '<h3>';
            if(products[i]['nation']==1){
                html += '<em>直邮购</em>';
            }
            html += products[i]['name']+'</h3>';
            html += '<p>¥ '+products[i]['price']+' <s>'+products[i]['original_price']+'</s></p>';
            html += '</li>';
            design_html += '<li data-content-id="'+new_start+'" data-id="'+products[i]['id']+'">';
            design_html += '<div class="layui-form-item">';
            design_html += '<label class="layui-form-label">缩略图片：</label>';
            design_html += '<div class="layui-input-inline">';
            design_html += '<img src="'+products[i]['thumb_img']+'">';
            design_html += '</div>';
            design_html += '</div>';
            design_html += '<div class="layui-form-item">';
            design_html += '<label class="layui-form-label">商品名称：</label>';
            design_html += '<div class="recommend-product-name">';
            if(products[i]['nation']==1){
                design_html += '<em>直邮购</em>';
            }
            design_html += products[i]['name']+'</div>';
            design_html += '</div>';
            design_html += '<div class="icon-btn item-delete-btn"><i class="layui-icon layui-icon-close"></i></div>';
            design_html += '</li>';
        }
        $('.recommend-list').append(html);
        $('.design-reccomend ul').append(design_html);
        setRecommendProducts();
    }
    function setProductList(data,content_id,list_content_id) {
        var html = '';
        var design_html = '';
        for(var i=0;i<data.length;i++){
            var new_content_id = content_id+i+1;
            html += '<li data-content-id="'+new_content_id+'" class="swiper-slide">';
            html += '<img src="'+data[i]['thumb_img']+'">';
            html += '<span>'+data[i]['short_name']+'</span>';
            html += '</li>';
            design_html += '<li data-content-id="'+new_content_id+'">';
            design_html += '<div class="layui-form-item">';
            design_html += '<label class="layui-form-label">商品名称：</label>';
            design_html += '<div class="product-name">'+data[i]['name']+'</div>';
            design_html += '</div>';
            design_html += '<div class="layui-form-item">';
            design_html += '<label class="layui-form-label">缩略图片：</label>';
            design_html += '<div class="layui-input-inline">';
            design_html += '<img src="'+data[i]['thumb_img']+'">';
            design_html += '</div>';
            design_html += '</div>';
            design_html += '<div class="layui-form-item">';
            design_html += '<label class="layui-form-label">缩略名称：</label>';
            design_html += '<div class="layui-input-inline">';
            design_html += '<input type="hidden" name="cat_product['+list_content_id+'][list_product]['+new_content_id+'][id]" value="'+data[i]["id"]+'">';
            if(data[i]['short_name']){
                design_html += '<input type="text"  name="cat_product['+list_content_id+'][list_product]['+new_content_id+'][short_name]" value="'+data[i]["short_name"]+'" placeholder="请输入商品缩略名称（四个汉字）" class="set_short_name layui-input">';
            }else{
                design_html += '<input type="text" name="cat_product['+list_content_id+'][list_product]['+new_content_id+'][short_name]" value="" placeholder="请输入商品缩略名称（四个汉字）" class="set_short_name layui-input">';
            }
            design_html += '</div>';
            design_html += '</div>';
            design_html += '<div class="icon-btn item-delete-btn"><i class="layui-icon layui-icon-close"></i></div>';
            design_html += '</li>';
        }
        var result = [];
        result['html'] = html;
        result['design_html'] = design_html;
        return result;
    }
    function addBanner(content_id) {
        var html = '';
        var design_html = '';
        var start = content_id + 1;
        html += '<div data-content-id="'+start+'"><img src="/static/admin/images/userface1.jpg"></div>';
        design_html += '<li data-content-id="'+start+'">';
        design_html += '<div class="layui-form-item">';
        design_html += '<label class="layui-form-label">广告图片：</label>';
        design_html += '<div class="layui-input-inline width60">';
        design_html += '<div class="thumbBox">';
        design_html += '<i class="layui-icon layui-icon-add-1"></i>';
        design_html += '<img class="layui-upload-img thumbImg">';
        design_html += '<input type="hidden" value=""  name="banner['+start+'][img]">';
        design_html += '</div>';
        design_html += '<div class="layui-form-mid layui-word-aux">图片尺寸为：750px*540px</div>';
        design_html += '</div>';
        design_html += '</div>';
        design_html += '<div class="layui-form-item">';
        design_html += '<label class="layui-form-label">链接类型：</label>';
        design_html += '<div class="layui-input-inline">';
        design_html += '<select  lay-filter="banner-link-type" >';
        design_html += '<option value="0">请选择链接类型</option>';
        design_html += '<option value="1">跳转到分类</option>';
        design_html += '<option value="2">跳转到商品</option>';
        design_html += '</select>';
        design_html += '</div>';
        design_html += '</div>';
        design_html += '<div class="layui-form-item layui-hide">';
        design_html += '<label class="layui-form-label">选择分类：</label>';
        design_html += '<div class="layui-input-inline">';
        design_html += '<select lay-filter="category" id="banner_select_category'+start+'" onload="'+category.select_option(0,"#banner_select_category"+start)+'" data-id="0">';
        design_html += '<option value="">请选择分类</option>';
        design_html += '</select>';
        design_html += '</div>';
        design_html += '</div>';
        design_html += '<div class="layui-form-item banner-link">';
        design_html += '<label class="layui-form-label">跳转页面：</label>';
        design_html += '<div class="layui-input-inline">';
        design_html += '<input type="text"  name="banner['+start+'][link_type]" value=""  disabled="disabled" placeholder="请编辑链接地址" class="layui-input" >';
        design_html += '<input type="hidden" name="banner['+start+'][link]" value="">';
        design_html += '</div>';
        design_html += '</div>';
        design_html += '<div class="icon-btn item-delete-btn">';
        design_html += '<i class="layui-icon layui-icon-close"></i>';
        design_html += '</div>';
        design_html += '</li>';
        $('#banner').children('div').append(html);
        $('.banner-list').append(design_html);
        ins.reload(options);
        form.render();
    }
    function addCatProduct() {
        var product_nums = 6;
        var content_ids = [];
        var html = '';
        $('.category-porduct-list').each(function(){
            content_ids.push($(this).data('content-id'));
        })
        content_ids.sort();
        var max_content_id = content_ids[content_ids.length-1];
        var new_content_id = max_content_id != null ? (parseInt(max_content_id)+1):0;
        html += '<div class="category-porduct-list" data-content-id="'+new_content_id+'" data-id="0">';
        html += '<div class="edit-item">';
        html += '<div class="design-show category">';
        html += '<h2><strong>分类名称</strong><em>CATEGORY NAME</em><span>更多</span></h2>';
        html += '</div>';
        html += '<div class="design-item">';
        html += '<div class="design-category">';
        html += '<h2>请编辑商品分类</h2>';
        html += '<div class="design-content">';
        html += '<div class="layui-form-item">';
        html += '<label class="layui-form-label">分类名称：</label>';
        html += '<div class="layui-input-inline">';
        html += '<select id="cat_product_select_option'+new_content_id+'" onload="'+category.select_option(0,"#cat_product_select_option"+new_content_id)+'" ' +
            ' lay-filter="set_category"  name="cat_product['+new_content_id+'][cat][id]" data-id="0">';
        html += '<option>请选择商品分类</option>';
        html += '</select>';
        html += '</div>';
        html += '</div>';
        html += '<div class="layui-form-item">';
        html += '<label class="layui-form-label">英文名称：</label>';
        html += '<div class="layui-input-inline">';
        html += '<input type="text" name="cat_product['+new_content_id+'][cat][en_name]" value="" placeholder="请输入分类英文名称" class="en_category layui-input" >';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '<div class="product">';
        html += '<div class="edit-item">';
        html += '<div class="design-show top">';
        html += '<img src="/static/admin/images/userface1.jpg">';
        html += '</div>';
        html += '<div class="design-item">';
        html += '<h2>请编辑头条商品</h2>';
        html += '<div class="design-content">';
        html += '<div class="layui-form-item">';
        html += '<label class="layui-form-label">上传图片：</label>';
        html += '<div class="layui-input-inline">';
        html += '<div class="thumbBox">';
        html += '<i class="layui-icon layui-icon-add-1"></i>';
        html += '<img  class="layui-upload-img thumbImg">';
        html += '<input type="hidden" value=""  name="cat_product['+new_content_id+'][top_product][big_thumb_img]">';
        html += '</div>';
        html += '<div class="layui-form-mid layui-word-aux">图片尺寸为：750px*360px</div>';
        html += '</div>';
        html += '</div>';
        html += '<div class="layui-form-item">';
        html += '<label class="layui-form-label">链接地址：</label>';
        html += '<div class="layui-input-inline">';
        html += '<input type="hidden" name="cat_product['+new_content_id+'][top_product][id]" value="" >';
        html += '<input type="text" value="" placeholder="请输入链接地址" class="top-product-link layui-input" >';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '<div class="edit-item">';
        html += '<div class="design-show product_list swiper-container">';
        html += '<ul class="swiper-wrapper">';
        for(var j=0;j<product_nums;j++){
            html += '<li class="swiper-slide">';
            html += '<img src="/static/admin/images/userface1.jpg">';
            html += '<span>缩略名称</span>';
            html += '</li>';
        }
        html += '</ul>';
        html += '</div>';
        html += '<div class="design-item">';
        html += '<h2>请编辑列表商品</h2>';
        html += '<div class="design-product">';
        html += '<ul class="product_sort">';
        html += '</ul>';
        html += '<div class="design-add-btn add-product-list">';
        html += '<div class="desing-add-img-text">';
        html += '<i class="layui-icon layui-icon-add-1">请选择添加商品</i>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '<div class="icon-btn active-add-next-btn"><i class="layui-icon layui-icon-add-circle"></i></div>';
        html += '<div class="icon-btn delete-cat-product-item"><i class="layui-icon layui-icon-close"></i></div>';
        html += '</div>';
        $('.category-porduct').append(html);
        myswiper = new Swiper('.swiper-container', {
            slidesPerView: 4.6,
        })
    }
});