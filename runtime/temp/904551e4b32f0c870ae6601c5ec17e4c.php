<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:80:"D:\phpweb\watian\webserver\public/../application/admin\view\freight\freight.html";i:1544602376;}*/ ?>
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
    <link rel="stylesheet" href="/static/admin/client/shop/logistics/freight.css" media="all" />
</head>
<body class="childrenBody">
<form class="layui-form" action="" lay-filter="template">
    <blockquote class="layui-elem-quote white ">
        <div class="layui-form-item">
            <label class="layui-form-label">模板名称</label>
            <div class="layui-input-inline" style="width: 300px;">
                <input type="text" name="name" required  lay-verify="required" placeholder="请输入模板名称" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">默认配送</label>
            <div class="layui-input-inline" style="width: 60px;">
                <input type="checkbox" name="is_enable_default" lay-filter="is_enable_default" lay-skin="switch" lay-text="开启|关闭">
            </div>
            <div class="layui-form-mid layui-word-aux">是否开启默认配送设置</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">计价方式</label>
            <div class="layui-input-block">
                <input type="radio" name="type" lay-filter="type" value="0" title="件数" checked>
                <input type="radio" name="type" lay-filter="type" value="1" title="重量" >
                <input type="radio" name="type" lay-filter="type" value="2" title="体积">
            </div>
        </div>
    </blockquote>
    <div class="arae-div white">
        <table class="layui-table freight">
            <tr id="tr_add">
                <td colspan="6" style="text-align: right;">
                    <button type="button" class="layui-btn"  id="btn_add">添加自定义区域</button>
                </td>
            </tr>
            <tr id="table_th">
                <td>配送区域</td>
                <td class="first_unit">首件</td>
                <td>运费</td>
                <td class="continue_unit">续件</td>
                <td>运费</td>
                <td width="15%">操作</td>
            </tr>

        </table>
    </div>
    <div class="white pd20 magt10 sub-div">
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button type="button" class="layui-btn" lay-submit="" lay-filter="submit">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript" src="/static/admin/layui/layui.js"></script>
<script type="text/javascript" src="/static/admin/client/shop/logistics/freight.js"></script>
</body>
</html>
