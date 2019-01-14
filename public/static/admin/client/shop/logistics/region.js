/**
 * Created by shengwang.yang on 2018/10/23 0023.
 */
layui.use(['form','layer','element','laydate','table','laytpl'],function () {
    var form = layui.form,
        layer = layui.layer,
        $ = layui.jquery,
        element = layui.element,
        table = layui.table;

    var TimeFn = null;

    $(document).ready(function () {
        getRegion('#province',{id:0},'省份','province');
    });

    //监听行单击事件（单击事件为：rowDouble）
    table.on('row(province)', function(obj){
        var data = obj.data;
        var region_id = data.id?data.id:-1;
        clearTimeout(TimeFn);
        TimeFn = setTimeout(function(){
            getRegion('#city',{id:region_id},'城市','city');
            obj.tr.addClass('layui-table-click').siblings().removeClass('layui-table-click');
        },300);


    });

    table.on('row(city)', function(obj){
        var data = obj.data;
        var region_id = data.id?data.id:-1;
        clearTimeout(TimeFn);
        TimeFn = setTimeout(function(){
            getRegion('#country',{id:region_id},'地区','country');
            obj.tr.addClass('layui-table-click').siblings().removeClass('layui-table-click');
        },300);

    });
    //监听行双击事件
    table.on('rowDouble(city)', function(obj){
        clearTimeout(TimeFn);
        var post = obj.data;
        var region_name = post.name != '添加城市'?post.name:'请输入城市名称';
        var title = post.name != '添加城市'?'修改城市名称':'添加城市';
        editRegion(post,region_name,title);
    });
    //监听行双击事件
    table.on('rowDouble(country)', function(obj){
        clearTimeout(TimeFn);
        var post = obj.data;
        var region_name = post.name != '添加地区'?post.name:'请输入地区名称';
        var title = post.name != '添加地区'?'修改地区名称':'添加地区';
        editRegion(post,region_name,title);
    });
    function editRegion(post,region_name,title) {
        layer.prompt({
            btn: ['确认', '取消', '删除'],
            title:title,
            maxlength: 30,
            value: region_name,
            btn3:function(index, layero){
                layer.confirm('确认删除吗',{icon:3,title:'提示信息'},function (index) {
                    $.post('delete.html',{id:post.id},function (res) {
                        layer.close(index);
                        if(res.state=='success'){
                            layer.msg('操作成功',{icon:1})
                            if(post.level==2){
                                getRegion('#city',{id:post['parent_id']},'城市','city');
                            }else{
                                getRegion('#country',{id:post['parent_id']},'地区','country');
                            }
                        }else{
                            layer.msg(res.msg,{icon:2});
                        }
                    })
                })
            }

        },function (value, index) {
            post.name = value;
            $.post('saveData.html',post,function (res) {
                layer.close(index);
                if(res.state=='success'){
                    layer.msg('操作成功',{icon:1})
                    if(post.level==2){
                        getRegion('#city',{id:post['parent_id']},'城市','city');
                    }else{
                        getRegion('#country',{id:post['parent_id']},'地区','country');
                    }
                }else{
                    layer.msg(res.msg,{icon:2});
                }
            })
        })
    }
    function getRegion(region,condition,title,id) {
        var index = layer.msg('数据加载中......',{icon:16,time:0});
        condition['level'] = id;
        table.render({
            elem: region,
            url: 'getRegion.html',
            width : 200,
            where:condition,
            id:id,
            cols : [[
                {field: 'name', title: title,width:198,align:'center'}
            ]],
            done: function(res, curr, count){
                console.log(res)
                layer.close(index);
                if(res.data){
                    var data = res.data[0];
                    if(id=='province'){
                        getRegion('#city',{id:data.id},'城市','city');
                    }
                    if(id=='city'){
                        if(data){
                            getRegion('#country',{id:data.id},'地区','country');
                        }else{
                            getRegion('#country',{id:-1},'地区','country');
                        }

                    }
                }

            }
        });

    }




})