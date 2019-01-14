/**
 * Created by shengwang.yang on 2018/10/23 0023.
 */
layui.use(['form','layer','element','table','laytpl'],function () {
    var form = layui.form,
        layer = layui.layer,
        $ = layui.jquery,
        element = layui.element,
        table = layui.table;
    
    $('#province').on('change',function () {
        get_city(this,0,'/admin/freight/getregion/level/2.html');
    });
    $('#city').on('change',function () {
        get_area(this,'/admin/freight/getregion/level/3.html');
    });
    $('.add-area').on('click',function () {
       addArea();
    });

    //  添加配送区域
    function addArea(){
        //
        var province = $("#province").val(); // 省份
        var city = $("#city").val();        // 城市
        var district = $("#district").val(); // 县镇
        var text = '';  // 中文文本
        var tpl = ''; // 输入框 html
        var is_set = 0; // 是否已经设置了

        // 设置 县镇
        if(district > 0){
            text = $("#district").find('option:selected').text();
            tpl = '<li><label><input class="checkbox" type="checkbox" checked name="area_list[]" data-name="'+text+'" value="'+district+'">'+text+'</label></li>';
            is_set = district; // 街道设置了不再设置市
        }
        // 如果县镇没设置 就获取城市
        if(is_set == 0 && city > 0){
            text = $("#city").find('option:selected').text();
            tpl = '<li><label><input class="checkbox" type="checkbox" checked name="area_list[]" data-name="'+text+'"  value="'+city+'">'+text+'</label></li>';
            is_set = city;  // 市区设置了不再设省份

        }
        // 如果城市没设置  就获取省份
        if(is_set == 0 && province > 0){
            text = $("#province").find('option:selected').text();
            tpl = '<li><label><input class="checkbox" type="checkbox" checked name="area_list[]" data-name="'+text+'"  value="'+province+'">'+text+'</label></li>';
            is_set = province;

        }

        var obj = $("input[class='checkbox']"); // 已经设置好的复选框拿出来
        var exist = 0;  // 表示下拉框选择的 是否已经存在于复选框中
        $(obj).each(function(){
            if($(this).val() == is_set){  //当前下拉框的如果已经存在于 复选框 中
                layer.alert('已经存在该区域', {icon: 2});  // alert("已经存在该区域");
                exist = 1; // 标识已经存在
            }
        });
        if(!exist)
            $('#area_list').append(tpl); // 不存在就追加进 去
    }

    /**
     * 获取城市
     * @param t  省份select对象
     * @param city
     * @param district
     * @param twon
     */
    function get_city(t,city,url_pre,district,twon){
        var parent_id = $(t).val();
        if(!parent_id > 0){
            return;
        }
        var city_id = 'city';
        if(typeof(city) != 'undefined' && city != ''){
            city_id = city;
        }
        var district_id = 'district';
        if(typeof(district) != 'undefined' && district != ''){
            district_id = district;
        }
        $('#'+district_id).empty();
        var url = url_pre+'/parent_id/'+parent_id;
        $.ajax({
            type : "GET",
            url  : url,
            error: function(request) {
                alert("服务器繁忙, 请联系管理员!");
                return false;
            },
            success: function(v) {
                v = '<option value="0">选择城市</option>'+ v;
                $('#'+city_id).empty().html(v);
            }
        });
    }
    /**
     * 获取地区
     * @param t  城市select对象
     * @param district
     * @param twon
     */
    function get_area(t,url_pre,district,twon){
        var parent_id = $(t).val();
        if(!parent_id > 0){
            return;
        }
        var district_id = 'district';
        if(typeof(district) != 'undefined' && district != ''){
            district_id = district;
        }
        var twon_id = 'twon';
        if(typeof(twon) != 'undefined' && twon != ''){
            twon_id = twon;
        }
        $('#'+district_id).empty().css('display','inline');
        $('#'+twon_id).empty().css('display','none');
        var url = url_pre+'/parent_id/'+parent_id;
        $.ajax({
            type : "GET",
            url  : url,
            error: function(request) {
                alert("服务器繁忙, 请联系管理员!");
                return false;
            },
            success: function(v) {
                v = '<option>选择区域</option>'+ v;
                $('#'+district_id).empty().html(v);
            }
        });
    }
})