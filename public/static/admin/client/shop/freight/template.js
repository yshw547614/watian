
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

    $('.addTemplate').on('click',function () {
        var title = '添加运费模板',
            url = 'freight.html';
        editTemplate(title,url)
    });
    $('.freight_templet').on('click','.layui-icon-edit',function () {
        var id,title,url;
        id = $(this).parent().data('id');
        title = '编辑包邮规则';
        url = 'freight.html?id='+id;
        editTemplate(title,url);
    });

    //添加、编辑规则
    function editTemplate(title,url){
        var index = layer.open({
            title : [title,'background-color:#009688;color:#fff;font-size:16px;'],
            type : 2,
            content : url,
            success : function(layero, index){

            },end: function () {
                $(window).unbind("resize");
                location.reload();
            }
        })
        layer.full(index);
        $(window).on("resize",function(){
            layer.full(index);
        })
    }

})