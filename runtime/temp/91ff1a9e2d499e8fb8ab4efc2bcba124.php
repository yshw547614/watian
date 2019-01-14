<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:79:"D:\phpweb\watian\webserver\public/../application/admin\view\product\select.html";i:1538468653;}*/ ?>
<link href="/static/admin/css/admin.css" rel="stylesheet" type="text/css">
<link href="/static/admin/css/pintuer.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/static/admin/js/jquery.js"></script>
<style>
    body{ font-size: 12px; padding:5px;}
    .table th,.table td{ font-size: 12px;vertical-align: middle; text-align: center;}
    .table th{ border-bottom: 1px solid #ddd;}
</style>
<div class="panel admin-panel">
    <div class="panel-head">
        <select name="category" style="padding:5px 15px; border:1px solid #ddd;">
            <option value="0">请选择类目</option>
            <?php if(is_array($categories) || $categories instanceof \think\Collection || $categories instanceof \think\Paginator): $i = 0; $__LIST__ = $categories;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$category): $mod = ($i % 2 );++$i;?>
            <option value="<?php echo $category['id']; ?>"><?php echo $category['_title']; ?><?php echo $category['name']; ?></option>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
    </div>

    <table class="table table-hover product_list">
        <tr>
            <th width="60"><input type="checkbox" id="checkall" value=""/>全选</th>
            <th>商品货号</th>
            <th>缩略图</th>
            <th>价格</th>
            <th>库存</th>
            <th>上架</th>
            <th>包邮</th>
        </tr>
        <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?>
        <tr>
            <td><input type="checkbox" name="product[]" value="<?php echo $item['id']; ?>"/></td>
            <td><?php echo $item['product_sn']; ?></td>
            <td><img src="<?php echo $item['thumb_img']; ?>" style="width: 40px; height: 40px;"></td>
            <td><?php echo $item['price']; ?></td>
            <td><?php echo $item['stock']; ?></td>
            <td><?php echo $item['is_on_sale']; ?></td>
            <td><?php echo $item['is_free_shipping']; ?></td>
        </tr>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </table>
    <div class="field" style="float:right;margin:10px 0;">
        <button onclick="confirm();"  class="button border-main icon-check-square-o"> 确定</button>
    </div>
</div>
<script>
    function confirm(){
        var input = $("input[name^='product']:checked");
        if (input.length == 0) {
            layer.alert('请添加商品', {icon: 2});
            return false;
        }
        var product_list = [];
        input.each(function(i,o){
            var product_id = $(this).attr("value");
            product_list.push(product_id);
        })
        window.parent.call_back_product(product_list);
    }
    $(document).ready(function() {
        $("#checkall").click(function(){
            var that = this;
            if(that.checked){
                $("input[name='product[]']").each(function(){
                    this.checked = true;
                });
            }else{
                $("input[name='product[]']").each(function(){
                    this.checked = false;
                });
            }

        })
        $("select[name='category']").change(function () {
            var categoryId = $("select[name='category']").find("option:selected").val();
            $.post(
                "<?php echo url('select'); ?>",
                {categoryId:categoryId},
                function (res) {
                    var table = '';
                    $.each(res,function (i,row) {
                        table += '<tr>';
                        table += '<td><input type="checkbox" name="product[]" value="'+row.id+'"/></td>';
                        table += '<td>'+row.product_sn+'</td>';
                        table += '<td><img src="'+row.thumb_img+'" style="width: 40px; height: 40px;"></td>';
                        table += '<td>'+row.price+'</td>';
                        table += '<td>'+row.stock+'</td>';
                        table += '<td>'+row.is_on_sale+'</td>';
                        table += '<td>'+row.is_free_shipping+'</td>';
                        table += '</tr>';
                    })
                    $(".product_list tr").not(':eq(0)').empty();
                    $(".product_list").append(table);
                }
            )
        })
    });

</script>