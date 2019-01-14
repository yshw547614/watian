layui.define(["form","jquery"],function(exports){
    var form = layui.form,
        $ = layui.jquery,
        Category = {
            select_option:function (category_id,obj) {
                $.get("/admin/category/treecategory.html",function (data) {
                    var count = data.length;
                    var options = '';
                    for(var i=0;i<count;i++){
                        if(data[i]['pid']==0){
                            if(i==0){
                                options += '<optgroup label="'+data[i]['name']+'">';
                            }else{
                                options += '</optgroup>';
                                options += '<optgroup label="'+data[i]['name']+'">';
                            }
                        }else{
                            if(category_id == data[i]['id']){
                                options += '<option value="'+data[i]['id']+'" selected>'+data[i]['name']+'</option>';
                            }else{
                                options += '<option value="'+data[i]['id']+'">'+data[i]['name']+'</option>';
                            }

                        }
                    }
                    options += '</optgroup>';
                    $(obj).append(options);
                    form.render();
                })

            }
        }
    exports("category",Category);
})