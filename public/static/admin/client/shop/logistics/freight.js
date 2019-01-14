/**
 * Created by shengwang.yang on 2018/10/23 0023.
 */
layui.use(['form','layer','element','table','laytpl'],function () {
    var form = layui.form,
        layer = layui.layer,
        $ = layui.jquery,
        element = layui.element,
        table = layui.table;

    var type,unit = '件',id = getUrlParam('id'),isUpdate = false;
    if(id){
        isUpdate = true;
    }
    $(document).ready(function () {
        if(isUpdate){
            setTemplate();
            setConfig();
        }
    });

    $(".freight").on('click','.btn_del',function () {
        var _this = $(this);
        layer.confirm('确定删除吗？',{icon:6,title:'提示信息'},function (index) {
            _this.parents('tr').remove();
            layer.close(index)
        })

    })
    $('.arae-div').on("click", '.select_area', function (e) {
        $('.select_area').removeClass('select_area_focus');
        $(this).addClass('select_area_focus');
        layer.open({
            type: 2,
            title: '选择地区',
            shadeClose: true,
            shade: 0.2,
            area: ['540px', '400px'],
            content: '/admin/freight/area.html',
            success : function (layero, index) {
                var body = layer.getChildFrame('body', index);
                body.find(".confirm").click(function () {
                    var input = body.find("input[type='checkbox']:checked");
                    if (input.length == 0) {
                        layer.alert('请添加区域', {icon: 2});
                        return false;
                    }
                    var area_list = [];
                    input.each(function(i,o){
                        var area_id = $(this).attr("value");
                        var area_name = $(this).data("name");
                        var area = new Area(area_id,area_name);
                        area_list.push(area);
                    });
                    call_back(area_list);
                })

            }
        });
    });
    function getUrlParam(paramName)
    {
        var query = window.location.search.substring(1);
        var vars = query.split("&");
        for (var i=0;i<vars.length;i++) {
            var pair = vars[i].split("=");
            if(pair[0] == paramName){return pair[1];}
        }
        return(false);
    }
    //地区对象
    function Area(id, name) {
        this.id = id;
        this.name = name;
    }
    form.on('switch(is_enable_default)', function(data){
        if(data.elem.checked){
            addConfig(true);
        }else{
            $("#tr_defualt").remove();
        }
    });
    form.on('radio(type)',function (data) {
        initType();
    })
    form.on('submit(submit)',function (data) {
        var post = data.field;
        if(isUpdate){
            post['id'] = id;
        }
        console.log(post)
        var index = layer.msg('数据更新中......',{icon:16,time:0});
        $.post('saveData.html',post,function (res) {
            console.log(res)
            layer.close(index);
            if(res.state=='success'){
                layer.msg('操作成功');
            }else{
                layer.msg(res.msg);
            }
        })
        return false;
    })

    $("#btn_add").click(function () {
        addConfig(false);
    });
    function call_back(area_list) {
        var area_list_name = '';
        var area_list_id = '';
        $.each(area_list, function (index, item) {
            area_list_name += item.name + ',';
            area_list_id += item.id + ',';
        });
        var area_focus = $('.select_area_focus');
        if(area_list_id.length > 1){
            area_list_id = area_list_id.substr(0,area_list_id.length-1);
            area_list_name = area_list_name.substr(0,area_list_name.length-1);
        }
        area_focus.val(area_list_name);
        area_focus.parent().find('.area_ids').val(area_list_id);
        layer.closeAll('iframe');
    }


    function initType(){
        var config_table = $('#config_table');
        if(parseInt(type) >= 0){
            config_table.show();
        }
        var first_unit = $('.first_unit');
        var continue_unit = $('.continue_unit');
        var first_unit_span = $('.first_unit_span');
        var continue_unit_span = $('.continue_unit_span');
        type = $("input[name='type']:checked").val();
        switch(parseInt(type))
        {
            case 0:
                unit = "件";
                first_unit.html('首件');
                continue_unit.html('续件');
                break;
            case 1:
                unit = "克";
                first_unit.html('首重(g)');
                continue_unit.html('续重(g)');
                break;
            case 2:
                unit = "m³";
                first_unit.html('首体积(m³)');
                continue_unit.html('续体积(m³)');
                break;
        }
        first_unit_span.html(unit);
        continue_unit_span.html(unit);
    }

    function setTemplate() {
        $.get('getTemplate.html',{id:id},function (data) {
            var is_enable_default = (data.is_enable_default==1) ? true : false;
            form.val('template',{
                'name':data.name,
                'is_enable_default':is_enable_default,
                'type':data.type.toString()
            });
            initType();
            form.render();
        })


    }
    function setConfig(data) {
        $.get('getConfig.html',{template_id:id},function (data) {
            var html = '',isDefualt=false;
            for(var i=0;i<data.length;i++){
                if(data[i]['is_default'])
                {
                    html += '<tr id="tr_defualt" data-id="'+i+'">';
                }else{
                    html += '<tr data-id="'+i+'">';
                }
                html += '<td>';
                html += '<div class="layui-input-inline" style="width: 200px;">';
                if(data[i]['is_default']){
                    html += '<input class="layui-input" name="" value="中国" type="text" style="background: #fff;" readonly>';
                    html += '<input name="template['+i+'][is_default]" value="1" type="hidden">';
                }else{
                    html += '<input class="select_area layui-input" value="'+data[i]['area_names']+'" type="text" style="background: #fff;" readonly>';
                    html += '<input name="template['+i+'][is_default]" value="0" type="hidden">';

                }
                html += '<input name="template['+i+'][config_id]" value="'+data[i]['id']+'" type="hidden">';
                html += '<input name="template['+i+'][area_ids]" class="area_ids" value="'+data[i]['area_ids']+'" type="hidden">';
                html += '</div>';
                html += '</td>';
                html += '<td>';
                html += '<div class="layui-input-inline" style="width: 80px;">';
                html += '<input type="text"  name="template['+i+'][first_unit]" value="'+data[i]['first_unit']+'" class="layui-input" required />';
                html += '</div>';
                html += '<span class="first_unit_span"></span>';
                html += '</td>';
                html += '<td>';
                html += '<div class="layui-input-inline" style="width: 80px;">';
                html += '<input type="text" name="template['+i+'][first_money]" value="'+data[i]['first_money']+'" class="layui-input" required />';
                html += '</div>';
                html += '<span>元</span>';
                html += '</td>';
                html += '<td>';
                html += '<div class="layui-input-inline" style="width: 80px;">';
                html += '<input type="text" name="template['+i+'][continue_unit]" value="'+data[i]['continue_unit']+'" class="layui-input" required />';
                html += '</div>';
                html += '<span class="continue_unit_span"></span>';
                html += '</td>';
                html += '<td>';
                html += '<div class="layui-input-inline" style="width: 80px;">';
                html += '<input type="text"  name="template['+i+'][continue_money]" value="'+data[i]['continue_money']+'" class="layui-input" required />';
                html += '</div>';
                html += '<span>元</span>';
                html += '</td>';
                if(data[i]['is_default']){
                    html += '<td>&nbsp;</td>';
                }else{
                    html += '<td>';
                    html += '<button class="layui-btn layui-btn-xs layui-btn-danger btn_del"  type="button">';
                    html += '<i class="layui-icon layui-icon-close-fill"></i> 删除</button>';
                    html += '</td>';
                }
                html += '</tr>';
            }
            $(".freight").append(html);
        })

    }
    function addConfig(isDefualt) {
        var data_id,data_ids = [],max_data_id,html = '';
        $('.freight tr:gt(1)').each(function (index,item) {
            data_ids.push($(item).data('id'));
        });
        data_ids.sort();
        max_data_id = data_ids[data_ids.length-1];
        data_id = (parseInt(max_data_id)>=0) ? (parseInt(max_data_id)+1) :0;
        if(isDefualt)
        {
            html += '<tr id="tr_defualt" data-id="'+data_id+'">';
        }else{
            html += '<tr data-id="'+data_id+'">';
        }
        html += '<td>';
        html += '<div class="layui-input-inline" style="width: 200px;">';
        if(isDefualt){
            html += '<input class="layui-input" name="" value="中国" type="text" style="background: #fff;" readonly>';
            html += '<input name="template['+data_id+'][is_default]" value="1" type="hidden">';
        }else{
            html += '<input class="select_area layui-input" value="" type="text" style="background: #fff;" readonly>';
            html += '<input name="template['+data_id+'][is_default]" value="0" type="hidden">';
        }
        html += '<input name="template['+data_id+'][area_ids]" class="area_ids" value="0" type="hidden">';
        html += '</div>';
        html += '</td>';
        html += '<td>';
        html += '<div class="layui-input-inline" style="width: 80px;">';
        html += '<input type="text" name="template['+data_id+'][first_unit]" class="layui-input" required/>';
        html += '</div>';
        html += '<span class="first_unit_span"></span>';
        html += '</td>';
        html += '<td>';
        html += '<div class="layui-input-inline" style="width: 80px;">';
        html += '<input type="text" name="template['+data_id+'][first_money]" class="layui-input" required />';
        html += '</div>';
        html += '<span>元</span>';
        html += '</td>';
        html += '<td>';
        html += '<div class="layui-input-inline" style="width: 80px;">';
        html += '<input type="text" name="template['+data_id+'][continue_unit]" class="layui-input" required />';
        html += '</div>';
        html += '<span class="continue_unit_span"></span>';
        html += '</td>';
        html += '<td>';
        html += '<div class="layui-input-inline" style="width: 80px;">';
        html += '<input type="text" name="template['+data_id+'][continue_money]" class="layui-input" required/>';
        html += '</div>';
        html += '<span>元</span>';
        html += '</td>';
        if(isDefualt){
            html += '<td>&nbsp;</td>';
        }else{
            html += '<td>';
            html += '<button class="layui-btn layui-btn-xs layui-btn-danger btn_del"  type="button">';
            html += '<i class="layui-icon layui-icon-close-fill"></i> 删除</button>';
            html += '</td>';
        }
        html += '</tr>';
        if(isDefualt){
            $("#table_th").after(html);
        }else{
            $(".freight").append(html);
        }

        initType();
    }
})