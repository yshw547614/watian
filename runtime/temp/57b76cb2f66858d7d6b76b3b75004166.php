<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:75:"D:\phpweb\watian\webserver\public/../application/admin\view\index\main.html";i:1544338529;}*/ ?>
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
<link rel="stylesheet" href="/static/admin//css/public.css" media="all" />
</head>
<body class="childrenBody">
<blockquote class="layui-elem-quote layui-bg-green">
  <div id="nowTime"></div>
</blockquote>
<div class="layui-tab-item layui-show">
		<div class="fl">
			<table class="layui-table" lay-skin="line">
				<colgroup>
					<col width="160">
					<col>
				</colgroup>
				<thead>
				<tr>
					<th colspan="2">系统信息</th>
				</tr>
				</thead>
				<tbody>
				<tr>
					<td>当前版本</td>
					<td class="version"></td>
				</tr>
				<tr>
					<td>开发作者</td>
					<td class="author"></td>
				</tr>
				<tr>
					<td>网站首页</td>
					<td class="homePage"></td>
				</tr>
				<tr>
					<td>服务器环境</td>
					<td class="server"></td>
				</tr>
				<tr>
					<td>数据库版本</td>
					<td class="dataBase"></td>
				</tr>
				<tr>
					<td>最大上传限制</td>
					<td class="maxUpload"></td>
				</tr>
				<tr>
					<td>当前用户权限</td>
					<td class="userRights"></td>
				</tr>
				</tbody>
			</table>
		</div>
		<div class="fr">

		</div>
	</div>
</div>
<script type="text/javascript" src="/static/admin/layui/layui.js"></script>
<script type="text/javascript" src="/static/admin/js/main.js"></script>
</body>
</html>