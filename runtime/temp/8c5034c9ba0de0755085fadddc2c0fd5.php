<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:76:"E:\phpWeb\watian\webserver\public/../application/admin\view\index\index.html";i:1547781189;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>后台管理系统</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="icon" href="/favicon.ico">
    <link rel="stylesheet" href="/static/admin/layui/css/layui.css" media="all" />
    <link rel="stylesheet" href="/static/admin/css/index.css" media="all" />
</head>
<body class="main_body">
<div class="layui-layout layui-layout-admin">
    <!-- 顶部 -->
    <div class="layui-header header">
        <!-- 显示/隐藏菜单 -->
        <a href="javascript:;" class="seraph hideMenu"><i class="layui-icon layui-icon-shrink-right"></i></a>
        <div class="layui-main mag0"> <a href="#" class="logo">后台管理系统</a>

            <ul class="layui-nav topLevelMenus" pc>
                <li class="layui-nav-item layui-this" data-menu="shop"> <a href="javascript:;"><i class="layui-icon layui-icon-cart-simple"></i><cite>商城</cite></a> </li>
                <li class="layui-nav-item" data-menu="community" pc> <a href="javascript:;"><i class="layui-icon layui-icon-user"></i><cite>社区</cite></a> </li>
                <li class="layui-nav-item" data-menu="chat" pc> <a href="javascript:;"><i class="layui-icon layui-icon-login-wechat"></i><cite>聊天</cite></a> </li>
                <li class="layui-nav-item" data-menu="member" pc> <a href="javascript:;"><i class="layui-icon layui-icon-username"></i><cite>用户</cite></a> </li>
                <li class="layui-nav-item" data-menu="system" pc> <a href="javascript:;"><i class="layui-icon layui-icon-set"></i><cite>系统</cite></a> </li>
            </ul>
            <!-- 顶部右侧菜单 -->
            <ul class="layui-nav top_menu">
                <li class="layui-nav-item" pc> <a href="javascript:;" class="clearCache"><i class="layui-icon" data-icon="&#xe640;">&#xe640;</i><cite>清除缓存</cite><span class="layui-badge-dot"></span></a> </li>
                <li class="layui-nav-item lockcms" pc> <a href="javascript:;"><i class="seraph icon-lock"></i><cite>锁屏</cite></a> </li>
                <li class="layui-nav-item" id="userInfo"> <a href="javascript:;"><img src="/static/admin/images/face.jpg" class="layui-nav-img userAvatar" width="35" height="35"><cite class="adminName">管理员</cite></a>
                    <dl class="layui-nav-child">
                        <dd><a href="javascript:;" data-url="<?php echo url('admin/detail'); ?>"><i class="seraph icon-ziliao" data-icon="icon-ziliao"></i><cite>个人资料</cite></a></dd>
                        <dd><a href="javascript:;" data-url="<?php echo url('admin/pass'); ?>"><i class="seraph icon-xiugai" data-icon="icon-xiugai"></i><cite>修改密码</cite></a></dd>
                        <dd><a href="<?php echo url('login/logout'); ?>" class="signOut"><i class="seraph icon-tuichu"></i><cite>退出登陆</cite></a></dd>
                    </dl>
                </li>
            </ul>
        </div>
    </div>
    <!-- 左侧导航 -->
    <div class="layui-side content-left">
        <div id="admincpNavTabs_shop" class="nav-tabs">
            <dl>
                <dt><a href="javascript:void(0);"><span class="ico-shop-0"></span>
                    <h3>商品管理</h3>
                </a></dt>
                <dd class="sub-menu">
                    <ul>
                        <li><a href="javascript:void(0);" data-url="<?php echo url('category/index'); ?>">商品类目</a></li>
                        <li><a href="javascript:void(0);" data-url="<?php echo url('product/index'); ?>">商品列表</a></li>
                        <li><a href="javascript:void(0);" data-url="<?php echo url('product/comment'); ?>">商品评价</a></li>
                        <li><a href="javascript:void(0);" data-url="<?php echo url('product/product'); ?>">商品添加</a></li>
                    </ul>
                </dd>
            </dl>
            <dl>
                <dt><a href="javascript:void(0);"><span class="ico-shop-1"></span>
                    <h3>订单管理</h3>
                </a></dt>
                <dd class="sub-menu">
                    <ul>
                        <li><a href="javascript:void(0);" data-url="<?php echo url('order/index'); ?>">订单列表</a></li>
                        <li><a href="javascript:void(0);" data-url="<?php echo url('order/index',['status'=>0]); ?>">待付款订单</a></li>
                        <li><a href="javascript:void(0);" data-url="<?php echo url('order/index',['status'=>1]); ?>">待发货订单</a></li>
                        <li><a href="javascript:void(0);" data-url="<?php echo url('order/index',['status'=>2]); ?>">待收货订单</a></li>
                        <li><a href="javascript:void(0);" data-url="<?php echo url('order/index',['status'=>3]); ?>">已完成订单</a></li>
                        <li><a href="javascript:void(0);" data-url="<?php echo url('order/index',['status'=>-1]); ?>">已取消订单</a></li>
                        <li><a href="javascript:void(0);" data-url="<?php echo url('order/index',['status'=>-2]); ?>">已退款订单</a></li>
                    </ul>
                </dd>
            </dl>
            <dl>
                <dt><a href="javascript:void(0);"><span class="ico-shop-2"></span>
                    <h3>售后管理</h3>
                </a></dt>
                <dd class="sub-menu">
                    <ul>
                        <li><a href="javascript:void(0);" data-url="<?php echo url('afterService/index'); ?>">退货退款列表</a></li>
                        <li><a href="javascript:void(0);" data-url="<?php echo url('productServiceTemplate/index'); ?>">售后服务模板</a></li>
                        <li><a href="javascript:void(0);" data-url="<?php echo url('storeAddress/index'); ?>">退货地址管理</a></li>
                        <li><a href="javascript:void(0);" data-url="<?php echo url('afterService/autoCheck'); ?>">退货审核管理</a></li>
                    </ul>
                </dd>
            </dl>
            <dl>
                <dt><a href="javascript:void(0);"><span class="ico-shop-3"></span>
                    <h3>物流管理</h3>
                </a></dt>
                <dd class="sub-menu">
                    <ul>
                        <li><a href="javascript:void(0);" data-url="<?php echo url('express/index'); ?>">快递公司列表</a></li>
                        <li><a href="javascript:void(0);" data-url="<?php echo url('region/index'); ?>">配送区域列表</a></li>
                        <li><a href="javascript:void(0);" data-url="<?php echo url('freight/index'); ?>">运费模板管理</a></li>
                    </ul>
                </dd>
            </dl>

            <dl>
                <dt><a href="javascript:void(0);"><span class="ico-shop-4"></span>
                    <h3>促销管理</h3>
                </a></dt>
                <dd class="sub-menu">
                    <ul>
                        <li><a href="javascript:void(0);" data-url="<?php echo url('shipping/index'); ?>">包邮工具</a></li>
                    </ul>
                </dd>
            </dl>
            <dl>
                <dt><a href="javascript:void(0);"><span class="ico-shop-5"></span>
                    <h3>商城设置</h3>
                </a></dt>
                <dd class="sub-menu">
                    <ul>
                        <li><a href="javascript:void(0);" data-url="<?php echo url('shop_home/index'); ?>">首页管理</a></li>
                        <li><a href="javascript:void(0);" data-url="<?php echo url('keyword/index'); ?>">热门关键词</a></li>
                        <li><a href="javascript:void(0);" data-url="<?php echo url('advert/index'); ?>">广告管理</a></li>
                        <li><a href="javascript:void(0);" data-url="<?php echo url('config/appWechat'); ?>">APP&&公众号</a></li>
                    </ul>
                </dd>
            </dl>
        </div>
        <div id="admincpNavTabs_community" class="nav-tabs">
        </div>
        <div id="admincpNavTabs_member" class="nav-tabs">
        </div>
        <div id="admincpNavTabs_system" class="nav-tabs">
            <dl>
                <dt><a href="javascript:void(0);"><span class="ico-shop-4"></span>
                    <h3>系统概览</h3>
                </a></dt>
                <dd class="sub-menu">
                    <ul>
                        <li><a href="javascript:void(0);" data-url="page/shop/ad/order.html">后台首页</a></li>
                    </ul>
                </dd>
            </dl>
            <dl>
                <dt><a href="javascript:void(0);"><span class="ico-shop-4"></span>
                    <h3>权限控制</h3>
                </a></dt>
                <dd class="sub-menu">
                    <ul>
                        <li><a href="javascript:void(0);" data-url="<?php echo url('rule/index'); ?>">权限管理</a></li>
                        <li><a href="javascript:void(0);" data-url="<?php echo url('group/index'); ?>">用户组管理</a></li>
                        <li><a href="javascript:void(0);" data-url="<?php echo url('admin/index'); ?>">管理员列表</a></li>
                    </ul>
                </dd>
            </dl>
            <dl>
                <dt><a href="javascript:void(0);"><span class="ico-shop-4"></span>
                    <h3>帮助中心</h3>
                </a></dt>
                <dd class="sub-menu">
                    <ul>
                        <li><a href="javascript:void(0);" data-url="<?php echo url('help_type/index'); ?>">帮助分类</a></li>
                        <li><a href="javascript:void(0);" data-url="<?php echo url('help/index'); ?>">帮助文档</a></li>
                    </ul>
                </dd>
            </dl>
        </div>
    </div>

    <!-- 右侧内容 -->
    <div class="layui-body layui-form">
        <div class="layui-tab mag0" lay-filter="bodyTab" id="top_tabs_box">
            <ul class="layui-tab-title top_tab" id="top_tabs">
                <li class="layui-this" lay-id=""><i class="layui-icon">&#xe68e;</i> <cite>后台首页</cite></li>
            </ul>
            <ul class="layui-nav closeBox">
                <li class="layui-nav-item"> <a href="javascript:;"><i class="layui-icon layui-icon-more"></i> 页面操作</a>
                    <dl class="layui-nav-child">
                        <dd><a href="javascript:;" class="refresh refreshThis"><i class="layui-icon layui-icon-refresh"></i> 刷新当前</a></dd>
                        <dd><a href="javascript:;" class="closePageOther"><i class="layui-icon layui-icon-templeate-1"></i> 关闭其他</a></dd>
                        <dd><a href="javascript:;" class="closePageAll"><i class=" layui-icon layui-icon-close-fill"></i> 关闭全部</a></dd>
                    </dl>
                </li>
            </ul>
            <div class="layui-tab-content clildFrame layui-border-box">
                <div class="layui-tab-item layui-show">
                    <iframe src="<?php echo url('main'); ?>"></iframe>
                </div>
            </div>
        </div>

    </div>
    <!-- 底部 -->
    <div class="layui-footer footer">
        <p><span>copyright @2018 管理员</span></p>
    </div>
</div>

<!-- 移动导航 -->
<div class="site-tree-mobile"><i class="layui-icon">&#xe602;</i></div>
<div class="site-mobile-shade"></div>
<script type="text/javascript" src="/static/admin/layui/layui.js"></script>
<script type="text/javascript" src="/static/admin/js/index.js"></script>
<script type="text/javascript" src="/static/admin/js/cache.js"></script>
</body>
</html>