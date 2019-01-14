<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:78:"D:\phpweb\watian\webserver\public/../application/admin\view\keyword\index.html";i:1544441208;}*/ ?>
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
    <link rel="stylesheet" href="/static/admin/client/shop/keyword/list.css" media="all" />
</head>
<body class="childrenBody">
<blockquote class="layui-elem-quote white">
    <a class="layui-btn layui-btn-sm addHotWord">添加热门关键词</a>
</blockquote>
<table id="list" lay-filter="list"></table>
<!--操作-->
<script type="text/html" id="listBar">
    <a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="del">删除</a>
</script>
<script type="text/javascript" src="/static/admin/layui/layui.js"></script>
<script type="text/javascript" src="/static/admin/client/shop/keyword/list.js"></script>
</body>
</html>