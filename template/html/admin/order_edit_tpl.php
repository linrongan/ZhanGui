<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetOrderDetail();
$detail = $obj->GetOrderItem($data['orderid']);
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
            <h2> 订单管理 <span>订单列表</span> <span>编辑</span></h2>
            <div class="breadcrumb-wrapper">
                <span class="label">当前导航:</span>
                <ol class="breadcrumb">
                    <li><a href="">导航</a></li>
                    <li class="active">订单管理</li>
                </ol>
            </div>
        </div>
        <div class="contentpanel">
            <div class="row">
                <div class="col-md-6">
                    <form class="form-horizontal" method="post"
                          action="/?mod=admin&v_mod=order&_index=_edit&id=<?php echo $_GET['id']; ?>&_action=ActionEditAddressInfo" id="infoform">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-btns">
                                    <a class="panel-close" href="">×</a>
                                    <a class="minimize" href="">−</a>
                                </div>
                                <h4 class="panel-title">收货人信息</h4>
                                <p></p>
                            </div>
                            <div class="panel-body">

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">收货人<span class="asterisk">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" required name="shop_name" placeholder="输入收货人信息..." class="form-control" value="<?php echo $data['order_ship_name']; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">联系电话<span class="asterisk">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="tel" required  placeholder="输入联系电话..." class="form-control" name="shop_phone" value="<?php echo $data['order_ship_phone']; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">地址</label>
                                    <div class="col-sm-3">
                                        <input type="text" placeholder="输入省..." name="order_ship_sheng" class="form-control" value="<?php echo $data['order_ship_sheng']; ?>"/>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" placeholder="输入市..." name="order_ship_shi" class="form-control" value="<?php echo $data['order_ship_shi']; ?>"/>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" placeholder="" name="order_ship_qu" class="form-control" value="<?php echo $data['order_ship_qu']; ?>"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">详细地址<span class="asterisk">*</span></label>
                                    <div class="col-sm-9">
                                        <textarea required name="shop_address" name="shop_address" placeholder="请填写详细的地址..." class="form-control" rows="5"><?php echo $data['order_ship_address']; ?></textarea>
                                    </div>
                                </div>



                                <div class="form-group">
                                    <label class="col-sm-3 control-label">物流公司
                                        <span class="asterisk">*</span></label>
                                    <div class="col-sm-9 control-label">
                                        <input type="text" value="<?php echo $data['wuliu_com']; ?>"  placeholder="请输入物流公司名称..." title="" class="form-control" name="logistics_name">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">货运单号
                                        <span class="asterisk">*</span></label>
                                    <div class="col-sm-9 control-label">
                                        <input type="text" value="<?php echo $data['wuliu_no']; ?>"  placeholder="请输入货运单号..." title="" class="form-control" name="logistics_number">
                                    </div>
                                </div>

                            </div><!-- panel-body -->
                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-sm-9 col-sm-offset-3">
                                        <button class="btn btn-primary">提交</button>
                                        <a class="btn btn-default" href="?mod=admin&v_mod=order&_index=_list">返回</a>
                                    </div>
                                </div>
                            </div>

                        </div><!-- panel -->
                    </form>

                </div>

                <!-- col-md-6 -->
                <form class="form-horizontal"
                      action="/?mod=admin&v_mod=order&_index=_edit&_action=EditOrderStatus&id=<?php echo $_GET['id']; ?>" id="basicForm2" method="post">
                    <!-- col-md-6 -->
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-btns">
                                    <a class="panel-close" href="">×</a>
                                    <a class="minimize" href="">−</a>
                                </div>
                                <h4 class="panel-title">订单信息</h4>
                                <p></p>
                            </div>
                            <div class="panel-body">
                                <div class="error"></div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">订单号码
                                    </label>
                                    <div class="col-sm-7 control-label">
                                        <?php echo $data['orderid']; ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">下单时间
                                    </label>
                                    <div class="col-sm-7 control-label">
                                        <?php echo $data['order_addtime']; ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">订单用户
                                    </label>
                                    <div class="col-sm-7 control-label">
                                        <?php echo $data['nickname']; ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">订单金额
                                    </label>
                                    <div class="col-sm-7 control-label">
                                        <?php echo $data['order_total']; ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                        <label class="col-sm-3 control-label">订单备注
                                        </label>
                                        <div class="col-sm-7 control-label">
                                            <?php echo $data['liuyan']?$data['liuyan']:'无'; ?>
                                        </div>
                                    </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">订单状态</label>
                                    <div class="col-sm-7 control-label">
                                        <?php echo $Sys_Order_Status[$data['order_status']]; ?>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-sm-3 control-label">订单状态</label>
                                    <div class="col-sm-5">
                                        <select class="form-control mb13" name="order_status">
                                            <?php
                                                foreach($Sys_Order_Status as $k=>$v)
                                                {
                                                    ?>
                                                    <option <?php if($data['order_status']==$k){echo 'selected';} if($k<$data['order_status']){echo 'disabled';} ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                            </div><!-- panel-body -->
                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-sm-9 col-sm-offset-3">
                                        <button class="btn btn-primary" type="submit">更新</button>
                                        <a class="btn btn-default" href="?mod=admin&v_mod=order&_index=_list">返回</a>
                                    </div>
                                </div>
                            </div>
                        </div><!-- panel -->
                    </div></form>
            </div>

            <div class="contentpanel">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h5 class="subtitle mb5">订单列表</h5>
                        <br />
                        <div class="table-responsive dataTable">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>产品编号</th>
                                    <th>产品图</th>
                                    <th>产品名称</th>
                                    <th>单价*数量</th>
                                    <th>属性</th>
                                    <th>合计</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (!empty($detail)){
                                    foreach($detail as $item){
                                        ?>
                                        <tr class="odd gradeX">
                                            <td class="center">
                                                <?php echo $item['product_id']; ?>
                                            </td>
                                            <td class="center">
                                                <img width="50"  src="<?php echo $item['product_img']; ?>" alt="">
                                            </td>
                                            <td class="center">
                                                <?php echo $item['product_name']; ?>
                                            </td>
                                            <td class="center">
                                                <?php echo $item['product_price'].'x'.$item['product_count']; ?>
                                            </td>
                                            <td class="center">
                                                <?php echo $item['product_attr_name']; ?>
                                            </td>
                                            <td class="center">
                                                <?php echo $item['product_sum_price']; ?>
                                            </td>
                                        </tr>
                                    <?php }
                                } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="clearfix mb30"></div>
                    </div>
                </div>
            </div>
        </div>
</section>
<script src="/template/source/js/jquery.js"></script>
<script src="/tool/CheckForm/dist/jquery.validate.js"></script>
<script src="/template/source/js/comm.js"></script>
<?php include "footer_tpl.php"; ?>
<script>
$(function(){
   $("#infoform").validate();
});
</script>
</body>
</html>
