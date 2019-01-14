<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:76:"E:\phpWeb\watian\webserver\public/../application/admin\view\order\index.html";i:1544756731;}*/ ?>
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
    <link rel="stylesheet" href="/static/admin/client/shop/order/list.css" media="all" />
</head>
<body class="childrenBody">
<blockquote class="layui-elem-quote quoteBox white">
    <form class="layui-form search">
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">时间范围</label>
                <div class="layui-input-inline" style="width: 120px;">
                    <input type="text" id="begin_time" name="begin_time" placeholder="起始时间" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid">-</div>
                <div class="layui-input-inline" style="width: 120px;">
                    <input type="text" id="end_time" name="end_time" placeholder="结束时间" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-inline">
                <div class="layui-input-inline"  style="width: 150px;">
                    <input type="text" name="order_id" class="layui-input" placeholder="请输入订单ID" />
                </div>
            </div>
            <div class="layui-inline">
                <div class="layui-input-inline"  style="width: 150px;">
                    <input type="text" name="order_no" class="layui-input" placeholder="请输入订单编号" />
                </div>
            </div>

            <div class="layui-inline status-box">
                <div class="layui-input-inline"  style="width: 120px;">
                    <select name="status" lay-filter="status">
                        <option value="">订单状态</option>
                        <option value="0">待支付</option>
                        <option value="1">待发货</option>
                        <option value="2">待收货</option>
                        <option value="3">已完成</option>
                        <option value="-1">已取消</option>
                        <option value="-2">已退款</option>
                    </select>
                </div>
            </div>
            <div class="layui-inline">
                <div class="layui-input-inline"  style="width: 120px;">
                    <input type="text" name="name" class="layui-input" placeholder="收货人姓名" />
                </div>
            </div>
            <div class="layui-inline">
                <div class="layui-input-inline"  style="width: 120px;">
                    <input type="text" name="mobile" class="layui-input" placeholder="收货人手机号码" />
                </div>
            </div>
            <div class="layui-inline">
                <button type="button" class="layui-btn" lay-submit="" lay-filter="search">
                    <i class="layui-icon layui-icon-search"></i>
                </button>
            </div>
        </div>
    </form>
</blockquote>
<table id="list" lay-filter="list"></table>

<script type="text/html" id="user">
<img src="{{d.head_img}}" width="40" height="40">
<span>{{d.nickname}}</span>
</script>
<!--订单状态-->
<script type="text/html" id="status">
    {{#
        switch(d.status){
            case -2:
    }}
    <span style="color: #009688">已退款</span>
    {{#
            break;
            case -1:
    }}
    <span style="color: #5FB878">已取消</span>
    {{#
            break;
            case 0:
    }}
    <span style="color: #1E9FFF">待支付</span>
    {{#
            break;
            case 1:
    }}
    <span style="color: #FFB800">待发货</span>
    {{#
            break;
            case 2:
    }}
    <span style="color: #FF5722">待收货</span>
    {{#
            break;
            case 3:
    }}
    <span style="color: #2F4056">已完成</span>
    {{# } }}
</script>
<!--操作-->
<script type="text/html" id="listBar">
    <a class="layui-btn layui-btn-xs" lay-event="edit">查看</a>
    <a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="del">删除</a>
</script>
<script type="text/javascript" src="/static/admin/layui/layui.js"></script>
<script type="text/javascript" src="/static/admin/client/shop/order/list.js"></script>
</body>
</html>