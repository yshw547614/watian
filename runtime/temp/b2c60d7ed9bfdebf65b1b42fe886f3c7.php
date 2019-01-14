<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:79:"E:\phpWeb\watian\webserver\public/../application/admin\view\product\select.html";i:1543817098;}*/ ?>
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
    <link rel="stylesheet" href="/static/admin/client/shop/product/select.css" media="all" />
</head>
<body class="childrenBody" style="width: 718px; margin: 10px auto;">
<blockquote class="layui-elem-quote quoteBox">
    <form class="layui-form layui-form-pane">
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">商品名称：</label>
                <div class="layui-input-inline">
                    <input type="text" name="product_name" class="layui-input" placeholder="请输入商品名称" />
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">商品分类：</label>
                <div class="layui-input-inline">
                    <select lay-filter="category" name="category" class="select_category" >
                        <option value="">请选择商品分类</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">商品地域：</label>
                <div class="layui-input-inline">
                    <select lay-filter="nation" name="nation">
                        <option value="">全部</option>
                        <option value="0">国内</option>
                        <option value="1">海外</option>
                    </select>
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">是否包邮：</label>
                <div class="layui-input-inline">
                    <select lay-filter="is_free_shipping" name="is_free_shipping">
                        <option value="">全部</option>
                        <option value="1">是</option>
                        <option value="0">否</option>
                    </select>
                </div>
            </div>
            <div class="layui-inline">
                <button class="layui-btn" lay-submit="" lay-filter="sreach"><i class="layui-icon"></i></button>
            </div>
        </div>
    </form>
</blockquote>
<table id="list" lay-filter="list"></table>
<div class="layui-block confirm" style="text-align: right;">
    <button class="layui-btn confirm_btn" lay-filter="confirm">确定</button>
</div>
<script type="text/javascript" src="/static/admin/layui/layui.js"></script>
<script type="text/javascript" src="/static/admin/client/shop/product/select.js"></script>
</body>
</html>