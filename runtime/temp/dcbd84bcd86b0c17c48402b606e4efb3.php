<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:78:"E:\phpWeb\watian\webserver\public/../application/admin\view\product\index.html";i:1545043735;}*/ ?>
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
    <link rel="stylesheet" href="/static/admin/client/shop/product/list.css" media="all" />
</head>
<body class="childrenBody">
<div class="layui-tab layui-tab-brief" lay-filter="after_service">
    <ul class="layui-tab-title">
        <li class="layui-this">在售中</li>
        <li>已售罄</li>
        <li>已下架</li>
        <li>仓库中</li>
    </ul>
    <div class="layui-tab-content">
        <blockquote class="layui-elem-quote quoteBox white">
            <form class="layui-form layui-form-pane search">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <div class="layui-input-inline">
                            <input type="text" name="product_name" class="layui-input" placeholder="请输入商品名称" />
                        </div>
                    </div>
                    <div class="layui-inline">
                        <div class="layui-input-inline">
                            <select lay-filter="category" name="category" class="select_category" >
                                <option value="">请选择商品分类</option>
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <div class="layui-input-inline">
                            <select lay-filter="nation" name="nation">
                                <option value="">商品地域</option>
                                <option value="0">国内</option>
                                <option value="1">海外</option>
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <div class="layui-input-inline">
                            <select lay-filter="is_free_shipping" name="is_free_shipping">
                                <option value="">是否包邮</option>
                                <option value="1">是</option>
                                <option value="0">否</option>
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <button type="button" class="layui-btn" lay-submit="" lay-filter="sreach"><i class="layui-icon layui-icon-search"></i></button>
                    </div>
                </div>
            </form>
        </blockquote>
        <blockquote class="layui-elem-quote quoteBox white">
            <div class="layui-btn-container batchUpdate">
                <button type="button" class="layui-btn" data-type="upperShelf">批量上架</button>
                <button type="button" class="layui-btn" data-type="lowerShelf">批量下架</button>
                <button type="button" class="layui-btn" data-type="freeShipping">批量包邮</button>
                <button type="button" class="layui-btn" data-type="recommend">批量推荐</button>
                <button type="button" class="layui-btn" data-type="addFreightTemplate">添加运费模板</button>
                <button type="button" class="layui-btn" data-type="addAfterServiceTemplate">添加售后服务模板</button>
            </div>
        </blockquote>
        <div class="white">
            <table id="list" lay-filter="list"></table>
        </div>
    </div>
</div>

<!--缩略图-->
<script type="text/html" id="thumb_img">
    <img src="{{d.thumb_img}}" lay-event="change_thumb" width="40" height="52">
</script>
<!--商品地域-->
<script type="text/html" id="nation">
    <input type="checkbox" data-id="{{d.id}}" name="nation" value="{{d.nation}}" lay-skin="switch" lay-text="国外|国内"  lay-filter="nation" {{ d.nation == 1 ? 'checked' : '' }}>
</script>
<!--上架状态-->
<script type="text/html" id="is_on_sale">
    <input type="checkbox" data-id="{{d.id}}" name="is_on_sale" value="{{d.is_on_sale}}" lay-skin="switch" lay-text="上架|下架" lay-filter="is_on_sale" {{ d.is_on_sale == 1 ? 'checked' : '' }}>
</script>

<!--操作-->
<script type="text/html" id="listBar">
    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="del">删除</a>
</script>
<script type="text/javascript" src="/static/admin/js/jquery.js"></script>
<script type="text/javascript" src="/static/admin/layui/layui.js"></script>
<script type="text/javascript" src="/static/admin/client/shop/product/list.js"></script>
</body>
</html>