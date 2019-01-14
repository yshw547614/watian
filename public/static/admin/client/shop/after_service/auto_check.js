/**
 * Created by shengwang.yang on 2018/10/23 0023.
 */
layui.use(['form','layer','element','laydate','table','laytpl'],function () {
    var form = layui.form,
        layer = layui.layer,
        $ = layui.jquery,
        element = layui.element,
        table = layui.table;

        $(document).ready(function () {
            $.get('getReturnReason.html',function (data) {
                var html = '';
                for(var i=0;i<data.length;i++){
                    if(data[i]['is_checked']){
                        html += '<input type="checkbox" name="reason['+data[i]['reason_num']+']" title="'+data[i]['title']+'" checked>';
                    }else{
                        html += '<input type="checkbox" name="reason['+data[i]['reason_num']+']" title="'+data[i]['title']+'">';
                    }
                }
                $('.reasons').append(html);
                form.render();
            })
        });
        form.on('submit(submit)',function (data) {
            var post = data.field;
            $.post('saveReturnSet.html',post,function (res) {
                if(res.state=='success'){
                    layer.msg('操作成功');
                }else{
                    layer.msg(res.msg);
                }
            });
            return false;
        })

})
