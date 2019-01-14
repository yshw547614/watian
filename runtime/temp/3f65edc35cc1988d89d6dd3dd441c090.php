<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:76:"D:\phpweb\watian\webserver\public/../application/admin\view\help\select.html";i:1544604577;}*/ ?>
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
    <link rel="stylesheet" href="/static/admin/client/help/select.css" media="all" />
</head>
<body class="childrenBody">
<blockquote class="layui-elem-quote quoteBox">
    <form class="layui-form layui-form-pane">
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">文档标题：</label>
                <div class="layui-input-inline">
                    <input type="text" name="help_title" class="layui-input" placeholder="请输入文档标题" />
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">文档分类：</label>
                <div class="layui-input-inline">
                    <select lay-filter="category" name="help_type" class="select_category">
                        <option value="">请选择文档分类</option>
                    </select>
                </div>
            </div>
            <div class="layui-inline">
                <button type="button" class="layui-btn" lay-submit="" lay-filter="sreach"><i class="layui-icon"></i></button>
            </div>
        </div>
    </form>
</blockquote>
<table id="list" lay-filter="list"></table>
<div class="layui-block confirm" style="text-align: right;">
    <button type="button" class="layui-btn confirm_btn" lay-filter="confirm">确定</button>
</div>
<script type="text/javascript" src="/static/admin/layui/layui.js"></script>
<script type="text/javascript" src="/static/admin/client/help/select.js"></script>
</body>
</html>