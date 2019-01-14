layui.define(["form","jquery"],function(exports){
    var form = layui.form,
        $ = layui.jquery,
        Help = {
            select:function (callback) {
                layer.open({
                    title : "帮助文档",
                    type : 2,
                    maxmin: 1,
                    area : ["706px","400px"],
                    content : "/admin/help/select.html",
                    success : function (layero, index) {
                        var body = layer.getChildFrame('body', index);
                        var iframeWin = window[layero.find('iframe')[0]['name']];
                        body.find(".confirm_btn").click(function () {
                            var article_id = iframeWin.getArticle();
                            var link = '/pages/shop/help/detail?id=' + article_id;
                            callback && callback(link);
                            layer.closeAll();
                        })
                    }
                });

            }
        }
    exports("help",Help);
})