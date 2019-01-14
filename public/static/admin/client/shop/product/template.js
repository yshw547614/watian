layui.use(['form'],function(){
    var form = layui.form,$ = layui.jquery;

    $(document).ready(function () {
        setTemplateId();
    });
    function setTemplateId() {
        $.get('/admin/product/getFreightTemplate.html',function (datas) {
            var html = '';
            for(var i=0;i<datas.length;i++){
                html += '<option value="'+datas[i]['id']+'">'+datas[i]['name']+'</option>';
            }
            $('#template').append(html);
            form.render();
        })
    }
});