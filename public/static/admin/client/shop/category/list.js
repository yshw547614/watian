layui.use(['form','layer','table','jquery'],function(){
    var form = layui.form,
        layer = layui.layer,
        $ = layui.jquery,
        table = layui.table;

    $(document).ready(function () {
        getCategories();
    });

    $(".ui-table-body").on("click",'.js-table-btn-small-change',function(e){

        var _this = $(this);
        _this.parents('.div-change').hide().next().show();

        $(document).one("click", function(){
            $('.div-change').show().next().hide();
        });

        e.stopPropagation();
    }).on('click','.ui-input',function (e) {
        e.stopPropagation();
    }).on('click','.js-table-btn-small-save',function () {
        var _this = $(this),
            category_id = _this.data('id'),
            rank = _this.prev().val(),
            index = layer.msg('数据修改中......',{icon:16,time:0})

        $.post('updateRank.html',{category_id:category_id,rank:rank},function (data) {
            layer.close(index);
            if(data.state==='success'){
                layer.msg('数据已更新',{icon:1});
                _this.parents('.div-save').prev().find('.page-classify-input').text(rank)
            }else{
                layer.msg(data.msg,{icon:2})
            }
        })
    }).on('click','.page-classify-icon',function () {
        if($(this).hasClass('page-classify-icon-open')){
            $(this).parents('.parent-item').nextUntil('.parent-item').hide();
            $(this).removeClass('page-classify-icon-open').addClass('page-classify-icon-fold')
        }else{
            $(this).parents('.parent-item').nextUntil('.parent-item').show();
            $(this).removeClass('page-classify-icon-fold').addClass('page-classify-icon-open')
        }
    });

    $('.all-open-fold').on('click',function () {
        var title = $(this).data('title');
        if(title==='fold'){
            $('.child-item').show();
            $('.parent-item').find('.page-classify-icon').removeClass('page-classify-icon-fold').addClass('page-classify-icon-open')
            $(this).data('title','open');
            $(this).text('全部折叠');
        }else{
            $('.child-item').hide();
            $('.parent-item').find('.page-classify-icon').removeClass('page-classify-icon-open').addClass('page-classify-icon-fold')
            $(this).data('title','fold');
            $(this).text('全部展开');
        }
    });
    $('.add_category').on('click',function () {
        var title = '添加商品分类',url = '/admin/category/topCategory.html';
        editTopCategory(title,url);
    });
    $('body').on('click','.page-classify-add',function () {
        var parent_id = $(this).parents('.ui-table-body-item').data('id');
        var title = '添加商品分类',url = '/admin/category/childCategory.html?parent_id='+parent_id;
        editChildCategory(title,url)
    });
    $('.page-goods-classify-table').on('click','.page-option-edit',function () {
        var title,url;
        var type = $(this).parents('.ui-table-body-item').data('type');
        var id = $(this).parents('.ui-table-body-item').data('id');
        if(type==='parent'){
            title = '编辑商品分类';
            url = '/admin/category/topCategory.html?id='+id;
            editTopCategory(title,url)
        }else{
            title = '编辑商品分类';
            url = '/admin/category/childCategory.html?id='+id;
            editChildCategory(title,url)
        }
    }).on('click','.page-option-del',function () {
        layer.confirm('确定要删除吗？',{icon:3,title:'提示信息'},function () {
            var categoryId = $(this).parents('.ui-table-body-item').data('id');
            $.post('delete.html',{id:categoryId},function (res) {
                if(res.state=='success'){
                    layer.msg('操作成功');
                    location.reload();
                }else{
                    layer.msg(res.msg);
                }
            })
        })

    });

    function editTopCategory(title,url) {
        layer.open({
            title:title,
            type:2,
            area: ['400px', '235px'],
            content:url,
            success:function () {

            }

        })
    }
    function editChildCategory(title,url) {

        var index = layer.open({
            title : [title,'background-color:#009688;color:#fff;font-size:16px;'],
            type : 2,
            content : url,
            success : function(layero, index){
                $('html').css('overflow','hidden');

            },end: function () {
                $(window).unbind("resize");
                $('html').css('overflow','auto');
                //location.reload();
            }
        });
        layer.full(index);
        $(window).on("resize",function(){
            layer.full(index);
        })
    }
    function getCategories() {
        var index = layer.msg('数据加载中......',{icon:16,time:false});
        $.get('getList.html',function (data) {
            addCategory(data);
            layer.close(index);
        })
    }
    function addCategory(data) {
        var html = '';
        for(var i=0;i<data.length;i++){
            var isTopCategory = data[i]['pid'] === 0 ? true :false;
            if(isTopCategory){
                html += '<div class="ui-table-body-item parent-item" data-type="parent" data-id="'+data[i]['id']+'">';
            }else{
                html += '<div class="ui-table-body-item child-item" data-type="child" data-id="'+data[i]['id']+'">';
            }
            html += '<div class="ui-table-list div-change" style="width: 300px;">';
            html += '<div class="ui-table-small-change-text" style="display: inline">';
            if(isTopCategory){
                html += '<div class=" page-classify-input page-classify-ml0">'+data[i]['rank']+'</div>';
            }else{
                html += '<div class="deep-line page-classify-input page-classify-ml1">'+data[i]['rank']+'</div>';
            }
            html += '</div>';
            html += '&nbsp;&nbsp;';
            html += '<a class="ui-table-btn-small-change js-table-btn-small-change" href="javascript:;">修改</a>';
            html += '</div>';
            html += '<div class="ui-table-list div-save" style="width: 300px;display: none">';
            html += '<input maxlength="" class="ui-input w100" type="number" value="'+data[i]['rank']+'">';
            html += '&nbsp;&nbsp;<a data-id="'+data[i]['id']+'" class="js-table-btn-small-save" href="javascript:;">保存</a>';
            html += '</div>';
            html += '<div class="ui-table-list width-auto">';
            if(isTopCategory){
                html += '<div class="page-classify page-classify-pl0">';
                html += '<div class="page-classify-icon page-classify-icon-fold">-</div>';
            }else{
                html += '<div class="deep-line page-classify page-classify-pl1">';
            }
            html += '<div class="page-classify-name">'+data[i]['name']+'</div>';
            if(isTopCategory){
                html += '<div class="page-classify-add">+添加子分类</div>';
            }
            html += '</div>';
            html += '</div>';
            if(isTopCategory) {
                html += '<div class="ui-table-list width-auto"></div>';
            }else{
                html += '<div class="ui-table-list width-auto"><img class="page-img" src="'+data[i]['topic_img']+'"></div>';
            }
            html += '<div class="ui-table-list" style="width: 120px;">';
            html += '<div class="page-option">';
            html += '<div class="page-option-edit">编辑</div>';
            html += '<div class="page-option-del">删除</div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
        }
        $('.ui-table-body').append(html)
    }

})