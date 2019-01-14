<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:98:"D:\phpweb\watian\webserver\public/../application/admin\view\product_service_template\template.html";i:1539010893;s:66:"D:\phpweb\watian\webserver\application\admin\view\public\base.html";i:1538110204;}*/ ?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="renderer" content="webkit">
<title>后台管理中心</title>
<link rel="stylesheet" href="/static/admin/css/pintuer.css">
<link rel="stylesheet" href="/static/admin/css/admin.css">

<script src="/static/admin/js/jquery.js"></script>

<script src="/static/admin/js/common.js" type="application/javascript"></script>
<script src="/static/admin/layer/layer.js" type="application/javascript"></script>

</head>
<body style="background-color:#f2f9fd;">
<div class="header bg-main">
  <div class="logo margin-big-left fadein-top">
    <h1><!--<img src="/static/admin/images/y.jpg" class="radius-circle rotate-hover" height="50" alt="" />-->后台管理中心</h1>
  </div>
  <div class="head-l">
      <a class="button button-little bg-green" href="" target="_blank"> <span class="icon-home"></span> 前台首页</a> &nbsp;&nbsp;
      <a href="#" class="button button-little bg-blue"> <span class="icon-wrench"></span> 清除缓存</a> &nbsp;&nbsp;
      <a class="button button-little bg-red" href="<?php echo url('Login/logout'); ?>"> <span class="icon-power-off"></span> 退出登录</a>
  </div>
</div>
<div class="leftnav">
  <div class="leftnav-title"><strong> <span class="icon-list"></span> 菜单列表</strong></div>
  <?php if(is_array($navmenus) || $navmenus instanceof \think\Collection || $navmenus instanceof \think\Paginator): $i = 0; $__LIST__ = $navmenus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$navmenu): $mod = ($i % 2 );++$i;?>
  <h2> <span class="<?php echo $navmenu['icon']; ?>"></span><?php echo $navmenu['name']; ?></h2>
  <ul>
    <?php if(is_array($navmenu['childs']) || $navmenu['childs'] instanceof \think\Collection || $navmenu['childs'] instanceof \think\Paginator): $i = 0; $__LIST__ = $navmenu['childs'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$child): $mod = ($i % 2 );++$i;
        $module = request()->module();
        $controller = request()->controller();
        $action = request()->action();
        $mca = strtolower($module.'/'.$controller.'/'.$action);
        if(strpos($child['route'],$mca) !== false){
          echo '<li class="active">';
        }else{
          echo '<li>';
        }
       ?>
     <a href="<?php echo url($child['route']); ?>" class=""> <span class="icon-caret-right"></span><?php echo $child['name']; ?></a> </li>
    <?php endforeach; endif; else: echo "" ;endif; ?>
  </ul>
  <?php endforeach; endif; else: echo "" ;endif; ?>
</div>

<ul class="bread">
  <li> <a href="<?php echo url('admin/index/index'); ?>" target="_self" class="icon-home"> 首页</a> </li>
  <li> <a href="##" id="a_leader_txt">网站信息</a> </li>
</ul>
<div class="admin">
<style>
    .product_list{ border: 1px solid #ddd; margin-top: 15px; float: left;}
</style>
<div class="panel admin-panel">
    <div class="panel-head" id="add">
        <strong>
            <span class="icon-pencil-square-o">
            <?php if($type == 'edit'): ?>
                修改模板
            <?php else: ?>
                添加模板
            <?php endif; ?>
            </span>
        </strong>
    </div>
    <div class="body-content">
        <form method="post" class="form-x" action="">
            <?php if($type == 'edit'): ?>
            <input name="id" type="hidden" value="<?php echo $data['id']; ?>">
            <?php endif; ?>
            <div class="form-group">
                <div class="label">
                    <label>模板名称：</label>
                </div>
                <div class="field">
                    <input type="text" class="input w50" <?php if($type == 'edit'): ?>value="<?php echo $data['name']; ?>"<?php endif; ?> name="name" data-validate="required:请输入模板名称" />
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>售后服务选项：</label>
                </div>
                <div class="field">
                    <table class="table table-hover table1 w80">
                        <tr>
                            <td width="120"><input type="checkbox" id="checkall" value=""/>全选</td>
                            <td>服务选项名称</td>
                        </tr>
                        <?php if(is_array($services) || $services instanceof \think\Collection || $services instanceof \think\Paginator): $i = 0; $__LIST__ = $services;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$service): $mod = ($i % 2 );++$i;?>
                            <tr>
                                <?php if($type == 'edit' && $service['checked']==true): ?>
                                <td><input type="checkbox" name="service[]" value="<?php echo $service['id']; ?>" checked/></td>
                                <?php else: ?>
                                <td><input type="checkbox" name="service[]" value="<?php echo $service['id']; ?>"/></td>
                                <?php endif; ?>
                                <td><?php echo $service['name']; ?></td>
                            </tr>
                         <?php endforeach; endif; else: echo "" ;endif; ?>
                    </table>
                </div>
            </div>

            <div class="form-group">
                <div class="label">
                    <label>选择商品：</label>
                </div>
                <div class="button-group radio field">
                    <?php if($type == 'edit' && $data['is_all_product']=='no'): ?>
                    <input name="product_ids" type="hidden" value="<?php echo $data['product_ids']; ?>">
                    <label class="button"> <span class="icon icon-check"></span>
                        <input name="product" value="0" type="radio">
                        全部 </label>
                    <label class="button active"><span class="icon icon-check"></span>
                        <input name="product" value="1"  type="radio"  checked="checked">
                        部分 </label>
                    <?php else: ?>
                    <input name="product_ids" type="hidden" value="0">
                    <label class="button active"> <span class="icon icon-check"></span>
                        <input name="product" value="0" type="radio" checked="checked">
                        全部 </label>
                    <label class="button"><span class="icon icon-check"></span>
                        <input name="product" value="1"  type="radio">
                        部分 </label>
                    <?php endif; if($type == 'edit'): ?>
                    <table class="table table-hover product_list">
                        <tr>
                            <th>名称</th>
                            <th>缩略图</th>
                            <th>价格</th>
                            <th>库存</th>
                        </tr>
                        <?php if(is_array($products) || $products instanceof \think\Collection || $products instanceof \think\Paginator): $i = 0; $__LIST__ = $products;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?>
                        <tr>
                            <td><?php echo $item['name']; ?></td>
                            <td><img src="<?php echo $item['thumb_img']; ?>" style="width: 40px; height: 40px;"></td>
                            <td><?php echo $item['price']; ?></td>
                            <td><?php echo $item['stock']; ?></td>
                        </tr>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </table>
                    <?php else: ?>
                    <table class="table table-hover product_list">
                        <tr>
                            <th>名称</th>
                            <th>缩略图</th>
                            <th>价格</th>
                            <th>库存</th>
                        </tr>
                    </table>
                    <?php endif; ?>

                </div>

            </div>

            <div class="form-group">
                <div class="label">
                    <label></label>
                </div>
                <div class="field">
                    <button class="button bg-main icon-check-square-o" type="submit"> 提交</button>
                </div>
            </div>
        </form>
    </div>
</div>
 </div>
<script type="text/javascript">
    $(function(){
        $(".leftnav h2").click(function(){
            $(this).siblings('ul').slideUp();
            $(this).next().slideToggle(200);
            $(this).siblings('.on').toggleClass();
            $(this).toggleClass("on");
        })
        $(".leftnav ul li.active").parent('ul').prev('h2').click();
        $("#a_leader_txt").text($(".leftnav ul li.active").text());

    });
</script>

<script>
    function call_back_product(product_list) {
        var product_list_id = get_product_list_id(product_list);
        $("input[name='product_ids']").val(product_list_id);
        select_product(product_list_id);
        layer.closeAll('iframe');
    }
    function get_product_list_id(product_list) {
        var product_list_id = '';
        $.each(product_list, function (index,item) {
            product_list_id += item + ',';
        });
        if(product_list_id.length > 1){
            product_list_id = product_list_id.substr(0,product_list_id.length-1);
        }
        return product_list_id;
    }
    function select_product(product_list_id) {
        $.post(
            "<?php echo url('product/getListByIds'); ?>",
            {ids:product_list_id},
            function (res) {
                var table = '';
                $.each(res,function (i,row) {
                    table += '<tr>';
                    table += '<td>'+row.name+'</td>';
                    table += '<td><img src="'+row.thumb_img+'" style="width: 40px; height: 40px;"></td>';
                    table += '<td>'+row.price+'</td>';
                    table += '<td>'+row.stock+'</td>';
                    table += '</tr>';
                })
                $(".product_list tr").not(':eq(0)').empty();
                $(".product_list").append(table);
            }
        )
    }
    $(function(){
        var flag = $("input[name='product']").prop("checked");
        if(flag){
            $(".product_list").hide();
        }else{
            $(".product_list").show();
        }
        $("input[name='product']").click(function () {
            var flag = $("input[name='product']").prop("checked");
            if(flag){
                $("input[name='product_ids']").val(0);
                $(".product_list").hide();
            }else{
                var url = "<?php echo url('product/select'); ?>";
                layer.open({
                    type: 2,
                    title: '选择商品',
                    shadeClose: true,
                    shade: 0.2,
                    area: ['520px', '400px'],
                    content: url
                });
                $(".product_list").show();
            }
        })

        $("#checkall").click(function(){
            var that = this;
            if(that.checked){
                $("input[name='service[]']").each(function(){
                    this.checked = true;
                });
            }else{
                $("input[name='service[]']").each(function(){
                    this.checked = false;
                });
            }

        })
    });

</script>

</body>
</html>