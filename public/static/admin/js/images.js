layui.define(["form","jquery"],function(exports){
    var form = layui.form,
        $ = layui.jquery,
        layer = layui.layer,
        Images = {
            select:function (callback,type) {
                var imgSrc;
                layer.open({
                    title : "选择图片",
                    type : 2,
                    maxmin:1,
                    area : ["680px","400px"],
                    content : "/admin/image/index.html",
                    success : function (layero, index) {
                        var body = layer.getChildFrame('body', index);
                        body.find(".confirm").click(function () {
                            var checkbox;
                            var data=[];
                            if(type){
                                checkbox = body.find("#Images li input[type='checkbox']:checked");
                                checkbox.each(function () {
                                    var imgSrc = $(this).parents('li').find('img').attr('src');
                                    data.push(imgSrc)
                                })
                            }else{
                                checkbox = body.find("#Images li input[type='checkbox']:checked").first();
                                data = checkbox.parents('li').find('img').attr('src');
                            }
                            layer.close(index);
                            callback && callback(data);
                        })

                    }
                });

            }
        }
    exports("images",Images);
})