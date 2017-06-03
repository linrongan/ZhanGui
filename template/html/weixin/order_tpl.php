<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetMyOrder();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name = "format-detection" content="telephone = no" />
    <title>我的订单</title>
    <link rel="stylesheet" href="/tool/layer/layui/layui/css/layui.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/font.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/rest.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/ggPublic.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/main.css?77777777777sss">
    <style>
        .porduct_ul{
            cursor:pointer
        }
    </style>
</head>
<body>
<div id="gg-app" style="padding:.82rem 0 0; ">
    <div class="order-tab">
        <!-- Swiper -->
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide <?php echo $data['status']==0?'order-tab-active':''; ?>"><a href="/?mod=weixin&v_mod=order">全部</a></div>
                <div class="swiper-slide <?php echo $data['status']==1?'order-tab-active':''; ?>"><a href="/?mod=weixin&v_mod=order&type=1">待付款</a></div>
                <div class="swiper-slide <?php echo $data['status']==2?'order-tab-active':''; ?>"><a href="/?mod=weixin&v_mod=order&type=2">待发货</a></div>
                <div class="swiper-slide <?php echo $data['status']==3?'order-tab-active':''; ?>"><a href="/?mod=weixin&v_mod=order&type=3">待收货</a></div>
                <div class="swiper-slide <?php echo $data['status']==4?'order-tab-active':''; ?>"><a href="/?mod=weixin&v_mod=order&type=4">待评价</a></div>
                <div class="swiper-slide <?php echo $data['status']==5?'order-tab-active':''; ?>"><a href="/?mod=weixin&v_mod=order&type=5">已完成</a></div>
            </div>
        </div>
    </div>
    <div class="order-tab-container">
        <div class="tab-container-item">
            <div class="porduct">
                <ul class="porduct_ul">
                    <?php
                    if($data['data'])
                    {
                        $url = array(0=>'/?mod=weixin&v_mod=product&_index=_details&id=',1=>'/?mod=weixin&v_mod=group&id=');
                        foreach($data['data'] as $item)
                        {
                            $details = $obj->GetOrderDetails($item['orderid']);
                            ?>
                            <li>
                                <div class="porduct_hd" onclick="location.href='?mod=weixin&v_mod=order&_index=_view&orderid=<?php echo $item['orderid']; ?>'">
                                    <div class="fl porduct_hd_left">
                                        订单号：<?php echo $item['orderid']; ?>
                                    </div>
                                    <?php
                                    if($item['order_type']) {
                                        ?>
                                        <img src="/template/source/images/group-<?php echo $item['order_type'] == 1 ? 2 : 1; ?>.png"
                                             alt="">
                                    <?php
                                    }
                                    if($item['store_id'])
                                    {
                                        ?>
                                        <img src="/template/source/images/dl.png" alt="">
                                    <?php
                                    }
                                    ?>
                                    <div class="fr cldb3652"><?php echo $Sys_Order_Status[$item['order_status']]; ?></div>
                                    <div class="clearfix"></div>
                                </div>
                                <?php
                                if($details)
                                {
                                    foreach($details as $p)
                                    {
                                        ?>
                                        <div class="porduct_jshao">
                                            <div class="fl l_porpic" onclick="location.href='<?php echo $url[$item['order_type']].$p['product_id']; ?>'">
                                                <img src="<?php echo $p['product_img']; ?>">
                                            </div>
                                            <div class="fl r_porname">
                                                <p class="porduct_name tlie sz14r">
                                                    <?php echo $p['product_name']; ?>
                                                </p>
                                                <div class="mtr01 sz12r">
                                                    价格：<span class="redColor">￥<?php echo $p['product_price']; ?></span>
                                                </div>
                                                <div class="sz12r">
                                                    <?php
                                                    if($p['product_attr_name'])
                                                    {
                                                        if(strpos($p['product_attr_name'],';'))
                                                        {
                                                            $arr = explode(';',$p['product_attr_name']);
                                                        }else{
                                                            $arr[] = $p['product_attr_name'];
                                                        }
                                                        $arr = array_filter($arr);
                                                        for($i=0;$i<count($arr);$i++)
                                                        {
                                                            ?>
                                                            <span class="redColor"><?php echo $arr[$i]; ?>  </span>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="Npricenum sz14r redColor">×<?php echo $p['product_count']; ?></div>
                                        </div>
                                    <?php
                                    }
                                }
                                ?>
                                <div class="select_gmai">
                                    <div class="fl sz14r lhr06">合计：<span class="redColor">￥<?php echo $item['order_total'];  ?></span></div>
                                    <?php
                                    if($item['order_status']==1)
                                    {
                                        if($item['expiry_date']>time())
                                        {
                                            if($item['store_id']==0)
                                            {
                                                ?>
                                                <a class="gmai_btn" href="?mod=weixin&v_mod=checkout&_index=_pay&orderid=<?php echo $item['orderid']; ?>">付款</a>
                                            <?php
                                            }else{
                                                ?>
                                                <a class="gmai_btn" href="/?mod=weixin&v_mod=direct_checkout&_index=_pay&type=3&orderid=<?php echo $item['orderid']; ?>">付款</a>
                                            <?php
                                            }
                                        }
                                        ?>
                                        <a class="gmai_btn romove_order" oid="<?php echo $item['id']; ?>" href="javascript:;">删除订单</a>
                                    <?php
                                    }elseif($item['order_status']==4)
                                    {
                                        ?>
                                        <a class="gmai_btn delivery" oid="<?php echo $item['id']; ?>" href="javascript:;">确认收货</a>
                                        <a class="gmai_btn" href="/?mod=weixin&v_mod=order&_index=_wuliu&no=<?php echo $item['wuliu_no']; ?>">查看物流</a>
                                    <?php
                                    }elseif($item['order_status']==6)
                                    {
                                        ?>
                                        <a class="gmai_btn" href="?mod=weixin&v_mod=product&_index=_comment&orderid=<?php echo $item['orderid']; ?>">评价</a>
                                    <?php
                                    }
                                    ?>
                                    <div class="clearfix"></div>
                                </div>
                            </li>
                        <?php
                        }
                    }else{
                        ?>
                        <li style="background:none; border-top:none; border-bottom:none;">
                            <div class="search-empty-panel">
                                <div class="content">
                                    <img src="/template/source/images/no_content.png">
                                    <div class="text">暂无订单</div>
                                </div>
                            </div>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="/template/source/js/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="/template/source/js/swiper.min.js"></script>
<script type="text/javascript" src="/tool/layer/layer_mobile/layer.js"></script>
<script type="text/javascript" src="/tool/layer/layui/layui/layui.js"></script>
<script type="text/javascript" src="/tool/layer/layui/layui/lay/modules/flow.js"></script>
<script>
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        slidesPerView: 5,
        paginationClickable: true
    });

    $(".porduct_ul").on('click','.romove_order',function () {
        var id = $(this).attr("oid");
        if(!id){return false;}
        var data = {
            id:id
        };
        var that = $(this);
        //底部对话框
        layer.open({
            content: '确定要取消吗?'
            ,btn: ['删除', '取消']
            ,skin: 'footer'
            ,yes: function(index){
                $.ajax({
                    type:"post",
                    url:"/?mod=weixin&v_mod=order&_action=ActionCpanelorder",
                    data:data,
                    success:function (res) {
                        layer_msg(res.msg);
                        if(res.code==0)
                        {
                            that.parent().parent().remove();
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


    $(".porduct_ul").on('click','.delivery',function () {
        var id = $(this).attr("oid");
        if(!id){return false;}
        var data = {
            id:id
        };
        var that = $(this);
        //底部对话框
        layer.open({
            content: '确定收货吗?'
            ,btn: ['确定', '取消']
            ,skin: 'footer'
            ,yes: function(index){
                $.ajax({
                    type:"post",
                    url:"/?mod=weixin&v_mod=order&_action=ActionDeliveryOrder",
                    data:data,
                    success:function (res) {
                        if(res.code==0)
                        {
                            history.go(0);
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
    function layer_msg(msg) {
        //提示
        layer.open({
            content: msg
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
        });
    }


    <?php
        if($data['pages']>1)
        {
            ?>
    layui.use('flow', function(){
        var flow = layui.flow;
        flow.load({
            elem: '.porduct_ul'
            ,done: function(page, next)
            {
                var lis = [];
                $.getJSON('/?mod=weixin&v_mod=order<?php echo isset($_GET['type'])?'&type='.$_GET['type']:''; ?>&page='+page, function(res)
                {
                    lis.push(res.data);

                    next(lis.join(''), page < res.pages);
                });
            }
        });
    });
    <?php
        }
    ?>
</script>
</body>
</html>