<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:74:"E:\phpWeb\watian\webserver\public/../application/admin\view\help\help.html";i:1546068917;}*/ ?>
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
    <link rel="stylesheet" href="/static/admin/client/help/help.css" media="all" />
</head>
<body class="childrenBody">
<form class="layui-form" action="" lay-filter="article">
    <div class="layui-form-item">
        <label class="layui-form-label">文档标题</label>
        <div class="layui-input-block">
            <input type="text" name="title" required  lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">文档分类</label>
        <div class="layui-input-block">
            <select name="type_id" lay-verify="required">
                <option value="">请选择文档分类</option>
            </select>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">是否推荐</label>
        <div class="layui-input-block">
            <input type="checkbox" name="recommend" lay-skin="switch">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">文档内容</label>
        <div class="layui-input-block">
            <textarea name="content" id="content" style="display: none;"></textarea>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button type="button" class="layui-btn" lay-submit lay-filter="submit">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>
<script type="text/javascript" src="/static/admin/layui/layui.js"></script>
<script type="text/javascript" src="/static/admin/client/help/help.js"></script>
</body>
</html>