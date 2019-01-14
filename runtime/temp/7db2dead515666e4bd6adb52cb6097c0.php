<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:76:"E:\phpWeb\watian\webserver\public/../application/admin\view\product\add.html";i:1543820182;}*/ ?>
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
    <link rel="stylesheet" href="/static/admin/css/product.css" media="all" />
</head>
<body class="childrenBody">
<div>
    <form class="layui-form">
        <div class="white">
            <fieldset class="layui-elem-field layui-field-title">
                <legend>基础信息</legend>
            </fieldset>
            <div class="layui-form-item">
                <label class="layui-form-label">商品名称：</label>
                <div class="layui-input-inline">
                    <input type="text" name="name" value="" placeholder="请输入商品名称" class="layui-input" lay-verify="required">
                </div>
                <div class="layui-form-mid layui-word-aux">商品名称必须小于200个汉字</div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">商品分类：</label>
                <div class="layui-input-inline">
                    <select lay-verify="required" name="category_id" id="category">
                        <option>请选择商品分类</option>
                    </select>
                </div>
                <div class="layui-form-mid layui-word-aux">请选择商品分类</div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">商品库存：</label>
                <div class="layui-input-inline">
                    <input type="text" name="stock" value="" placeholder="请输入商品库存" lay-verify="required" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">商品库存为一个正整数(例如：100)</div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">划线价格：</label>
                <div class="layui-input-inline">
                    <input type="text" name="original_price" value="" placeholder="请输入划线价" lay-verify="required" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">划线价格必须为一个正数</div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">销售价格：</label>
                <div class="layui-input-inline">
                    <input type="text" name="price" value="" placeholder="请输入销售价" lay-verify="required" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">销售价格必须为正数</div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">缩略图片：</label>
                <div class="layui-input-inline width60">
                    <div class="thumbBox">
                        <i class="layui-icon layui-icon-add-1"></i>
                        <img class="layui-upload-img thumbImg">
                        <input type="hidden" value="" lay-verify="thumb" name="thumb_img">
                    </div>
                    <div class="layui-form-mid layui-word-aux">图片尺寸为：326px*432px</div>
                </div>
            </div>
        </div>
        <div class="white magt10">
            <fieldset class="layui-elem-field layui-field-title">
                <legend>包邮设置</legend>
            </fieldset>
            <div class="layui-form-item">
                <label class="layui-form-label">是否包邮：</label>
                <div class="layui-input-inline">
                    <input type="checkbox" checked="" name="is_free_shipping" lay-skin="switch" lay-filter="is_free_shipping" lay-text="是|否">
                </div>
            </div>
            <div class="shipping">
                <div class="layui-form-item">
                    <label class="layui-form-label">运费模板：</label>
                    <div class="layui-input-inline">
                        <select name="template_id" lay-filter="template_id" id="template_id">
                        </select>
                    </div>
                    <div class="layui-form-mid layui-word-aux">请选择运费模板</div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">商品重量：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="weight" value="" placeholder="请输入库存" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">用于计算物流费,以克为单位</div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">商品体积：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="volume" value="" placeholder="请输入库存" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">用于计算物流费,以立方米为单位</div>
                </div>
            </div>
        </div>
        <div class="white magt10">
            <fieldset class="layui-elem-field layui-field-title">
                <legend>上架设置</legend>
            </fieldset>
            <div class="layui-form-item sale_status">
                <div class="layui-input-block">
                    <div class="layui-input-inline">
                        <input type="radio" name="is_on_sale" lay-filter="is_on_sale" value="1" title="立即上架" checked=""><div class="layui-unselect layui-form-radio layui-form-radioed"><i class="layui-anim layui-icon"></i><div>立即上架</div></div>
                    </div>
                    <div class="layui-input-inline">
                        <input type="radio" name="is_on_sale" lay-filter="is_on_sale" value="0" title="暂不上架，放入仓库"><div class="layui-unselect layui-form-radio"><i class="layui-anim layui-icon"></i><div>暂不上架，放入仓库</div></div>
                    </div>
                    <div class="layui-input-inline">
                        <input type="radio" name="is_on_sale" lay-filter="is_on_sale" value="2" title="自定义上架时间"><div class="layui-unselect layui-form-radio"><i class="layui-anim layui-icon"></i><div>暂不上架，放入仓库</div></div>
                    </div>
                </div>
            </div>
            <div class="layui-form-item sale_time">
                <label class="layui-form-label">上架时间：</label>
                <div class="layui-input-inline">
                    <input type="sale_start_time" value="" placeholder="请选择上架时间" class="layui-input sale_start_time">
                </div>
                <div class="layui-form-mid layui-word-aux"></div>
            </div>

        </div>
        <div class="white magt10">
            <fieldset class="layui-elem-field layui-field-title">
                <legend>详情信息</legend>
            </fieldset>
            <div class="product_detail">
                <div class="edit-item">
                    <div class="design-show banner">
                        <div class="layui-carousel" id="banner">
                            <div carousel-item></div>
                        </div>
                    </div>
                    <div class="design-item">
                        <div class="banner-design">
                            <h2>请编辑商品轮播图</h2>
                            <input type="hidden" name="topic_img">
                            <ul class="banner-list">

                            </ul>
                            <div class="design-add-btn add-banner">
                                <div class="desing-add-img-text">
                                    <i class="layui-icon layui-icon-add-1">点击添加商品轮播图</i>
                                </div>
                                <div class="desing-add-img-tip">图片尺寸为：750px*540px</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="qita">
                    <p class="p1">商品标题，价格等信息</p>
                    <p class="p2">不可编辑区域</p>
                </div>
                <div class="prduct_cont">
                    <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
                        <ul class="layui-tab-title">
                            <li class="layui-this">商品详情</li>
                            <li>产品参数</li>
                        </ul>
                        <div class="layui-tab-content">
                            <div class="layui-tab-item layui-show">
                                <div class="edit-item product_pics">
                                    <div class="design-show product_pic_show">
                                        <ul>

                                        </ul>
                                    </div>
                                    <div class="design-item">
                                        <div class="product_pic_design">
                                            <h2>请编辑商品详情图</h2>
                                            <input type="hidden" name="main_img">
                                            <ul class="product_pic_ul">

                                            </ul>
                                            <div class="design-add-btn add-banner">
                                                <div class="desing-add-img-text">
                                                    <i class="layui-icon layui-icon-add-1">点击添加商品详情图片</i>
                                                </div>
                                                <div class="desing-add-img-tip">图片尺寸为：宽750px,高任意</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="layui-tab-item">
                                <div class="edit-item product_property">
                                    <div class="design-show product_property_show">
                                        <ul>

                                        </ul>
                                    </div>
                                    <div class="design-item">
                                        <div class="product_property_design">
                                            <h2>请编辑产品参数图</h2>
                                            <input type="hidden" name="property">
                                            <ul class="product_property_ul">

                                            </ul>
                                            <div class="design-add-btn add-banner">
                                                <div class="desing-add-img-text">
                                                    <i class="layui-icon layui-icon-add-1">点击添加产品参数图</i>
                                                </div>
                                                <div class="desing-add-img-tip">图片尺寸为：宽750px;高任意</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="white pd20 magt10">
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button type="submit" class="layui-btn" lay-submit="" lay-filter="submit">立即修改</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
        </div>
    </form>

</div>
<script type="text/javascript" src="/static/admin/js/jquery.js"></script>
<script type="text/javascript" src="/static/admin/layui/layui.js"></script>
<script type="text/javascript" src="/static/admin/js/jquery-ui.js"></script>
<script type="text/javascript" src="/static/admin/client/shop/product/add.js"></script>
</body>
</html>