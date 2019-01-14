<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:82:"E:\phpWeb\watian\webserver\public/../application/admin\view\logistics\express.html";i:1544602410;}*/ ?>
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
    <link rel="stylesheet" href="/static/admin/client/shop/logistics/express.css" media="all" />
</head>
<body class="childrenBody">
<blockquote class="layui-elem-quote white">
    <form class="layui-form layui-form-pane" action="">
        <div class="layui-form-item">
            <label class="layui-form-label">公司名称</label>
            <div class="layui-input-inline">
                <input type="text" name="title" required  lay-verify="required" placeholder="请输入快递公司名称" autocomplete="off" class="layui-input">
            </div>

            <label class="layui-form-label">快递编码</label>
            <div class="layui-input-inline">
                <input type="text" name="code" required  lay-verify="required" placeholder="请输入快递公司编码" autocomplete="off" class="layui-input">
            </div>

            <label class="layui-form-label">接口类型</label>
            <div class="layui-input-inline">
                <select name="type" lay-verify="required">
                    <option value="0" >快递100</option>
                    <option value="1">国际快递</option>
                    <option value="2">其他快递</option>
                </select>
            </div>
            <div class="layui-input-inline">
                <button type="button" class="layui-btn" lay-submit lay-filter="submit">添加快递公司</button>
            </div>
        </div>
    </form>
</blockquote>
<table id="list" lay-filter="list"></table>
<!--评价等级-->
<script type="text/html" id="type">
    <select name="type[]" data-id="{{d.id}}" class="express_type" lay-filter="express_type" lay-event="express_type">
        {{#  if(d.type == 0){ }}
        <option value="0" selected>快递100</option>
        {{#  } else { }}
        <option value="0">快递100</option>
        {{#  }}}
        {{#  if(d.type == 1){ }}
        <option value="1" selected>国际快递</option>
        {{#  } else { }}
        <option value="1">国际快递</option>
        {{#  }}}
        {{#  if(d.type == 2){ }}
        <option value="2" selected>其他快递</option>
        {{#  } else { }}
        <option value="2">其他快递</option>
        {{#  }}}

    </select>
</script>
<!--操作-->
<script type="text/html" id="listBar">
    <a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="del">删除</a>
</script>
<script type="text/javascript" src="/static/admin/layui/layui.js"></script>
<script type="text/javascript" src="/static/admin/client/shop/logistics/express.js"></script>
</body>
</html>