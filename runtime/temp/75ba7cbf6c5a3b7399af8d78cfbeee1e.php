<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:78:"D:\phpweb\watian\webserver\public/../application/admin\view\shop_set\home.html";i:1544602518;}*/ ?>
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
    <link rel="stylesheet" href="/static/admin/client/shop/home/index.css" media="all" />
</head>
<body class="childrenBody">
<form class="layui-form">
    <div class="home-page">
        <div class="edit-item">
            <div class="design-show banner">
                <div class="layui-carousel" id="banner">

                </div>
            </div>
            <div class="design-item">
                <div class="banner-design">
                    <h2>请编辑Banner广告</h2>
                    <ul class="banner-list">

                    </ul>

                    <div class="design-add-btn add-banner">
                        <div class="desing-add-img-text">
                            <i class="layui-icon layui-icon-add-1">添加一条广告</i>
                        </div>
                        <div class="desing-add-img-tip">图片尺寸为：750px*540px</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="edit-item">
            <div class="design-show slogan white">
                <ul>
                </ul>
            </div>
            <div class="design-item">
                <h2>请添加文字广告项</h2>
                <div class="design-slogan">
                    <ul>

                    </ul>
                </div>
            </div>
        </div>
        <div class="edit-item">
            <div class="design-show cat-nav white">
                <ul>
                </ul>
            </div>
            <div class="design-item">
                <h2>请编辑分类导航</h2>
                <div class="design-nav-cat">
                    <ul>

                    </ul>
                    <input type="hidden" name="cat_nav_sort">
                </div>
            </div>
        </div>

        <div class="category-porduct">

        </div>

        <div class="edit-item">
            <div class="design-show recommend  white">
                <h2>| 为你优选</h2>
                <ul class="recommend-list">

                </ul>
                <input type="hidden" name="recommend[id]" id="recommend_id">
                <input type="hidden" name="recommend[product_ids]" id="recommend_product_ids">
            </div>
            <div class="design-item">
                <h2>请编辑推荐商品</h2>
                <div class="design-reccomend">
                    <ul id="recommend">

                    </ul>
                    <div class="design-add-btn add-product-recommend">
                        <div class="desing-add-img-text">
                            <i class="layui-icon layui-icon-add-1">请选择添加商品</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="white pd20 magt10 submit-div">
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button type="button" class="layui-btn" lay-submit="" lay-filter="submit">立即修改</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript" src="/static/admin/js/jquery.js"></script>
<script type="text/javascript" src="/static/admin/layui/layui.js"></script>
<script type="text/javascript" src="/static/admin/js/jquery-ui.js"></script>
<script type="text/javascript" src="/static/admin/js/swiper.js"></script>
<script type="text/javascript" src="/static/admin/client/shop/home/index.js"></script>

</body>
</html>