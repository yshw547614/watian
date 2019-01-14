<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:89:"E:\phpWeb\watian\webserver\public/../application/admin\view\after_service\auto_check.html";i:1544603197;}*/ ?>
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
    <link rel="stylesheet" href="/static/admin/client/shop/after_service/auto_check.css" media="all" />
</head>
<body class="childrenBody">
<form class="layui-form" action="" lay-filter="auto_check">
    <blockquote class="layui-elem-quote white">
        请选择自动通过审核的退款退货原因
    </blockquote>
    <div class="layui-form-item reasons">

    </div>
    <div class="layui-form-item white row-btn">
        <div class="layui-input-block">
            <button type="button" class="layui-btn" lay-submit lay-filter="submit">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>
<script type="text/javascript" src="/static/admin/layui/layui.js"></script>
<script type="text/javascript" src="/static/admin/client/shop/after_service/auto_check.js"></script>
</body>
</html>