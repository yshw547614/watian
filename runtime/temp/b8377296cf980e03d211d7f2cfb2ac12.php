<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:77:"D:\phpweb\watian\webserver\public/../application/admin\view\region\index.html";i:1545070541;}*/ ?>
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
    <link rel="stylesheet" href="/static/admin/client/shop/logistics/region.css" media="all" />
</head>
<body class="childrenBody">
<blockquote class="layui-elem-quote white">
    单击加载下级区域，双击进行编辑操作
</blockquote>
<div class="region-div">
    <table lay-skin="nob" id="province" lay-filter="province"></table>
</div>
<div class="region-div">
    <table lay-skin="nob" id="city" lay-filter="city"></table>
</div>
<div class="region-div">
    <table lay-skin="nob" id="country" lay-filter="country"></table>
</div>

<script type="text/javascript" src="/static/admin/layui/layui.js"></script>
<script type="text/javascript" src="/static/admin/client/shop/logistics/region.js"></script>
</body>
</html>