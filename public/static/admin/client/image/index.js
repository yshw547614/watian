layui.config({
    base : "/static/admin/js/"
}).use(['flow','form','layer','upload','laypage','jquery','element'],function(){
    var form = layui.form,
        layer = parent.layer === undefined ? layui.layer : top.layer,
        upload = layui.upload,
        laypage = layui.laypage,
        $ = layui.jquery;

    $(document).ready(function () {
        var currPage = 1;
        var limit = 30;
        getListData(currPage,limit);
    })
    function getListData(currPage,limit){
        $.get('select.html',
            {
                page:currPage,
                limit:limit
            },
            function (res) {
                var count = res.count;
                var data = res.data;
                var html = '';
                for(var i=0; i<limit; i++){
                    html += '<li>';
                    html += '<img layer-src="'+ data[i].src +'" src="'+ data[i].thumb +'">';
                    html += '<div class="operate">';
                    html += '<div class="check">';
                    html += '<input type="checkbox" name="belle" lay-filter="choose" lay-skin="primary">';
                    html += '</div>';
                    /*html += '<i class="layui-icon img_del">&#xe640;</i>';*/
                    html += '</div>';
                    html += '</li>';
                }
                $("#Images li").remove();
                $("#Images").append(html);
                $("#Images li img").height($("#Images li img").width());
                form.render('checkbox');
                pageinate(count,currPage,limit);
            }
        )
    }
    function pageinate(count,currPage,limit) {
        laypage.render({
            elem: 'page',
            count: count,
            curr:currPage,
            limit:limit,
            jump: function (obj, first) {
                var currPage = obj.curr;
                if (!first) {
                    getListData(currPage,limit);
                }
            }
        });
    }
    //多图片上传
    upload.render({
        elem: '.uploadNewImg',
        url: 'upload.html',
        multiple: true,
        before:function (obj) {
            layer.load();
        },
        allDone: function(obj){
            layer.closeAll('loading');
            layer.msg('成功上传'+obj.successful+'张图片', {
                icon: 1,
                shade: 0.01,
                time: 3000
            });

        },
        done: function (res) {
            getListData(1,30);
        }
    });

    //弹出层
    $("body").on("click","#Images img",function(){
        parent.showImg();
    })

    //删除单张图片
    $("body").on("click",".img_del",function(){
        var _this = $(this);
        layer.confirm('确定删除图片吗？',{icon:3, title:'提示信息'},function(index){
            _this.parents("li").hide(1000);
            setTimeout(function(){_this.parents("li").remove();},950);
            layer.close(index);
        });
    })

    //全选
    form.on('checkbox(selectAll)', function(data){
        var child = $("#Images li input[type='checkbox']");
        child.each(function(index, item){
            item.checked = data.elem.checked;
        });
        form.render('checkbox');
    });

    //通过判断是否全部选中来确定全选按钮是否选中
    form.on("checkbox(choose)",function(data){
        var child = $(data.elem).parents('#Images').find('li input[type="checkbox"]');
        var childChecked = $(data.elem).parents('#Images').find('li input[type="checkbox"]:checked');
        if(childChecked.length == child.length){
            $(data.elem).parents('#Images').siblings("blockquote").find('input#selectAll').get(0).checked = true;
        }else{
            $(data.elem).parents('#Images').siblings("blockquote").find('input#selectAll').get(0).checked = false;
        }
        form.render('checkbox');
    })

    //批量删除
    $(".batchDel").click(function(){
        var $checkbox = $('#Images li input[type="checkbox"]');
        var $checked = $('#Images li input[type="checkbox"]:checked');
        if($checkbox.is(":checked")){
            layer.confirm('确定删除选中的图片？',{icon:3, title:'提示信息'},function(index){
                var index = layer.msg('删除中，请稍候',{icon: 16,time:false,shade:0.8});
                setTimeout(function(){
                    //删除数据
                    $checked.each(function(){
                        $(this).parents("li").hide(1000);
                        setTimeout(function(){$(this).parents("li").remove();},950);
                    })
                    $('#Images li input[type="checkbox"],#selectAll').prop("checked",false);
                    form.render();
                    layer.close(index);
                    layer.msg("删除成功");
                },2000);
            })
        }else{
            layer.msg("请选择需要删除的图片");
        }
    })

})