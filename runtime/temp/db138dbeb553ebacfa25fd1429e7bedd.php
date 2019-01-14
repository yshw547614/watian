<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:85:"E:\phpWeb\watian\webserver\public/../application/admin\view\after_service\detail.html";i:1544772766;}*/ ?>
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
    <link rel="stylesheet" href="/static/admin/client/shop/after_service/detail.css" media="all" />
</head>
<body class="childrenBody">
<input name="service_id" type="hidden" value="<?php echo $data['id']; ?>">
<fieldset class="layui-elem-field layui-field-title">
    <legend>基本信息</legend>
</fieldset>
<table class="layui-table">
    <colgroup>
        <col width="150">
        <col>
    </colgroup>
    <tbody>
        <tr>
            <td width="160">订单编号</td>
            <td colspan="2">
                <a href="<?php echo url('order/detail',['id'=>$data['order_id']]); ?>"><?php echo $data['order_no']; ?></a>
            </td>
        </tr>
        <tr>
            <?php if(!empty($data['user']['nickname']) && !empty($data['user']['head_img'])): ?>
            <td>申请用户</td>
            <td colspan="2">
                <img src="<?php echo $data['user']['head_img']; ?>" width="50" style="float: left; margin-right: 10px;">
                <p style="float:left; vertical-align: middle;"><?php echo $data['user']['nickname']; ?></p>
            </td>
            <?php else: ?>
            <td>用户id号</td>
            <td colspan="2">
                <?php echo $data['user']['id']; ?>
            </td>
            <?php endif; ?>

        </tr>
        <tr>
            <td width="160">售后进度</td>
            <?php if($data['status'] == 0): ?>
            <td width="80"><?php echo $data['refund']; ?></td>
            <td>
                <button class="layui-btn layui-btn-sm" type="button" id="through"> 确认通过</button>
            </td>
            <?php else: ?>
            <td colspan="2"><?php echo $data['refund']; ?></td>
            <?php endif; ?>

        </tr>

        <?php if($data['status'] == 2): ?>
        <tr>
            <td>用户发货物流信息</td>
            <td width="200">
                <p><span style="margin-right: 10px;">物流公司 :</span><?php echo $data['delivery']['express_name']; ?></p>
                <p><span style="margin-right: 10px;">快递单号 :</span>
                    <a href="https://m.kuaidi100.com/index_all.html?type=<?php echo $data['delivery']['express_code']; ?>&postid=<?php echo $data['delivery']['odd_number']; ?>" target="_blank"><?php echo $data['delivery']['odd_number']; ?></a>
                </p>
            </td>
            <td>
                <button class="layui-btn layui-btn-sm" type="button" id="confirm"> 确认收货</button>
            </td>
        </tr>
        <?php endif; if($data['status'] > 2): ?>
        <tr>
            <td>用户发货物流信息</td>
            <td colspan="2">
                <p><span style="margin-right: 10px;">物流公司 :</span><?php echo $data['delivery']['express_name']; ?></p>
                <p><span style="margin-right: 10px;">快递单号 :</span>
                    <a href="https://m.kuaidi100.com/index_all.html?type=<?php echo $data['delivery']['express_code']; ?>&postid=<?php echo $data['delivery']['odd_number']; ?>" target="_blank"><?php echo $data['delivery']['odd_number']; ?></a>
                </p>
            </td>
        </tr>
        <?php endif; ?>
        <tr>
            <td>退款金额</td>
            <?php if($data['status'] == 3): ?>
            <td width="100"><?php echo $data['refund_money']; ?>元</td>
            <td>
                <button class="layui-btn layui-btn-sm" type="button" id="return"> 确认退款</button>
                <span style="color: #CC0000"> （ 支付原路返回 ）</span>
            </td>
            <?php else: ?>
            <td colspan="2"><?php echo $data['refund_money']; ?>元</td>
            <?php endif; ?>

        </tr>
        <?php if(isset($data['logistic'])): ?>
        <tr>
            <td>退款时间</td>
            <td colspan="2"><?php echo $data['refund_money']; ?></td>
        </tr>
        <?php endif; ?>
        <tr>
            <td>申请时间</td>
            <td colspan="2"><?php echo $data['create_time']; ?></td>
        </tr>
    </tbody>
</table>
<fieldset class="layui-elem-field layui-field-title">
    <legend>售后商品列表</legend>
</fieldset>
<table class="layui-table product">
    <thead>
        <tr>
            <th>商品编号</th>
            <th>商品名称</th>
            <th>商品单价</th>
            <th>购买数量</th>
            <th>商品总价</th>
            <th>退款原因</th>
            <th>退款说明</th>
            <th>图片凭证</th>
        </tr>
    </thead>
    <tbody>
        <?php if(is_array($data['after_service_product']) || $data['after_service_product'] instanceof \think\Collection || $data['after_service_product'] instanceof \think\Paginator): $i = 0; $__LIST__ = $data['after_service_product'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?>
        <tr>
            <td>
                <a href="<?php echo url('product/edit',['id'=>$item['order_product']['product_id']]); ?>">
                    <?php echo $item['order_product']['product_sn']; ?>
                </a>
            </td>
            <td><?php echo $item['order_product']['name']; ?></td>
            <td><?php echo $item['order_product']['price']; ?></td>
            <td><?php echo $item['amount']; ?></td>
            <td><?php echo $item['order_product']['total_price']; ?></td>
            <td><?php echo $item['reason']; ?></td>
            <td>
                <?php if(empty($item['describe']) || (($item['describe'] instanceof \think\Collection || $item['describe'] instanceof \think\Paginator ) && $item['describe']->isEmpty())): ?>
                无
                <?php else: ?>
                <?php echo $item['describe']; endif; ?>
            </td>
            <td>
                <?php if(empty($item['images']) || (($item['images'] instanceof \think\Collection || $item['images'] instanceof \think\Paginator ) && $item['images']->isEmpty())): ?>
                无
                <?php else: if(is_array($item['images']) || $item['images'] instanceof \think\Collection || $item['images'] instanceof \think\Paginator): $i = 0; $__LIST__ = $item['images'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$image): $mod = ($i % 2 );++$i;?>
                <img src="<?php echo $image; ?>" width="50" height="50" class="bigPic">
                <?php endforeach; endif; else: echo "" ;endif; endif; ?>
            </td>
        </tr>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </tbody>
</table>
<script type="text/javascript" src="/static/admin/layui/layui.js"></script>
<script type="text/javascript" src="/static/admin/client/shop/after_service/detail.js"></script>
</body>
</html>