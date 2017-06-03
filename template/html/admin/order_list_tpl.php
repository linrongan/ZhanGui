<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data=$obj->GetOrderList();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title><?php echo WEBNAME; ?></title>
    <link href="/template/html/admin/css/style.default.css" rel="stylesheet">
    <link href="/template/html/admin/css/jquery.datatables.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="/template/html/admin/js/html5shiv.js"></script>
    <script src="/template/html/admin/js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<section>
    <div class="mainpanel">
        <div class="pageheader">
            <h2> 订单管理 <span>普通订单</span></h2>
            <div class="breadcrumb-wrapper">
                <span class="label">当前导航:</span>
                <ol class="breadcrumb">
                    <li><a href="">导航</a></li>
                    <li class="active">订单管理</li>
                </ol>
            </div>
        </div>

        <div class="contentpanel">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form class="form-inline" method="post" action="">
                        <div class="form-group">
                            <input value="<?php echo isset($_REQUEST['orderid'])?$_REQUEST['orderid']:''; ?>" type="text" placeholder="请输入订单号" id="orderid" name="orderid" class="form-control">
                            <select class="form-control mb13" name="order_status">
                                <option value="">请选择订单状态</option>
                                <?php
                                foreach($Sys_Order_Status as $key=>$item){
                                    ?>
                                    <option <?php echo isset($_REQUEST['order_status']) && $_REQUEST['order_status']=="$key"?'selected':''; ?> value="<?php echo $key; ?>"><?php echo $item; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <button class="btn btn-primary" type="submit">查询</button>
                        <a href="/?mod=admin&v_mod=order&_index=_list" class="btn btn-default">取消</a>
                    </form>
                </div><!-- panel-body -->
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive dataTable">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>订单号</th>
                                <th>微信</th>
                                <th>订单金额</th>
                                <th>收货人</th>
                                <th>详细地址</th>
                                <th>订单时间</th>
                                <th>状态</th>
                                <th>编辑</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($data['data'])){
                                foreach($data['data'] as $item){
                                    $items = $obj->GetOrderItem($item['orderid']);
                                    ?>
                                    <tr class="odd gradeX">
                                        <td class="center">
                                            <?php echo $item['orderid'] ?>
                                        </td>
                                        <td class="center">
                                            <img src="<?php echo $item['headimgurl']; ?>" width="50" alt=""><br>
                                            <?php echo $item['nickname']?$item['nickname']:'未知'; ?>
                                        </td>
                                        <td class="center">
                                            ￥<?php echo $item['order_total']; ?>
                                        </td>
                                        <td class="center">
                                            <?php echo $item['order_ship_name']; ?>
                                        </td>
                                        <td class="center">
                                            <?php echo $item['order_ship_sheng']; ?>
                                            <?php echo $item['order_ship_shi']; ?>
                                            <?php echo $item['order_ship_qu']; ?><br>
                                            <?php echo $item['order_ship_address']; ?><br>
                                            <?php echo $item['order_ship_phone']; ?>
                                        </td>
                                        <td class="center">
                                            <?php echo $item['order_addtime']; ?>
                                        </td>
                                        <td class="center"><?php echo $Sys_Order_Status[$item['order_status']]; ?></td>
                                        <td class="center">
                                            <a href="?mod=admin&v_mod=order&_index=_edit&id=<?php echo $item['id']; ?>"><span class="fa fa-edit"></span></a>
                                            <a title="删除" onclick="return confirm('是否删除?')" href="?mod=admin&v_mod=order&_index=_list&_action=ActionDelOrder&id=<?php echo $item['id']; ?>"><span class="fa fa-trash-o"></span></a>
                                        </td>
                                    </tr>
                                <?php }
                            } ?>
                            </tbody>
                        </table>
                        <?php
                        include RPC_DIR ."/inc/page_nav.php";
                        $page=new page_nav(array("total"=>$data['total'],
                            "page_size"=>$data['page_size'],
                            "curpage"=>$data['curpage'],
                            "extUrl"=>"",
                            "canshu"=>'&mod='.$_GET['mod'].'&v_mod='.$_GET['v_mod'].'&_index=_list'.$data['canshu']));
                        echo $page->page_nav();
                        ?>
                    </div>
                    <div class="clearfix mb30"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="/template/source/js/jquery.js"></script>
<script src="/tool/layer/layer/layer.js"></script>
<?php include 'footer_tpl.php'; ?>
</body>
<script>
    function show_msg(id){
        layer.open({
            type: 2,
            title: '订单'+id+'支付日志',
            shadeClose: true,
            shade: 0.8,
            area: ['380px', '90%'],
            content: '/?mod=admin&v_mod=order&_index=_msg&orderid='+id //iframe的url
        });
    }
</script>
</html>