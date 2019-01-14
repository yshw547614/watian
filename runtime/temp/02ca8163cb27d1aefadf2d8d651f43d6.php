<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:92:"D:\phpweb\watian\webserver\public/../application/admin\view\after_service\template_edit.html";i:1544885122;}*/ ?>
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
    <link rel="stylesheet" href="/static/admin/client/shop/after_service/template_edit.css" media="all" />
</head>
<body class="childrenBody">
<form class="layui-form" action="" lay-filter="template">
    <div class="layui-form-item">
        <label class="layui-form-label">模板名称</label>
        <div class="layui-input-block" style="width: 600px;">
            <input type="text" name="name" required  lay-verify="required" placeholder="请输入模板名称" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">售后服务项</label>
        <div class="layui-input-block">
            <button type="button" class="layui-btn layui-btn-danger add_item">添加服务项</button>
        </div>
        <div class="service-div" >
            <ul class="service-list">

            </ul>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">选择商品</label>
        <div class="layui-input-block">
            <input type="radio" name="is_all_product" value="1" lay-filter="select_product" title="全部商品" checked>
            <input type="radio" name="is_all_product" value="0" lay-filter="select_product" title="自定义商品">
            <button type="button" class="select-product-btn layui-btn layui-btn-normal">选择商品</button>
        </div>
        <div class="product_list">
            <input name="product_ids" type="hidden" value="0">
            <table class="layui-table" id="products" lay-filter="products"></table>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button type="button" class="layui-btn" lay-submit lay-filter="submit">立即提交</button>
        </div>
    </div>
</form>
<!--缩略图-->
<script type="text/html" id="thumb_img">
    <img src="{{d.thumb_img}}" lay-event="change_thumb" width="40" height="52">
</script>
<!--上架状态-->
<script type="text/html" id="is_on_sale">
    {{# if(d.is_on_sale==1){}}
    <span>已上架</span>
    {{# }else if(d.is_on_sale==0){}}
    <span>待上架</span>
    {{# }else{}}
    <span>已下架</span>
    {{#}}}
</script>
<!--操作-->
<script type="text/html" id="listBar">
    <a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="del">删除</a>
</script>
<script type="text/javascript" src="/static/admin/layui/layui.js"></script>
<script type="text/javascript" src="/static/admin/client/shop/after_service/template_edit.js"></script>
</body>
</html>