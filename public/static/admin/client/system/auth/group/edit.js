/**
 * Created by shengwang.yang on 2019/1/16 0016.
 */
layui.use(['form','table','element','layer'],function () {
    var form = layui.form,
        table = layui.table,
        layer = layui.layer,
        $ = layui.jquery;

    var id = getUrlParam('id'),
        rule_str = getUrlParam('rule_str'),
        tree = null;
    
    $(document).ready(function () {
        if(id){
            $.get('getOneData.html',{id:id},function (data) {
                var flag = data.status==1?true:false;
                form.val('form',{
                    'title':data.title,
                    'status':flag
                });

                setRules(data.rules);
            })
        }else{
            setRules();
        }
    });


    form.on('submit(submit)',function (data) {

       var post = data.field;
       if(id){
           post['id'] = id;
       }
       post['rules'] = setCheckBox();

       $.post('saveData.html',post,function (res) {
           console.log(res);
            if(res.state == 'success'){
                layer.msg('操作成功',{icon:1})
            }else{
                layer.msg(res.msg,{icon:2})
            }
       });
       return false;
    });

    function setRules(ruleStr) {
        $.get('getRules.html',{rule_str:ruleStr},function (data) {
            var obj = new layuiXtree({
                elem: 'xtree',
                form: form,
                data: data
            });
            setTree(obj)
        })
    }
    function setTree(obj) {
        tree = obj;
    }
    function setCheckBox() {
        var arr = [],
            rules = '',
            data = tree.GetChecked();
        for (var i = 0; i < data.length; i++) {
            arr.push(data[i].value);
        }
        rules = arr.join(',');
        return rules;
    }
    function getUrlParam(paramName){
        var query = window.location.search.substring(1);
        var vars = query.split("&");
        for (var i=0;i<vars.length;i++) {
            var pair = vars[i].split("=");
            if(pair[0] == paramName){return pair[1];}
        }
        return(false);
    }
});