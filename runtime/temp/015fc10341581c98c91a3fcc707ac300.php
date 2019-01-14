<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:78:"E:\phpWeb\watian\webserver\public/../application/admin\view\express\index.html";i:1538111691;s:66:"E:\phpWeb\watian\webserver\application\admin\view\public\base.html";i:1538110204;}*/ ?>
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

<script src="/static/admin/js/common.js"></script>
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

<div class="panel admin-panel">
    <div class="panel-head"><strong class="icon-reorder"> 快递公司列表</strong></div>
    <table class="table table-hover">
        <tr>
            <th width="10%">Id编号</th>
            <th width="30%">快递公司</th>
            <th width="30%">快递编码</th>
            <th width="30%">操作</th>
        </tr>
        <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $key = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($key % 2 );++$key;?>
        <tr>
            <td><?php echo $key; ?></td>
            <td><input name="title[]" value="<?php echo $item['title']; ?>" id="title<?php echo $item['id']; ?>" class="input w80"></td>
            <td><input name="code[]" value="<?php echo $item['code']; ?>" id="code<?php echo $item['id']; ?>" class="input w80"></td>
            <td>
                <div class="button-group">
                    <a type="button" class="button border-main edit" href="javascript:void(0);" data-id="<?php echo $item['id']; ?>">
                        <span class="icon-edit"></span>修改</a>
                    <a class="button border-red" href="javascript:void(0)"
                       onClick="warning('删除后数据不能恢复，确定要删除吗？', '<?php echo url('del',['id'=>$item['id']]); ?>')">
                        <span class="icon-trash-o"></span> 删除</a>
                </div>
            </td>
        </tr>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </table>
</div>
<div class="panel admin-panel margin-top" id="add">
    <div class="panel-head"><strong><span class="icon-pencil-square-o"></span> 添加快递公司</strong></div>
    <table class="table table-hover">
        <tr>
            <td>快递公司</td>
            <td><input name="title" value="" id="title" class="input w80"></td>
            <td>快递编码</td>
            <td><input name="code" value="" id="code" class="input w80"></td>
            <td><button class="button bg-main icon-check-square-o margin-big-left" type="submit" id="submit"> 提交</button></td>
        </tr>
    </table>
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
    $(function () {
        $("#submit").click(
            function () {
                var title = $("#title").val();
                var code = $("#code").val();
                $.post(
                    "<?php echo url('add'); ?>",
                    {title:title,code:code},
                    function (res) {
                        layer.msg(res.msg, {time: 3000, icon:6});
                		setTimeout(function(){location.reload();},3000);
                    }
                )
            }
        );
        $(".edit").click(
            function () {
                var id = $(this).data('id');
                var title = $("#title"+id).val();
                var code = $("#code"+id).val();
                $.post(
                    "<?php echo url('edit'); ?>",
                    {id:id,title:title,code:code},
                    function (res) {
                        layer.msg(res.msg, {time: 3000, icon:6});
                		setTimeout(function(){location.reload();},3000);
                    }
                )
            }
        )
    })
</script>

</body>
</html>