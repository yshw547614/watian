layui.config({
    base : "/static/admin/js/"
}).use(['element','carousel','laydate','form','layer','laydate','category','images'],function(){
    var form = layui.form,
        layer =  layui.layer,
        laydate = layui.laydate,
        carousel = layui.carousel,
        category = layui.category,
        images = layui.images,
        element = layui.element;
        $ = layui.jquery;

    var productId = getUrlParam('id'),isUpdate=false;
    if(productId){
        isUpdate = true;
    }

    var options = {
        elem: '#banner',
        width:'100%',
        height:'100%',
        arrow:'none',
        interval: 5000
    };
    var ins = carousel.render(options);
    laydate.render({
        elem: '.sale_start_time', //指定元素
        type: 'datetime'
    });
    $(document).ready(function () {
        if(isUpdate){
            $.get('getOneProduct.html?id='+productId,function (data) {
                setFormData(data);
            })
        }else{
            category.select_option(0,"#category");
            setTemplateId();
        }

    });

    $(".edit-item").on("click",'.design-show',function () {
        $(".design-item").hide();
        $(this).next('.design-item').show();
    });
    $('.thumbBox').on('click',function () {
        var _this = $(this);
        images.select(function(data) {
            _this.find('img').attr('src',data);
            _this.find('input').val(data);
        });

    })

    $('.banner-design').on('click','.change_pic',function () {
        var _this = $(this);
        var li_content_id = $(this).parents('li').data('content-id');
        images.select(function (data) {
            _this.attr('src', data);
            $("#banner div[data-content-id='"+li_content_id+"']").find('img').attr('src',data);
        });

    }).on('click','.add-banner',function () {
        images.select(function(data) {
            addBanner(data);
        },true);


    }).on("click",".item-delete-btn",function () {
        var _this = $(this);
        layer.confirm('确定删除吗？', {icon: 3, title: '提示信息'}, function (index) {
            var order = [];
            _this.parent().siblings('li').each(function () {
                order.push($(this).data('content-id'))
            });
            var html = '<div carousel-item>';
            for (var i in order) {
                html += $("#banner div[data-content-id='" + order[i] + "']").prop('outerHTML');
            }
            html += '</div>';
            $('#banner').empty().append(html);
            ins.reload(options);
            _this.parent().hide(1000);
            setTimeout(function () {
                _this.parent().remove();
            }, 950);
            layer.close(index);
        });
    });
    $('.banner-list').on('mousemove','li',function () {
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
    });
    $('.prduct_cont').on('mousemove','.design-item ul li',function () {
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
    }).on("click",".design-item ul li .item-delete-btn",function () {
        var _this = $(this);
        var content_id = $(this).parent().data('content-id');
        _this.parents('.design-item').prev().find("ul li[data-content-id='"+content_id+"']").remove();
        _this.parent().hide(1000);
        setTimeout(function(){_this.parent().remove();},950);
        layer.close(index);
    }).on('click','.design-item ul li .change_pic',function () {
        var _this = $(this);
        var li_content_id = $(this).parents('li').data('content-id');
        images.select(function (data) {
            _this.attr('src', data);
            _this.parents('.design-item').prev().find('ul li[data-content-id="'+li_content_id+'"] img').attr('src',data);
        });

    });
    $('.product_pics').on('click','.design-add-btn',function () {
        images.select(function(data) {
            addProductPics(data);
        },true);

    })
    $('.product_property').on('click','.design-add-btn',function () {
        images.select(function(data) {
            addProductProperty(data);
        },true);
    });
    form.on('radio(is_on_sale)', function(data){
        if(data.value==2){
            $('.sale_time').show();
        }else{
            $('.sale_time').hide();
        }
    });
    form.on('switch(is_free_shipping)', function(data){
        if(data.elem.checked){
            $('.shipping').hide();
        }else{
            $('.shipping').show();
            setTemplateId();
        }
    });
    form.verify({
        thumb:function (value,item) {
            if(value=='' || value==null){
                return '请选择缩略图';
            }
        },

    });
    form.on('submit(submit)', function(data){
        var postData = data.field;
        postData['topic_img'] = topicImg();
        postData['main_img'] = mainImg();
        postData['property'] = propertyImg();
        if(isUpdate){
            postData['id'] = productId;
        }
        $.post('saveData.html',postData,function (res) {
            console.log(res)
            var index = layer.msg('修改中，请稍候......',{icon: 16,time:false,shade:0.8});
            if(res['state'] == 'success'){
                layer.msg('操作成功');
            }else{
                layer.msg(res.msg);
            }
        });
        return false;
    });
    function isHideShipping(isShow) {
        if(isShow){
            $('.shipping').hide();
        }else{
            $('.shipping').show();
        }
    }
    function isShowUpperShelfTime(isShow) {
        if(isShow){
            $('.sale_time').show();
        }else{
            $('.sale_time').hide();
        }
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
    function setFormData(data) {
        category.select_option(data.category_id,"#category");
        var is_free_shipping = data.is_free_shipping == 1 ? true : false;
        var is_show_upper_shelf_time = data.is_on_sale == 2 ? true : false;
        form.val('product',{
            'name':data.name,
            'stock':data.stock,
            'original_price':data.original_price,
            'price':data.price,
            'thumb_img':data.thumb_img,
            'is_free_shipping':is_free_shipping,
            'template_id':data.template_id,
            'weight':data.weight,
            'volume':data.volume,
            'is_on_sale':data.is_on_sale.toString(),
            'upper_shelf_time':data.upper_shelf_time

        });
        form.render();
        $('.thumbImg').attr('src',data.thumb_img);
        isHideShipping(is_free_shipping);
        isShowUpperShelfTime(is_show_upper_shelf_time);
        setProductAddons();
        setTemplateId(data.template_id);
    }
    function setTemplateId(template_id) {
        $.get('getFreightTemplate.html',function (datas) {
            var html = '';
            for(var i=0;i<datas.length;i++){
                if(template_id == datas[i]['id']){
                    html += '<option value="'+datas[i]['id']+'" selected>'+datas[i]['name']+'</option>';
                }else{
                    html += '<option value="'+datas[i]['id']+'">'+datas[i]['name']+'</option>';
                }

            }
            $('#template_id').append(html);
            form.render();
        })
    }
    function topicImg() {
        var imgStr,imgs = [];
        $('.banner-list li').each(function () {
            var img = $(this).find('img').attr('src');
            imgs.push(img);
        });
        imgStr = imgs.join('###');
        return imgStr;
    }
    function mainImg() {
        var imgStr,imgs = [];
        $('.product_pic_ul li').each(function () {
            var img = $(this).find('img').attr('src');
            imgs.push(img);
        });
        imgStr = imgs.join('###');
        return imgStr;
    }
    function propertyImg() {
        var imgStr,imgs = [];
        $('.product_property_ul li').each(function () {
            var img = $(this).find('img').attr('src');
            imgs.push(img);
        });
        imgStr = imgs.join('###');
        return imgStr;
    }
    function setProductAddons() {
        $.get('getProductAddons.html',{id:productId},function (data) {
            setBanner(data.topic_img);
            setProductPics(data.main_img);
            setProductProperty(data.property);
        })
    }
    function setBanner(data) {
        var imgs = data.split('###');
        addBanner(imgs);
    }
    function setProductPics(data) {
        var imgs = data.split('###');
        addProductPics(imgs);
    }
    function setProductProperty(data) {
        var imgs = data.split('###');
        addProductProperty(imgs);
    }
    function getContent_id(obj) {
        var content_ids = [],max_content_id,content_id;
        obj.each(function (index,item) {
            content_ids.push($(item).data('content-id'))
        })
        content_ids.sort();
        max_content_id = content_ids[content_ids.length - 1];
        content_id = (parseInt(max_content_id)>=0) ? (parseInt(max_content_id)+1) : 0;
        return content_id;
    }
    function addBanner(imgs) {
        var html = '',design_html = '';
        var content_id = getContent_id($('.banner-list li'));
        var start = 0;
        for(var i=0;i<imgs.length;i++) {
            start = content_id + i;
            html += '<div data-content-id="' + start + '"><img src="'+imgs[i]+'"></div>';
            design_html += '<li data-content-id="' + start + '">';
            design_html += '<img src="'+imgs[i]+'" class="change_pic">';
            design_html += '<div class="icon-btn item-delete-btn">';
            design_html += '<i class="layui-icon layui-icon-close"></i>';
            design_html += '</div>';
            design_html += '</li>';
        }
        $('#banner').children('div').append(html);
        $('.banner-list').append(design_html);
        ins.render(options);

    }
    function addProductPics(imgs) {
        var content_id = getContent_id($('.product_pic_ul li'));
        var result = picHtml(content_id,imgs);
        $('.product_pic_show ul').append(result['html']);
        $('.product_pic_design').find('ul').append(result['design_html']);
    }
    function addProductProperty(imgs) {
        var content_id = getContent_id($('.product_property_ul li'));
        var result = picHtml(content_id,imgs);
        $('.product_property_show ul').append(result['html']);
        $('.product_property_design').find('ul').append(result['design_html']);
    }
    function picHtml(content_id,imgs) {
        var result = [];
        var html = '';
        var design_html = '';
        var start = 0;
        for(var i=0;i<imgs.length;i++){
            start = content_id + i;
            html += '<li data-content-id="'+start+'"><img src="'+imgs[i]+'"></li>';
            design_html += '<li data-content-id="'+start+'">';
            design_html += '<img src="'+imgs[i]+'" class="change_pic">';
            design_html += '<div class="icon-btn item-delete-btn">';
            design_html += '<i class="layui-icon layui-icon-close"></i>';
            design_html += '</div>';
            design_html += '</li>';
        }
        result['html'] = html;
        result['design_html'] = design_html;
        return result;
    }
})