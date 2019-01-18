/**
 * Created by shengwang.yang on 2019/1/15 0015.
 */
layui.use(['table','element','form','layer'],function () {
    var table = layui.table,
        $ = layui.jquery,
        form = layui.form,
        layer = layui.layer;

    var fold = false;

    $(document).ready(function () {
        loadPage();
    });

    $('.add_btn').on('click',function () {
        var url = 'edit.html',
            title = '添加权限';
        editPage(url,title);
    });

    //列表操作
    $('.ui-table-body').on('click','.page-classify-icon',function () {
        var dataId = $(this).parents('.ui-table-body-item').data('id');
        dataId = dataId+'-';
        if($(this).hasClass('page-classify-icon-fold')){
            $('.ui-table-body .ui-table-body-item[data-id^="'+dataId+'"]').show().find('.page-classify-icon').removeClass('page-classify-icon-fold').addClass('page-classify-icon-open');
            $(this).removeClass('page-classify-icon-fold').addClass('page-classify-icon-open')
        }else{
            $('.ui-table-body .ui-table-body-item[data-id^="'+dataId+'"]').hide();
            $(this).removeClass('page-classify-icon-open').addClass('page-classify-icon-fold')
        }
    }).on('click','.page-classify-add',function () {
        var pid = $(this).data('id');
        var url = 'edit.html?pid='+pid,
            title = '添加权限';
        editPage(url,title);
    }).on('click','.page-option-edit',function () {
        var id = $(this).data('id');
        var url = 'edit.html?id='+id,
            title = '编辑权限';
        editPage(url,title);
    }).on('click','.page-option-del',function () {
        var id = $(this).data('id');
        layer.confirm('确定要删除吗？',{icon:3,title:'提示信息'},function () {
            $.post('delete.html',{id:id},function (res) {
                if(res.state=='success'){
                    layer.msg('操作成功');
                    location.reload();
                }else{
                    layer.msg(res.msg);
                }
            })
        });
    });

    //全部展开、折叠
    $('.all-open-fold').on('click',function () {
        var title = $(this).data('title');
        if(title==='fold'){
            $('.ui-table-body .ui-table-body-item').find('.page-classify-icon').removeClass('page-classify-icon-open').addClass('page-classify-icon-fold');
            $('.ui-table-body .ui-table-body-item[data-id*="-"]').hide();
            $(this).data('title','open');
            $(this).text('全部展开');
        }else{
            $('.ui-table-body .ui-table-body-item').find('.page-classify-icon').removeClass('page-classify-icon-fold').addClass('page-classify-icon-open');
            $('.ui-table-body .ui-table-body-item[data-id*="-"]').show();
            $(this).data('title','fold');
            $(this).text('全部折叠');
        }
    });

    function editPage(url,title,area) {
        var index = layer.open({
            title : [title],
            type : 2,
            area: ['400px', '235px'],
            content : url,
            success : function(layero, index){

            },end: function () {
                $('html').css('overflow','auto');
            }
        });
    }
    function loadPage() {
        var index = layer.msg('数据加载中......',{icon:16,time:false});
        $.get('getList.html',function (data) {
            addCategory(data);
            layer.close(index);
        })
    }

    function addCategory(data) {
        var html = '';
        for(var i=0;i<data.length;i++){

            html += '<div class="ui-table-body-item" data-id="'+data[i]['dataid']+'">';

            html += '<div class="ui-table-list width-auto">';

            if(data[i]['level'] == 1){

                html += '<div class="page-classify page-classify-pl0">';
                html += '<div class="page-classify-icon page-classify-icon-open">-</div>';

            }else if(data[i]['level'] == 2){

                html += '<div class="deep-line page-classify page-classify-pl1">';
                html += '<div class="page-classify-icon page-classify-icon-open">-</div>';

            }else{

                html += '<div class="deep-line page-classify page-classify-pl2">';
            }

            html += '<div class="page-classify-name">'+data[i]['title']+'</div>';

            if(data[i]['level'] != 3){
                html += '<div class="page-classify-add" data-id="'+data[i]['id']+'">+添加权限</div>';
            }
            html += '</div>';
            html += '</div>';
            html += '<div class="ui-table-list width-auto">'+data[i]['name']+'</div>';
            html += '<div class="ui-table-list" style="width: 120px;">';
            html += '<div class="page-option">';
            html += '<div class="page-option-edit" data-level="'+data[i]['id']+'" data-id="'+data[i]['id']+'">编辑</div>';
            html += '<div class="page-option-del" data-level="'+data[i]['id']+'" data-id="'+data[i]['id']+'">删除</div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
        }
        $('.ui-table-body').append(html)
    }
    }
);