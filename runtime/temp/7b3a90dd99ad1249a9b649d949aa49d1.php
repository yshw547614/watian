<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:81:"D:\phpweb\watian\webserver\public/../application/admin\view\app_wechat\index.html";i:1545035419;}*/ ?>
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
    <link rel="stylesheet" href="/static/admin/client/shop/app_wechat/index.css" media="all" />
</head>
<body class="childrenBody">



<div class="content">
    <fieldset class="layui-elem-field layui-field-title">
        <legend>提示下载APP文案</legend>
    </fieldset>
    <textarea id="app" style="display: none;"></textarea>
    <fieldset class="layui-elem-field layui-field-title">
        <legend>提示关注公众号文案</legend>
    </fieldset>
    <textarea id="wechat" style="display: none;"></textarea>
    <div class="layui-form-item submit-row">
        <div class="layui-input-block">
            <button type="button" class="layui-btn submit">保存</button>
        </div>
    </div>
</div>
<script type="text/javascript" src="/static/admin/layui/layui.js"></script>
<script type="text/javascript" src="/static/admin/client/shop/app_wechat/index.js"></script>
</body>
</html>