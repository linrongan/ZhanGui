<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetCartData();
$address = $obj->GetShopAddress();
if (empty($data))
{
    redirect('/?mod=weixin&v_mod=cart');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name = "format-detection" content="telephone = no" />
    <title>填写订单</title>
    <link type="text/css" rel="stylesheet" href="/template/source/css/font.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/rest.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/ggPublic.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/main.css">
    <style type="text/css">
        .weui-cell__bd>p{line-height: .4rem;}
        .weui-cells__title{padding-left:3%;}
        .numberBox>input[type='number']{ vertical-align: baseline;}
    </style>
</head>
<body>
<div id="content" style="padding:0 0 .9rem 0">
    <div class="weui-cells__title cl999">填写订单</div>
    <?php
    $total = 0;
    if($data)
    {
        //echo '<pre>';
        //var_dump($data);
        foreach($data as $item)
        {
            $total+=$item['total'];
            ?>
            <div class="weui-cells weui-cells_radio">
                <div class="weui-cell">
                    <div class="weui-cell__hd">
                        <img src="<?php echo $item['product_img']; ?>" style="width: 1rem; display: block; margin-right:.2rem;"></div>
                    <div class="weui-cell__bd ">
                        <p class="omit sz14r"><?php echo $item['product_name'].'x'.$item['product_count']; ?></p>
                        <p class="sz12r"><span class="mr5 redColor"><?php echo $item['total']; ?></span>元</p>
                    </div>
                    <div class="weui-cell__ft">
                    </div>
                </div>
            </div>
        <?php
        }
    }
    $ship_fee = $obj->GetShipFee($total);
    ?>
    <div class="weui-cells weui-cells_checkbox">

        <label class="weui-cell weui-check__label" for="s11">
            <div class="weui-cell__hd">
                <input type="radio" class="weui-check" name="pay_type" value="1" id="s11" checked="checked">
                <i class="weui-icon-checked"></i>
            </div>
            <div class="weui-cell__bd">
                <p class="sz14r">微信支付</p>
            </div>
            <div class="weui-cell__ft">
                <i class="gg-icon gg-icon_weixin mr10"></i>
            </div>
        </label>
    </div>


    <div class="weui-cells">
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <i class="gg-icon gg-icon_weixin mr10"></i>
            </div>
            <div class="weui-cell__bd">
                <p class="sz14r">运费</p>
            </div>
            <div class="weui-cell__ft sz12r">
                <?php //echo $ship_fee>0?'￥'.$ship_fee:'免邮'; ?>
                到付
            </div>
        </div>
    </div>


    <div class="weui-cells" style="margin-top:.2rem;">
        <?php
        $default_select = 0;
        if($address)
        {
            foreach($address as $item)
            {
                if($item['default_select']==0)
                {
                    $default_select = 1;
                }
                ?>
                <a class="weui-cell weui-cell_access"
                   href="?mod=weixin&v_mod=address&_index=_edit&id=<?php echo $item['id']; ?>&redirect=<?php echo urlencode('/?mod=weixin&v_mod=checkout'); ?>" id="address-box">
                    <div class="weui-cell__hd">
                        <img src="/template/source/images/icon-ar.png" alt="" style="width:.5rem;margin-right:10px;display:block">
                    </div>
                    <div class="weui-cell__bd weui-cell_primary" style="margin-right:5px;">
                        <p class="sz14r"><?php echo $item['shop_name']; ?>&nbsp;&nbsp;<?php echo $item['shop_phone']; ?></p>
                        <p class="sz12r cl999"><?php echo $item['address']; ?></p>
                    </div>
                    <span class="weui-cell__ft"><?php if($item['default_select']==0){echo '<span class="moren sz12r">默认</span>';} ?></span>
                </a>
            <?php
            }
        }
        ?>
        <?php
        if(count($address)<10)
        {
            ?>
            <a class="weui-cell weui-cell_access"
               href="?mod=weixin&v_mod=address&_index=_add&redirect=<?php echo urlencode('/?mod=weixin&v_mod=checkout'); ?>">
                <div class="weui-cell__hd">
                    <img src="/template/source/images/icon-address.png" style="width:.5rem;margin-right:10px;display:block">
                </div>
                <div class="weui-cell__bd">
                    <p class="sz14r">添加新地址</p>
                </div>
                <div class="weui-cell__ft"></div>
            </a>
        <?php
        }
        ?>
    </div>
    <div class="weui-cells" style="margin-top:.2rem;">
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <textarea class="weui-textarea sz12r" id="liuyan" placeholder="有什么想跟我说的么~~" rows="3"></textarea>
            </div>
        </div>
    </div>
    <div class="withdraw-ft">
        <div class="support_bar">
            <div class="support_bar_total">
                <p class="sz14r">合计：<span class="redColor mr5"><?php echo $total+$ship_fee; ?></span>元</p>
            </div>
            <div class="support_bar_btn sz16r"><a id="submit" href="javascript:;">提交订单</a></div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/template/source/js/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="/template/source/js/swiper.min.js"></script>
<script type="text/javascript" src="/tool/layer/layer_mobile/layer.js"></script>
<script>
    $(function(){
        $(".numberBox").on('click','.plus',function(event){
            var value = $(this).siblings("input[type='number']").val();
            value++;
            $(this).siblings("input[type='number']").val(parseInt(value));
            $(this).siblings(".minus").css("color","#5c5c5c");
            event.stopPropagation();
        });
        $(".numberBox").on('click','.minus',function(event){
            var value = $(this).siblings("input[type='number']").val();
            if(value>1){
                value--;
                $(this).siblings("input[type='number']").val(parseInt(value));
                if(value == 1){
                    $(this).css("color","#CCC");
                }else{
                    $(this).css("color","#5c5c5c");
                }
            }
            event.stopPropagation();
        });

        $(".numberBox").on('click',"input[type='number']",function(event){
            event.stopPropagation();
        });

        $(".numberBox").on('blur','input[type="number"]',function(){
            if($(this).val() < 1){
                $(this).val(1);
            }
        })
    });
    var post = true;
    $("#submit").click(function () {
        //var pay_type = $("input[name=pay_type]:checked").val();
        var address_id = <?php echo count($address); ?>;
        var default_select = <?php echo $default_select; ?>;
        if(address_id==0)
        {
            layer_msg('请添加收货地址');
            return false;
        }
        if(default_select==0)
        {
            layer_msg('请设置默认收货地址');
            return false;
        }
        var liuyan = $("#liuyan").val();
        $.ajax({
            type:"post",
            url:"/?mod=weixin&v_mod=checkout&_action=ActionNewOrder",
            data:{'liuyan':liuyan},
            dataType:"json",
            success:function (res)
            {
                if(res.code==0)
                {
                    location.href='?mod=weixin&v_mod=checkout&_index=_pay&orderid='+res.orderid;
                }else{
                    layer_msg(res.msg);
                    post = true;
                }
            },
            error:function () {
                layer_msg('网络超时');
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

</script>
</body>
</html>