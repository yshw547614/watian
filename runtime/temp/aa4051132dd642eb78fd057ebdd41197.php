<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:91:"E:\phpWeb\watian\webserver\public/../application/admin\view\after_service\service_item.html";i:1544602321;}*/ ?>
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
    <link rel="stylesheet" href="/static/admin/client/shop/after_service/service_item.css" media="all" />
</head>
<body class="childrenBody">
<blockquote class="layui-elem-quote quoteBox white">
    <form class="layui-form layui-form-pane" action="">
        <div class="layui-form-item">
            <label class="layui-form-label">服务项名称</label>
            <div class="layui-input-inline">
                <input type="text" name="name" required  lay-verify="required" placeholder="请输入售后服务项名称" autocomplete="off" class="layui-input">
            </div>

            <label class="layui-form-label">跳转地址</label>
            <div class="layui-input-inline">
                <input type="text" name="link" required  lay-verify="required" placeholder="请选择跳转地址" autocomplete="off" class="layui-input">
            </div>

            <div class="layui-input-inline">
                <button type="button" class="layui-btn" lay-submit lay-filter="submit">添加售后服务项</button>
            </div>
        </div>
    </form>
</blockquote>
<table id="list" lay-filter="list"></table>

<!--操作-->
<script type="text/html" id="listBar">
    <a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="del">删除</a>
</script>
<script type="text/javascript" src="/static/admin/layui/layui.js"></script>
<script type="text/javascript" src="/static/admin/client/shop/after_service/service_item.js"></script>
</body>
</html>