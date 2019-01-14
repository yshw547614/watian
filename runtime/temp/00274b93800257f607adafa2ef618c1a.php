<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:87:"D:\phpweb\watian\webserver\public/../application/admin\view\after_service\template.html";i:1544894225;}*/ ?>
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
    <link rel="stylesheet" href="/static/admin/client/shop/after_service/template.css" media="all" />
</head>
<body class="childrenBody">
<blockquote class="layui-elem-quote quoteBox white">
    <button type="button" class="layui-btn add_template">添加模板</button>
</blockquote>
<table class="layui-table" id="list" lay-filter="list"></table>

<!--操作-->
<script type="text/html" id="listBar">
    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="del">删除</a>
</script>
<script type="text/javascript" src="/static/admin/layui/layui.js"></script>
<script type="text/javascript" src="/static/admin/client/shop/after_service/template.js"></script>
</body>
</html>