<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:79:"E:\phpWeb\watian\webserver\public/../application/admin\view\category\index.html";i:1544602346;}*/ ?>
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
    <link rel="stylesheet" href="/static/admin/client/shop/category/list.css" media="all" />
</head>
<body class="childrenBody">
<div class="page-goods-classify">
    <blockquote class="layui-elem-quote quoteBox white">
        <div class="layui-btn-container">
            <button type="button" class="layui-btn layui-btn-normal add_category">添加分类</button>
            <button type="button" class="layui-btn layui-btn-warm all-open-fold" data-title="open">全部折叠</button>
        </div>
    </blockquote>
    <div class="page-goods-classify-table">
        <div class="ui-table f12">
            <div class="ui-table-head">
                <div class="ui-table-list" style="width: 300px;">排序</div>
                <div class="ui-table-list width-auto">分类名称</div>
                <div class="ui-table-list width-auto">缩略图（目前仅支持二级分类上传图片）</div>
                <div class="ui-table-list" style="width: 120px;">操作</div>
            </div>
            <div class="ui-table-body">

            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="/static/admin/layui/layui.js"></script>
<script type="text/javascript" src="/static/admin/client/shop/category/list.js"></script>
</body>
</html>