/**
 * Created by shengwang.yang on 2019/1/18 0018.
 */
layui.use(['table','layer'],function () {
    var $ = layui.jquery,
        table = layui.table,
        layer = layui.layer;
    
    $(document).ready(function () {
        getData();
    });
    
    function getData() {
        $.get('getAdmin.html',function (data) {
            var rules = data.rules,
                html = '';

            html +='<tr>';
            html +='<td>用户名</td>';
            html +='<td>'+data.name+'</td>';
            html +='</tr>';
            html +='<tr>';
            html +='<td>用户组</td>';
            html +='<td>'+data.group_name+'</td>';
            html +='</tr>';

            html +='<tr>';
            html +='<td>权&nbsp;&nbsp;限</td>';
            html +='<td>';
            html +='<ul>';
            for(var i=0;i<rules.length;i++){
                html +='<li>'+rules[i]['_title']+rules[i]['title']+'</li>';
            }

            html +='</ul>';
            html +='</td>';
            html +='</tr>';

            $('.detail tbody').append(html);
        })
    }
});