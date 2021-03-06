<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:77:"E:\phpWeb\watian\webserver\public/../application/admin\view\advert\index.html";i:1545030157;}*/ ?>
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
    <link rel="stylesheet" href="/static/admin/client/shop/advert/list.css" media="all" />
</head>
<body class="childrenBody">

<div class="layui-tab layui-tab-brief list-div" lay-filter="advert">
    <ul class="layui-tab-title">
        <li class="layui-this">物流详情页广告</li>
        <li>订单详情页广告</li>
        <li>商品分类页广告</li>
    </ul>
    <div class="layui-tab-content">

        <table id="list" lay-filter="list"></table>
    </div>
</div>

<div class="add-div">
    <fieldset class="layui-elem-field">
    <legend>添加广告</legend>
    <div class="layui-field-box">
        <form class="layui-form" action="">
            <div class="layui-form-item">
                <label class="layui-form-label">缩略图片</label>
                <div class="layui-input-inline">
                    <div class="thumbBox">
                        <i class="layui-icon layui-icon-add-1"></i>
                        <img class="layui-upload-img thumbImg">
                        <input type="hidden" value="" lay-verify="thumb" name="img_url">
                    </div>

                </div>
                <div class="layui-inline">
                    <div class="layui-form-mid layui-word-aux">图片尺寸为：750px*196px</div>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">链接类型</label>
                <div class="layui-input-inline" style="width: 350px;">
                    <select lay-verify="required"  lay-filter="link-type" >
                        <option value="0">请选择链接类型</option>
                        <option value="1">跳转到分类</option>
                        <option value="2">跳转到商品</option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item layui-hide">
                <label class="layui-form-label">商品分类</label>
                <div class="layui-input-inline" style="width: 350px;">
                    <select lay-filter="category" id="category">
                        <option value="">请选择商品分类</option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item link-url">
                <label class="layui-form-label">链接地址</label>
                <div class="layui-input-inline" style="width: 350px;">
                    <input type="hidden" name="link">
                    <input type="text" name="link_type" required  lay-verify="required" placeholder="请选择链接类型" disabled="disabled" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button type="button" class="layui-btn" lay-submit lay-filter="submit">立即提交</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
        </form>
    </div>
</fieldset>
</div>
<script type="text/html" id="img">
    <img src="{{d.img_url}}" width="140" height="40">
</script>
<script type="text/html" id="listBar">
    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="del">删除</a>
</script>
<script type="text/javascript" src="/static/admin/layui/layui.js"></script>
<script type="text/javascript" src="/static/admin/client/shop/advert/list.js"></script>
</body>
</html>