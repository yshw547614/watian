<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:88:"D:\phpweb\watian\webserver\public/../application/admin\view\category\child_category.html";i:1544405175;}*/ ?>
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
    <link rel="stylesheet" href="/static/admin/client/shop/category/category.css" media="all" />
</head>
<body class="childrenBody">
<form class="layui-form" action="" lay-filter="child_category">
    <div class="layui-form-item">
        <label class="layui-form-label">分类名称</label>
        <div class="layui-input-block" style="width: 600px">
            <input type="text" name="name" required  lay-verify="required" placeholder="请输入分类名称" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">分类排序</label>
        <div class="layui-input-block" style="width: 600px">
            <input type="text" name="rank" required  lay-verify="required" placeholder="请输入分类排序" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item top-category">
        <label class="layui-form-label">上级分类</label>
        <div class="layui-input-block" style="width: 600px">
            <select name="pid" lay-verify="required" id="pid">
                <option value=""></option>
            </select>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">缩略图片</label>
        <div class="layui-input-block">
            <div class="thumbBox">
                <i class="layui-icon layui-icon-add-1"></i>
                <img class="layui-upload-img thumbImg">
                <input type="hidden" value="" lay-verify="thumb" name="topic_img">
            </div>
            <div class="layui-form-mid layui-word-aux">图片尺寸为：326px*432px</div>
        </div>
    </div>

    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit lay-filter="submit">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>
<script type="text/javascript" src="/static/admin/layui/layui.js"></script>
<script type="text/javascript" src="/static/admin/client/shop/category/childCategory.js"></script>
</body>
</html>