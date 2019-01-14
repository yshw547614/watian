layui.define(["form","jquery"],function(exports){
    var form = layui.form,
        $ = layui.jquery,
        Product = {
            select:function (selectType,category_id,callback) {
                layer.open({
                    title : "请选择商品",
                    type : 2,
                    maxmin: 1,
                    area : ["738px","400px"],
                    content : "/admin/product/selectPage.html?type="+selectType+"&&category_id="+category_id,
                    success : function (layero, index) {
                        var body = layer.getChildFrame('body', index);
                        var iframeWin = window[layero.find('iframe')[0]['name']];
                        body.find(".confirm_btn").click(function () {
                            var product = iframeWin.getProduct();
                            callback && callback(product);
                        })
                    }
                });
            }
        }
    exports("product",Product);
})