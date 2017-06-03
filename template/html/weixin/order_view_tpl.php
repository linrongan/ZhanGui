<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetViewOrder();
$user = $obj->GetUserInfo($_SESSION['userid']);
$details = $obj->GetOrderDetails($data['orderid']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone = no"/>
    <title><?php echo WEBNAME; ?></title>
    <link type="text/css" rel="stylesheet" href="/template/source/css/font.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/rest.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/ggPublic.css?66666aaaa">
    <link type="text/css" rel="stylesheet" href="/template/source/css/main.css">
    <script src="/template/source/js/jquery-1.10.1.min.js"></script>
    <style>
		.weui-cell{padding:.14rem 3%;}
		.weui-cells::before,.weui-cells::after,.weui-cells .weui-cell::before{border:none;}
		.weui-cell:before{left:0;}
		.wuliu-btn{display:inline-block; padding:3px 8px; border:1px solid #333; border-radius:3px; color:#333;}
		.porduct_hd{background:white; border-bottom:none; padding:.1rem 3%;}
		.porduct_jshao:last-child{border-bottom:none;}
		.noborder .weui-cell{padding:0 3%; line-height:.5rem;}
    </style>
</head>
<body>
	
    <div class="weui-cells" style="margin-top:0;">
    	<div class="weui-cell" style=" border-bottom:1px solid #e8e8e8;">
        	<div class="weui-cell__hd">
            	<span class="redColor sz14r">状态：</span>
            </div>
        	<div class="weui-cell__bd">
            	<span class="redColor sz14r"><?php echo $Sys_Order_Status[$data['order_status']]; ?></span>
            </div>
            <div class="weui-cell__ft">
                <?php
                    if($data['order_status']==1)
                    {
                        if($data['expiry_date']>time())
                        {
                            if($data['store_id']==0)
                            {
                                $url = '?mod=weixin&v_mod=checkout&_index=_pay&orderid='.$data['orderid'];
                            }else {
                                $url = '/?mod=weixin&v_mod=direct_checkout&_index=_pay&type=3&orderid='.$data['orderid'];
                            }
                            echo '<a href="'.$url.'" class="wuliu-btn sz12r">付款</a>';
                        }else{
                            echo '<a href="javascript:;" id="qx_order" class="wuliu-btn sz12r">取消</a>';
                        }
                    }elseif($data['order_status']==4)
                    {
                        echo '<a href="javascript:;" id="sh_order" class="wuliu-btn sz12r">确认收货</a>';
                    }elseif($data['order_status']==6)
                    {
                        echo '<a href="/?mod=weixin&v_mod=product&_index=_comment&orderid='.$_GET['orderid'].'" id="pj_order" class="wuliu-btn sz12r">去评价</a>';
                    }
                ?>
            </div>
        </div>
        <?php
            if($data['order_status']==1)
            {
                ?>
                <div class="weui-cell" style=" border-bottom:1px solid #e8e8e8;">
                    <div class="weui-cell__hd">
                        <span class="redColor sz14r">剩余支付时间：</span>
                    </div>
                    <div class="weui-cell__bd">
                        <span class="redColor sz14r"></span>
                    </div>
                    <div class="weui-cell__ft sz12r" id="over_time"></div>
                </div>
                <?php
            }
        ?>
        <script>
            function p (n)
            {
                var a = n || '';
                return a < 10 ? '0'+ a : a;
            }
            function d(n)
            {
                if(n > 0){
                    return n +'天';
                }else{
                    return ''
                }
            }
            var countDown = <?php echo $data['expiry_date']-time()?$data['expiry_date']-time():0; ?>;
			console.log(countDown);
            function newTime()
            {	
                var startTime = new Date();
                countDown = countDown - 1;
                //算出中间差并且已毫秒数返回; 除以1000将毫秒数转化成秒数方便运算；
                //var countDown = (endTime.getTime() - startTime.getTime()) / 1000;
                //获取天数 1天 = 24小时  1小时= 60分 1分 = 60秒
                var oDay = Math.floor(countDown/(24*60*60));
                //获取小时数
                //特别留意 %24 这是因为需要剔除掉整的天数;
                var oHours = Math.floor(countDown/(60*60)%24);
                //获取分钟数
                //同理剔除掉分钟数
                var oMinutes = Math.floor(countDown/60%60);
                //获取秒数
                //因为就是秒数  所以取得余数即可
                var oSeconds = Math.floor(countDown%60);
                var myMS=Math.floor(countDown/100) % 10;
                //下面就是插入到页面事先准备容器即可;
                var html = d(oDay) +""+ p(oHours) +"小时"+ p(oMinutes) +"分"+ p(oSeconds) +"秒";
                //别忘记当时间为0的，要让其知道结束了;
                if(countDown < 0){
                    $("#over_time").html("支付逾期");
                }else{
                    $("#over_time").html(html);
                }
            }
            setInterval(newTime,1000);
            newTime();
        </script>
        <div class="weui-cell" style=" border-bottom:1px solid #e8e8e8;">
        	<div class="weui-cell__hd">
            	<span class="sz14r cl999">收货人：</span>
            </div>
        	<div class="weui-cell__bd">
            	<span class="sz14r cl999"><?php echo $data['order_ship_name']; ?></span>
            </div>
            <div class="weui-cell__ft">
            	<span class="sz14r cl999"><?php echo $data['order_ship_phone']; ?></span>
            </div>
        </div>
        <div class="weui-cell">
        	<div class="weui-cell__hd">
            	<span class="sz14r cl999">收货地址：</span>
            </div>
        	<div class="weui-cell__bd">
            	<span class="sz14r cl999"><?php echo $data['order_ship_address']; ?></span>
            </div>
        </div>
    </div>
    
    <?php
        if($data['order_status']>3)
        {
            ?>
            <div class="weui-cells mtr01">
                <div class="weui-cell">
                    <div class="weui-cell__hd">
                        <span class="sz14r">物流公司：</span>
                    </div>
                    <div class="weui-cell__bd">
                        <span class="sz14r"><?php echo $data['wuliu_com']; ?></span>
                    </div>
                    <div class="weui-cell__ft">
                        <a href="javascript:;" onclick="<?php
                            if(!empty($data['wuliu_no']))
                            {
                                echo 'location.href=\'?mod=weixin&v_mod=order&_index=_wuliu&no='.$data['wuliu_no'].'\'';
                            }else{
                                echo 'layer_msg(\'物流单号异常\')';
                            }
                        ?>" class="wuliu-btn sz12r">物流详情</a>
                    </div>
                </div>
            </div>
            <?php
        }
    ?>
    
  
    <div class="mtr02" >
        <div class="porduct_hd">
           <span class="sz14r"><?php echo $user['username']?$user['username']:$user['nickname'];?></span>
        </div>
        <?php
            for($i=0;$i<count($details);$i++)
            {
                ?>
                <div class="porduct_jshao">
                    <div class="fl l_porpic" onclick="location.href='/?mod=weixin&v_mod=product&_index=_details&id=<?php echo $details[$i]['product_id']; ?>'">
                        <img src="<?php echo $details[$i]['product_img']; ?>">
                    </div>
                    <div class="fl r_porname">
                        <p class="porduct_name tlie sz14r"><?php echo $details[$i]['product_name']; ?></p>
                        <div class="mtr01 sz12r">
                            价格：<span class="redColor">￥<?php echo $details[$i]['product_price']; ?></span>
                        </div>
                        <div class="sz12r"></div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="Npricenum sz14r redColor">×<?php echo $details[$i]['product_count']; ?></div>
                </div>
                <?php
            }
        ?>
    </div>

    
    <div class="weui-cells noborder" style="margin-top:0;">
        <div class="weui-cell">
        	<div class="weui-cell__hd">
            	<span class="sz14r">运费：</span>
            </div>
            <div class="weui-cell__bd"></div>
            <div class="weui-cell__ft">
            	<span class="sz14r">￥<?php echo $data['order_ship_fee']; ?></span>
            </div>
        </div>
        <div class="weui-cell">
        	<div class="weui-cell__hd">
            	<span class="sz14r ">订单金额：</span>
            </div>
            <div class="weui-cell__bd"></div>
            <div class="weui-cell__ft">
            	<span class="sz14r">￥<?php echo $data['order_total']; ?></span>
            </div>
        </div>
        <?php
            if($data['pay_money']!=$data['order_total'] && $data['order_status']>=3)
            {
                ?>
                <div class="weui-cell">
                    <div class="weui-cell__hd">
                        <span class="sz14r ">优惠券抵扣：</span>
                    </div>
                    <div class="weui-cell__bd"></div>
                    <div class="weui-cell__ft">
                        <span class="sz14r">￥<?php echo $data['order_total']-$data['pay_money']; ?></span>
                    </div>
                </div>
                <?php
            }
        ?>
        <div class="weui-cell" style="padding:.14rem 3%;border-top:1px solid #e8e8e8;display: <?php echo $data['order_status']>=3?'block':'none'; ?>">
        	<div class="weui-cell__hd">
            	<span class="sz14r ">实付款</span>
            </div>
            <div class="weui-cell__bd"></div>
            <div class="weui-cell__ft">
            	<span class="sz14r redColor">￥<?php echo $data['pay_money']?$data['pay_money']:'0.00'; ?></span>
            </div>
        </div>
     </div>


	<div class="weui-cells">
    	  <div class="weui-cell">
        	<div class="weui-cell__hd">
            	<span class="sz14r ">备注：</span>
            </div>
            <div class="weui-cell__bd">
            	<p class="sz14r"><?php echo $data['liuyan']; ?></p>
            </div>
            <div class="weui-cell__ft">
            	
            </div>
        </div>
    </div>


	 <div class="weui-cells noborder">
        <div class="weui-cell">
        	<div class="weui-cell__hd">
            	<span class="sz14r">订单编号：</span>
            </div>
            <div class="weui-cell__bd"></div>
            <div class="weui-cell__ft">
            	<span class="sz14r"><?php echo $data['orderid']; ?></span>
            </div>
        </div>
        <div class="weui-cell">
        	<div class="weui-cell__hd">
            	<span class="sz14r ">订单时间：</span>
            </div>
            <div class="weui-cell__bd"></div>
            <div class="weui-cell__ft">
            	<span class="sz14r"><?php echo $data['order_addtime']; ?></span>
            </div>
        </div>
        <div class="weui-cell">
        	<div class="weui-cell__hd">
            	<span class="sz14r ">付款时间：</span>
            </div>
            <div class="weui-cell__bd"></div>
            <div class="weui-cell__ft">
            	<span class="sz14r"><?php echo $data['pay_datetime']; ?></span>
            </div>
        </div>
     </div>
</body>
<script type="text/javascript" src="/tool/layer/layer_mobile/layer.js"></script>
<script>
    var id = <?php echo $data['id']; ?>;
    $("#qx_order").click(function ()
    {
        if(!id){return false;}
        var data = {
            id:id
        };
        //底部对话框
        layer.open({
            content: '确定要取消吗?'
            ,btn: ['删除', '取消']
            ,skin: 'footer'
            ,yes: function(index){
                $.ajax({
                    type:"post",
                    url:"/?mod=weixin&v_mod=user&_action=ActionCpanelorder",
                    data:data,
                    success:function (res)
                    {
                        layer_msg(res.msg);
                        history.back();
                    },
                    error:function () {
                        layer_msg('网络超时');
                    },
                    dataType:"json"
                });
            }
        });
    });

    function layer_msg(msg) {
        layer.open({
            content: msg
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
        });
    }


    $("#sh_order").click(function ()
    {
        if(!id){return false;}
        var data = {
            id:id
        };
        //底部对话框
        layer.open({
            content: '确定收货吗?'
            ,btn: ['确定', '取消']
            ,skin: 'footer'
            ,yes: function(index){
                $.ajax({
                    type:"post",
                    url:"/?mod=weixin&v_mod=user&_action=ActionDeliveryOrder",
                    data:data,
                    success:function (res)
                    {
                        if(res.code==0)
                        {
                            location.href='/?mod=weixin&v_mod=order&_index=_view&orderid=<?php echo $_GET['orderid']; ?>';
                        }else{
                            layer_msg(res.msg);
                        }
                    },
                    error:function () {
                        layer_msg('网络超时');
                    },
                    dataType:"json"
                });
            }
        });
    });
</script>
</html>