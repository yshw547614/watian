<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:77:"E:\phpWeb\watian\webserver\public/../application/admin\view\order\detail.html";i:1545012650;}*/ ?>
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
    <link rel="stylesheet" href="/static/admin/client/shop/order/detail.css" media="all" />
</head>
<body class="childrenBody">

<fieldset class="layui-elem-field layui-field-title">
    <legend>订单信息</legend>
</fieldset>
<table class="layui-table" id="order_info">
    <colgroup>
        <col width="200">
        <col>
    </colgroup>
    <tbody>
        <tr>
            <td>订单编号</td>
            <td><?php echo $data['order_no']; ?></td>
        </tr>
        <tr>
            <td>用户信息</td>
            <td>
                <?php if(!empty($data['user']['nickname']) && !empty($data['user']['head_img'])): ?>
                <img src="<?php echo $data['user']['head_img']; ?>" width="50" height="50" style="float:left;">
                <p style="line-height: 50px; float:left; margin-left:10px;"><?php echo $data['user']['nickname']; ?></p>
                <?php else: ?>
                <?php echo $data['user']['nickname']; ?>(用户id)
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>商品总价</td>
            <td><?php echo $data['product_price']; ?></td>
        </tr>
        <tr>
            <td>运费金额</td>
            <td><?php echo $data['shipping_price']; ?></td>
        </tr>
        <tr>
            <td>实付金额</td>
            <td><?php echo $data['order_price']; ?></td>
        </tr>
        <tr>
            <td>订单状态</td>
            <td><?php echo $data['status_china']; ?></td>
        </tr>
        <?php if($data['invoice_title']!=''): ?>
        <tr>
            <td>发票抬头</td>
            <td><?php echo $data['invoice_title']; ?></td>
        </tr>
        <?php endif; if($data['taxpayer']!=''): ?>
        <tr>
            <td>纳税人识别号</td>
            <td><?php echo $data['taxpayer']; ?></td>
        </tr>
        <?php endif; if($data['remark']!=''): ?>
        <tr>
            <td>用户备注</td>
            <td><?php echo $data['remark']; ?></td>
        </tr>
        <?php endif; ?>
        <tr>
            <td>下单时间</td>
            <td><?php echo $data['create_time']; ?></td>
        </tr>
    </tbody>
</table>
<fieldset class="layui-elem-field layui-field-title">
    <legend>收货人信息</legend>
</fieldset>
<table  class="layui-table">

    <tr>
        <td width="160">姓名</td>
        <td><?php echo $data['snap_address']->name; ?></td>
    </tr>
    <tr>
        <td width="160">电话</td>
        <td><?php echo $data['snap_address']->mobile; ?></td>
    </tr>
    <tr>
        <td width="160">地址</td>
        <td><?php echo $data['snap_address']->province; ?> <?php echo $data['snap_address']->city; ?>
            <?php echo $data['snap_address']->country; ?> <?php echo $data['snap_address']->detail; ?></td>
    </tr>
</table>
<fieldset class="layui-elem-field layui-field-title">
    <legend>商品信息</legend>
</fieldset>
<table   class="layui-table">
    <tr>
        <td width="10%">商品编号</td>
        <td width="30%">商品名称</td>
        <td width="15%">商品单价</td>
        <td width="15%">商品数量</td>
        <td width="15%">商品总价</td>
        <td width="15%">状态</td>
    </tr>
    <?php if(is_array($data['snap_items']) || $data['snap_items'] instanceof \think\Collection || $data['snap_items'] instanceof \think\Paginator): $i = 0; $__LIST__ = $data['snap_items'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?>
    <tr>
        <td width="10%"><?php echo $item['product']['product_sn']; ?></td>
        <td width="30%"><?php echo $item['name']; ?></td>
        <td width="15%"><?php echo $item['price']; ?></td>
        <td width="15%"><?php echo $item['count']; ?></td>
        <td width="15%"><?php echo $item['total_price']; ?></td>
        <td width="15%"><?php echo $item['is_return']; ?></td>
    </tr>
    <?php endforeach; endif; else: echo "" ;endif; ?>
</table>

<?php if($data['status'] == 1): ?>
<fieldset class="layui-elem-field layui-field-title">
    <legend>物流信息</legend>
</fieldset>
<form class="layui-form" action="">
    <table class="layui-table">
        <colgroup>
            <col width="200">
            <col>
        </colgroup>
        <tbody>
            <tr>
                <td>快递公司</td>
                <td>
                    <input type="hidden" name="order_id" value="<?php echo $data['id']; ?>">
                    <div class="layui-input-inline" style="width: 300px">
                        <select name="company">
                            <?php if(is_array($data['express']) || $data['express'] instanceof \think\Collection || $data['express'] instanceof \think\Paginator): $i = 0; $__LIST__ = $data['express'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo $item['id']; ?>"><?php echo $item['title']; ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td>快递单号</td>
                <td>
                    <div class="layui-input-inline" style="width: 300px">
                    <input type="text" class="layui-input" name="odd_number" required placeholder="请输入快递单号" autocomplete="off" />
                    </div>
                </td>
            </tr>
            <tr>
                <td>操作</td>
                <td>
                    <button class="layui-btn layui-btn-sm delivery" type="button" lay-filter="submit"> 确认发货</button>
                </td>
            </tr>
        </tbody>
    </table>
</form>
<?php endif; if($data['status'] == 2): ?>
<form class="layui-form" action="">
<fieldset class="layui-elem-field layui-field-title">
    <legend>物流信息</legend>
</fieldset>

<table class="layui-table">
    <colgroup>
        <col width="200">
        <col>
    </colgroup>
    <tbody>
        <tr>
            <td>快递公司</td>
            <td>
                <input type="hidden" name="order_id" value="<?php echo $data['id']; ?>">
                <div class="layui-input-inline" style="width: 300px">
                <select name="company">
                    <?php if(is_array($data['express']) || $data['express'] instanceof \think\Collection || $data['express'] instanceof \think\Paginator): $i = 0; $__LIST__ = $data['express'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;if($data['express_id'] == $item['id']): ?>
                    <option value="<?php echo $item['id']; ?>" selected><?php echo $item['title']; ?></option>
                    <?php else: ?>
                    <option value="<?php echo $item['id']; ?>"><?php echo $item['title']; ?></option>
                    <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                </select>
                </div>
            </td>
        </tr>
        <tr>
            <td>快递单号</td>
            <td>
                <div class="layui-input-inline" style="width: 300px">
                    <input type="text" class="layui-input" name="odd_number" required value="<?php echo $data['odd_number']; ?>"/>
                </div>
            </td>
        </tr>
        <tr>
            <td>操作</td>
            <td>
                <button  class="layui-btn layui-btn-sm delivery" type="button" lay-filter="submit"> 确认修改</button>
            </td>
        </tr>
    </tbody>
</table>
</form>
<?php endif; if($data['status'] == 3): ?>
<fieldset class="layui-elem-field layui-field-title">
    <legend>物流信息</legend>
</fieldset>
<table   class="layui-table">
    <colgroup>
        <col width="200">
        <col>
    </colgroup>
    <tbody>
        <tr>
            <td>快递公司</td>
            <td><?php echo $data['express_title']; ?></td>

        </tr>
        <tr>
            <td>快递单号</td>
            <td><?php echo $data['odd_number']; ?></td>
        </tr>
        <tr>
            <td>操作</td>
            <td>
                <a  class="layui-btn layui-btn-sm" target="_blank"> 查看物流信息</a>
            </td>
        </tr>
    </tbody>
</table>
<?php endif; ?>
<script type="text/javascript" src="/static/admin/layui/layui.js"></script>
<script type="text/javascript" src="/static/admin/client/shop/order/detail.js"></script>
</body>
</html>