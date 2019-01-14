<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:76:"D:\phpweb\watian\webserver\public/../application/admin\view\image\index.html";i:1543818060;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>图片总数--layui后台管理模板</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="/static/admin/layui/css/layui.css" media="all" />
    <link rel="stylesheet" href="/static/admin/css/public.css" media="all" />
    <link rel="stylesheet" href="/static/admin/client/image/index.css" media="all" />
</head>
<body class="childrenBody">
<form class="layui-form">
    <blockquote class="layui-elem-quote news_search">
        <div class="layui-inline">
            <input type="checkbox" name="selectAll" id="selectAll" lay-filter="selectAll" lay-skin="primary" title="全选">
        </div>
        <!--<div class="layui-inline">
            <a class="layui-btn layui-btn-sm layui-btn-danger batchDel">批量删除</a>
        </div>-->
        <div class="layui-inline">
            <a class="layui-btn layui-btn-sm uploadNewImg">上传新图片</a>
        </div>
        <div class="layui-inline">
            <a class="layui-btn layui-btn-sm confirm">确定</a>
        </div>
    </blockquote>
    <ul class="layer-photos-demo" id="Images"></ul>
    <div id="page"></div>
</form>
<script type="text/javascript" src="/static/admin/layui/layui.js"></script>
<script type="text/javascript" src="/static/admin/client/image/index.js"></script>
</body>
</html>