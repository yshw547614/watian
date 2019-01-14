<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:86:"E:\phpWeb\watian\webserver\public/../application/admin\view\product_comment\index.html";i:1544602475;}*/ ?>
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
    <link rel="stylesheet" href="/static/admin/client/shop/comment/list.css" media="all" />
</head>
<body class="childrenBody">
<div class="layui-tab layui-tab-brief" lay-filter="tab_comment">
    <ul class="layui-tab-title">
        <li class="layui-this">待审核</li>
        <li>已拒绝</li>
        <li>已通过</li>
    </ul>
    <div class="layui-tab-content">
        <blockquote class="layui-elem-quote quoteBox white">
            <form class="layui-form search">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">时间范围</label>
                        <div class="layui-input-inline" style="width: 100px;">
                            <input type="text" name="price_min" placeholder="起始时间" autocomplete="off" class="layui-input">
                        </div>
                        <div class="layui-form-mid">-</div>
                        <div class="layui-input-inline" style="width: 100px;">
                            <input type="text" name="price_max" placeholder="结束时间" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <div class="layui-input-inline"  style="width: 120px;">
                            <input type="text" name="product_name" class="layui-input" placeholder="商品名称" />
                        </div>
                    </div>
                    <div class="layui-inline">
                        <div class="layui-input-inline" style="width: 120px;">
                            <select lay-filter="nation" name="status">
                                <option value="">评价等级</option>
                                <option value="1">好评</option>
                                <option value="2">中评</option>
                                <option value="3">差评</option>
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <div class="layui-input-inline" style="width: 120px;">
                            <select lay-filter="nation" name="status">
                                <option value="">用户满意度</option>
                                <option value="1">一星</option>
                                <option value="2">二星</option>
                                <option value="3">三星</option>
                                <option value="4">四星</option>
                                <option value="5">五星</option>
                            </select>
                        </div>
                    </div>

                    <div class="layui-inline">
                        <button type="button" class="layui-btn" lay-submit="" lay-filter="sreach"><i class="layui-icon layui-icon-search"></i></button>
                    </div>
                </div>
            </form>
        </blockquote>
        <table id="comments" lay-filter="comments"></table>
    </div>
</div>

<!--是否通过-->
<script type="text/html" id="is_pass">
    {{#  if(d.is_pass == "0"){ }}
    <span>待审核(<a data-id="{{d.id}}" href="javascript:" class="shenghe">审核</a>)</span>
    {{#  } else if(d.is_pass == "1"){ }}
    <input type="checkbox" data-id="{{d.id}}" name="is_pass" value="{{d.is_pass}}" lay-filter="changeIsPass" lay-skin="switch" lay-text="通过|拒绝"  lay-filter="is_pass" checked>
    {{#  } else { }}
    <input type="checkbox" data-id="{{d.id}}" name="is_pass" value="{{d.is_pass}}" lay-filter="changeIsPass" lay-skin="switch" lay-text="通过|拒绝"  lay-filter="is_pass">
    {{#  }}}

</script>
<!--评价等级-->
<script type="text/html" id="star">
    {{#  if(d.star == "1"){ }}
    <span class="layui-red">一星</span>
    {{#  } else if(d.star == "2"){ }}
    <span class="layui-blue">二星</span>
    {{#  } else if(d.star == "3"){ }}
    <span class="layui-blue">三星</span>
    {{#  } else if(d.star == "4"){ }}
    <span class="layui-blue">四星</span>
    {{#  } else { }}
    <span class="layui-blue">五星</span>
    {{#  }}}
</script>
<!--操作-->
<script type="text/html" id="commentListBar">
    <a class="layui-btn layui-btn-xs" lay-event="edit">查看</a>
    <a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="del">删除</a>
</script>
<script type="text/javascript" src="/static/admin/layui/layui.js"></script>
<script type="text/javascript" src="/static/admin/client/shop/comment/list.js"></script>
</body>
</html>