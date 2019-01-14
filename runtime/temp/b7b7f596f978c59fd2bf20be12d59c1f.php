<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:86:"E:\phpWeb\watian\webserver\public/../application/admin\view\product_service\index.html";i:1537195190;s:66:"E:\phpWeb\watian\webserver\application\admin\view\public\base.html";i:1538110204;}*/ ?>
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
<form method="post" action="">
    <div class="panel admin-panel">
        <div class="panel-head"><strong class="icon-reorder"> 商品售后服务项</strong></div>
        <div class="padding border-bottom">
            <button type="button" class="button border-yellow" onclick="window.location.href='<?php echo url('add'); ?>'">
                <span class="icon-plus-square-o"></span> 添加售后服务项
            </button>
        </div>
        <table class="table table-hover">
            <tr>
                <th width="10%">序列编号</th>
                <th width="20%">售后服务项名称</th>
                <th width="40%">售后服务项描述</th>
                <th width="30%">操作</th>
            </tr>
            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $key = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($key % 2 );++$key;?>
            <tr>
                <td><?php echo $key; ?></td>
                <td><?php echo $item['name']; ?></td>
                <td><?php echo $item['describe']; ?></td>
                <td>
                    <div class="button-group">
                        <a type="button" class="button border-main" href="<?php echo url('edit',['id'=>$item['id']]); ?>">
                            <span class="icon-edit"></span>修改</a>
                        <a class="button border-red" href="javascript:void(0)"
                           onClick="warning('确实要删除吗', '<?php echo url('delete',['id'=>$item['id']]); ?>')">
                            <span class="icon-trash-o"></span> 删除</a>
                    </div>
                </td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </table>
    </div>
</form>
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

</body>
</html>