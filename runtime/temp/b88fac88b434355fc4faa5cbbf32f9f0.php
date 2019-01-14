<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:82:"D:\phpweb\watian\webserver\public/../application/admin\view\advert_item\items.html";i:1538923330;s:66:"D:\phpweb\watian\webserver\application\admin\view\public\base.html";i:1538110204;}*/ ?>
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
            <?php if($type == 'edit'): ?>
            <input name="id" value="<?php echo $item['id']; ?>" type="hidden">
            <?php else: ?>
            <input name="advert_id" value="<?php echo $advertid; ?>" type="hidden">
            <?php endif; ?>

            <div class="form-group">
                <div class="label">
                    <label>广告标题：</label>
                </div>
                <div class="field">
                    <input type="text" class="input w50" <?php if($type == 'edit'): ?>value="<?php echo $item['title']; ?>"<?php endif; ?>
                    name="title" />
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>跳转地址：</label>
                </div>
                <div class="field">
                    <input type="text" class="input w50" <?php if($type == 'edit'): ?>value="<?php echo $item['link']; ?>"<?php endif; ?>
                    name="link" data-validate="required:请输入跳转链接" />
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>广告图片：</label>
                </div>
                <div class="field">
                    <div class="thumb_img_box">
                        <p class="tableCell">
                            <?php if($type == 'edit' and $item['img_url'] != ''): ?>
                            <img src="<?php echo $item['img_url']; ?>" class="thumb-img" id="thumb">
                            <?php else: ?>
                            <img  class="thumb-img" id="thumb">
                            <?php endif; ?>
                        </p>
                    </div>
                    <div class="thumb_btn_box">
                        <input type="file" name="img_url" class="fiel_btn">
                        <input type="button" class="button bg-blue margin-left upload-btn" id="image1" value="+ 浏览上传"  style="float:left;">
                    </div>
                    <div class="tipss">首页banner图尺寸: 754*546;其他广告图尺寸: 750*196;</div>
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
    $(function() {
        $(':input[type="file"]').change(function(){
            var url = null;
            var file=this.files[0];
            if (window.createObjectURL != undefined) {
                url = window.createObjectURL(file)
            } else if (window.URL != undefined) {
                url = window.URL.createObjectURL(file)
            } else if (window.webkitURL != undefined) {
                url = window.webkitURL.createObjectURL(file)
            }
            $("#thumb").attr("src",url);


        });

    });
</script>

</body>
</html>