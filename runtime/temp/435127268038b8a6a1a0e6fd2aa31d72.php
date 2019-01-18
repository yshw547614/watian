<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:76:"E:\phpWeb\watian\webserver\public/../application/admin\view\login\login.html";i:1544602404;}*/ ?>
<!DOCTYPE html>
<html class="loginHtml">
<head>
    <meta charset="utf-8">
    <title>后台登录页面</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="icon" href="/static/admin/favicon.ico">
    <link rel="stylesheet" href="/static/admin/layui/css/layui.css" media="all" />
    <link rel="stylesheet" href="/static/admin/css/public.css" media="all" />
</head>
<body class="loginBody">
<form class="layui-form">
    <div class="login_face"><img src="/static/admin/images/face.jpg" class="userAvatar"></div>
    <div class="layui-form-item input-item">
        <label for="userName">用户名</label>
        <input type="text" name="name" placeholder="请输入用户名" id="userName" class="layui-input" lay-verify="required">
    </div>
    <div class="layui-form-item input-item">
        <label for="password">密码</label>
        <input type="password" name="password" placeholder="请输入密码" id="password" class="layui-input" lay-verify="required">
    </div>
    <div class="layui-form-item input-item" id="imgCode">
        <label for="code">验证码</label>
        <input type="text" name="code" placeholder="请输入验证码" id="code" class="layui-input">
        <img src="<?php echo url('verify'); ?>"  onclick="this.src='<?php echo url('verify'); ?>?'+Math.random();">
    </div>
    <div class="layui-form-item">
        <button type="button" type="button" class="layui-btn layui-block" lay-filter="login" lay-submit>登录</button>
    </div>
</form>
<script type="text/javascript" src="/static/admin/layui/layui.js"></script>
<script type="text/javascript" src="/static/admin/client/login/login.js"></script>
</body>
</html>