/**
 * Created by shengwang.yang on 2019/1/18 0018.
 */
layui.use(['form','layer'],function () {
   var $ = layui.jquery,
       form = layui.form;


   form.verify({
       password: [
           /^[\S]{5,12}$/,
           '密码必须6到12位，且不能出现空格'
       ],
       confirm:function (value,item) {
           var password = $('input[name="password"]').val();
           if(value != password){
               return '新密码与确认密码不一致';
           }
       }
   });

    form.on('submit(submit)',function (data) {
        var post = data.field;
        $.post('updatePass.html',post,function (res) {
            if(res.state == 'success'){
                layer.msg('操作成功',{icon:1});
                setTimeout(function () {
                    top.location.href = '/admin/login/login.html';
                },600)

            }else{
                layer.msg(res.msg,{icon:2});
            }
        });
        return false;
    })
});