<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:76:"E:\phpWeb\watian\webserver\public/../application/admin\view\group\index.html";i:1547709633;}*/ ?>
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
    <link rel="stylesheet" href="/static/admin/client/system/auth/group/list.css" media="all" />
</head>
<body class="childrenBody">
<blockquote class="layui-elem-quote white">
    <a class="layui-btn layui-btn-sm add-btn">添加用户组</a>
</blockquote>
<table id="list" lay-filter="list"></table>

<!--上架状态-->
<script type="text/html" id="status">
    <input type="checkbox" data-id="{{d.id}}" name="status" value="{{d.status}}" lay-skin="switch" lay-text="正常|停用" lay-filter="status" {{ d.status == 1 ? 'checked' : '' }}>
</script>
<!--操作-->
<script type="text/html" id="listBar">
    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="del">删除</a>
</script>
<script type="text/javascript" src="/static/admin/layui/layui.js"></script>
<script type="text/javascript" src="/static/admin/client/system/auth/group/list.js"></script>
</body>
</html>