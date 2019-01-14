<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:77:"D:\phpweb\watian\webserver\public/../application/admin\view\freight\area.html";i:1544024181;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>后台管理系统</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="/static/admin/layui/css/layui.css" media="all" />
    <link rel="stylesheet" href="/static/admin/css/public.css" media="all" />
    <link rel="stylesheet" href="/static/admin/client/shop/logistics/area.css" media="all" />
</head>
<body class="childrenBody">
<div id="layoutRight">
    <div class="tp-area-list-wrap">
        <ul class="tp-area-list clearfix" id="area_list">
        </ul>
    </div>
    <div class="tp-inline-block-wrap">
        <div class="main-content" id="mainContent">
            <select name="province" id="province" size="6">
                <option value="0">请选择省份</option>
                <?php if(is_array($province_list) || $province_list instanceof \think\Collection || $province_list instanceof \think\Paginator): $i = 0; $__LIST__ = $province_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$province): $mod = ($i % 2 );++$i;?>
                <option value="<?php echo $province['id']; ?>"><?php echo $province['name']; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
            <select name="city" id="city" size="6">
                <option value="0">请选择城市</option>
            </select>
            <select name="district" size="6" id="district">
                <option value="0">请选择</option>
            </select>
        </div>
    </div>
    <div class="tp-layer-btns-wrap">
        <a class="ncsc-btn add-area" href="javascript:void(0);"><i class="layui-icon layui-icon-add-circle"></i> 添　加</a>
        <a class="ncsc-btn confirm" href="javascript:void(0);"><i class="layui-icon layui-icon-ok-circle"></i> 确　定</a>
    </div>
</div>
<script type="text/javascript" src="/static/admin/layui/layui.js"></script>
<script type="text/javascript" src="/static/admin/client/shop/logistics/area.js"></script>
</body>
</html>
