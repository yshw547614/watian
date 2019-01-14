<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:78:"D:\phpweb\watian\webserver\public/../application/admin\view\freight\index.html";i:1544168626;}*/ ?>
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
    <link rel="stylesheet" href="/static/admin/client/shop/freight/index.css" media="all" />
</head>
<body class="childrenBody">
<blockquote class="layui-elem-quote white">
    <a class="layui-btn layui-btn-sm addTemplate">添加运费模板</a>
</blockquote>
<?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?>
    <div class="freight_templet">
    <table class="layui-table head-table" lay-skin="line">
        <colgroup>
            <col width="150">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <td>
                <?php echo $item['name']; switch($item['type']): case "1": ?>重量<?php break; case "2": ?>体积<?php break; default: ?>件数
                <?php endswitch; ?>
            </td>
            <td style="text-align: right">
                <a data-id="<?php echo $item['id']; ?>"><i class="layui-icon layui-icon-edit"></i></a>
                <a data-id="<?php echo $item['id']; ?>"><i class="layui-icon layui-icon-delete"></i></a>
            </td>
        </tr>
        </tbody>
    </table>
    <table class="layui-table">
        <tr>
            <th>配送区域</th>
            <th>首<?php echo $item['unit_name']; ?></th>
            <th>运费(元)</th>
            <th>续<?php echo $item['unit_name']; ?></th>
            <th>运费(元)</th>
        </tr>
        <?php if(is_array($item['config']) || $item['config'] instanceof \think\Collection || $item['config'] instanceof \think\Paginator): $i = 0; $__LIST__ = $item['config'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$config): $mod = ($i % 2 );++$i;?>
        <tr>
            <td>
                <?php if(is_array($config['region']) || $config['region'] instanceof \think\Collection || $config['region'] instanceof \think\Paginator): $i = 0; $__LIST__ = $config['region'];if( count($__LIST__)==0 ) : echo "中国" ;else: foreach($__LIST__ as $key=>$region): $mod = ($i % 2 );++$i;if($i == count($config['region'])): ?>
                        <?php echo $region['name']; else: ?>
                         <?php echo $region['name']; ?>,
                    <?php endif; endforeach; endif; else: echo "中国" ;endif; ?>
            </td>
            <td><?php echo $config['first_unit']; ?></td>
            <td><?php echo $config['first_money']; ?></td>
            <td><?php echo $config['continue_unit']; ?></td>
            <td><?php echo $config['continue_money']; ?></td>
        </tr>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </table>
    </div>
<?php endforeach; endif; else: echo "" ;endif; ?>
<script type="text/javascript" src="/static/admin/layui/layui.js"></script>
<script type="text/javascript" src="/static/admin/client/shop/freight/template.js"></script>
</body>
</html>
