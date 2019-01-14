var getArticle;
layui.use(['table','form','laypage','jquery'],function(){
    var form = layui.form,
        layer = parent.layer === undefined ? layui.layer : top.layer,
        laypage = layui.laypage,
        $ = layui.jquery,
        table = layui.table;


    $(document).ready(function () {
        category();
        article();
    });
    form.on('submit(sreach)', function(data){
        var where = data.field;
        article(where);
        return false;
    });
    getArticle = function(){
        var checkStatus,data,article_id;
        checkStatus = table.checkStatus('article');
        data = checkStatus.data[0];
        article_id = data['id'];
        return article_id;
    }
    function category() {
        $.get('/admin/help/getCategory.html',function (data) {
            var count = data.length;
            var options = '';
            for(var i=0;i<count;i++){
                options += '<option value="'+data[i]['id']+'">'+data[i]['title']+'</option>';
            }
            $(".select_category").append(options);
            form.render();
        })
    }
    function article(where) {
        var index = layer.msg('数据加载中......',{icon:16});
        table.render({
            elem: '#list',
            where:where,
            method:'post',
            url : '/admin/help/getList.html',
            page : true,
            limit : 10,
            cols : [[
                {type: "radio", fixed:"left", width:50},
                {field: 'id', title: 'ID', width:60, align:"center",sort: true},
                {field: 'title',title: '标题'}
            ]],
            id:'article',
            done:function () {
                layer.close(index);
            }
        })
    }


});