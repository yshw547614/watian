<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:84:"D:\phpweb\watian\webserver\public/../application/admin\view\store_address\index.html";i:1535620423;s:66:"D:\phpweb\watian\webserver\application\admin\view\public\base.html";i:1538110204;}*/ ?>
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
    <div class="panel-head" id="add"><strong><span class="icon-pencil-square-o"></span>增加内容</strong></div>
    <div class="body-content">
        <form method="post" class="form-x" action="" enctype="multipart/form-data">
            <div class="form-group">
                <div class="label">
                    <label>收件人：</label>
                </div>
                <div class="field">
                    <input required type="text" class="input w50" value="<?php if(!empty($data['name'])): ?><?php echo $data['name']; endif; ?>"
                    name="name" data-validate="required:请输入收件人姓名" />
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>手机号码：</label>
                </div>
                <div class="field">
                    <input required type="text" class="input w50" value="<?php if(!empty($data['mobile'])): ?><?php echo $data['mobile']; endif; ?>"
                    name="mobile" data-validate="required:请输入收件人手机号码" />
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>收货地址：</label>
                </div>
                <div class="field">
                    <input required type="text" class="input w50" value="<?php if(!empty($data['address'])): ?><?php echo $data['address']; endif; ?>"
                    name="address" data-validate="required:请输入收货地址" />
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>邮编：</label>
                </div>
                <div class="field">
                    <input required type="text" class="input w50" value="<?php if(!empty($data['zipcode'])): ?><?php echo $data['zipcode']; endif; ?>"
                    name="zipcode" data-validate="required:请输入邮编" />
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label></label>
                </div>
                <div class="field">
                    <button class="button border-main icon-check-square-o" type="submit"> 确认提交</button>
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

</body>
</html>