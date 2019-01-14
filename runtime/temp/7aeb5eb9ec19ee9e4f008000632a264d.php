<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:79:"D:\phpweb\watian\webserver\public/../application/admin\view\shipping\index.html";i:1544274657;}*/ ?>
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
    <link rel="stylesheet" href="/static/admin/client/shop/shipping/index.css" media="all" />
</head>
<body class="childrenBody">
<blockquote class="layui-elem-quote white backBar">
    <a class="layui-btn add-rule">添加包邮规则</a>
</blockquote>
<table id="list" lay-filter="list"></table>
<!--有效时间-->
<script type="text/html" id="valid_time">
    {{# if(d.is_long_term ===1){}}
    <span>长期有效</span>
    {{# }else{}}
    <span>{{d.start_time}} - {{d.end_time}}</span>
    {{# } }}
</script>
<!--规则状态-->
<script type="text/html" id="status">
    <select name="type[]" data-id="{{d.id}}" lay-filter="status" >
        {{#  if(d.type == -1){ }}
        <option value="-1" selected>已失效</option>
        {{#  } else { }}
        <option value="-1">已失效</option>
        {{#  }}}
        {{#  if(d.type == 0){ }}
        <option value="0" selected>未生效</option>
        {{#  } else { }}
        <option value="0">未生效</option>
        {{#  }}}
        {{#  if(d.type == 1){ }}
        <option value="1" selected>已生效</option>
        {{#  } else { }}
        <option value="1">已生效</option>
        {{#  }}}
    </select>
</script>
<!--操作-->

<script type="text/html" id="listBar">
    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
</script>
<script type="text/javascript" src="/static/admin/layui/layui.js"></script>
<script type="text/javascript" src="/static/admin/client/shop/shipping/index.js"></script>
</body>
</html>