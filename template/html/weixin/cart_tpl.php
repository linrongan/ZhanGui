<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$cart = $obj->GetCart();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone = no"/>
    <title><?php echo WEBNAME ;?></title>
    <link type="text/css" rel="stylesheet" href="/template/source/css/font.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/rest.css?6666666666">
    <link type="text/css" rel="stylesheet" href="/template/source/css/ggPublic.css?77777777777">
    <link type="text/css" rel="stylesheet" href="/template/source/css/main.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/newmain.css?666666">
    <style>
        .search-empty-panel{height:5rem;}
        .search-empty-panel .content >img{width:100px; height:100px;}
        .search-empty-panel .content{width:200px; margin-left: -100px;}
        .shopping-btn{display:inline-block; padding:.1rem .4rem; background:#ad0e11; color:white; border-radius:3px;}
    
    </style>
</head>
<body style="background:#f9f9f9">

	
    <div id="gg-app" style="padding:0 0 1rem 0">

        <div class="gg-shopping-container">
            <ul class="gg-shopping-warp">
                <?php
                $total = 0;
                $k = 0;
                if($cart)
                {
                    foreach($cart as $item)
                    {
                        if($item['select_status']==0)
                        {
                            $total+=$item['total'];
                            $k ++;
                        }
                        ?>
                        <li class="gg-shopping-item" data-active="true">
                            <div class="fl gg-shopping-checkbox">
                                <input type="checkbox" value="<?php echo $item['id']; ?>" <?php if($item['select_status']==0){echo 'checked';} ?> class="cart_sel">
                            </div>
                            <div class="fl gg-shopping-proImg">
                                <img src="<?php echo $item['product_img']; ?>">
                            </div>
                            <div class="fr gg-shopping-main">
                                <p class="omit sz14r"><?php echo $item['product_name']; ?></p>
                                <p class="tlie sz12r cl999"><?php echo $item['product_desc']; ?></p>
                                <div class="shopping-main-bottom">
                                    <span class="fl cldb3652 sz14r">￥<?php echo $item['total']; ?></span>
                                    <div class="fr numberBox">
                                        <a href="javascript:;" cart_id="<?php echo $item['id']; ?>" class="glyphicon glyphicon-minus minus"></a>
                                        <input type="number" value="<?php echo $item['product_count']; ?>" id="product_count" cart_id="<?php echo $item['id']; ?>">
                                        <a href="javascript:;" cart_id="<?php echo $item['id']; ?>"  class="glyphicon glyphicon-plus plus"></a>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <?php
                                if($item['attr_id'])
                                {
                                    $attr = $obj->GetProductAttr($item['attr_id']);
                                    for($i=0;$i<count($attr);$i++)
                                    {
                                        ?>
                                        <div class="sz12r">
                                            <span class="redColor"><?php echo $attr[$i]['attr_type_name'].'：'.$attr[$i]['attr_temp_name']; ?></span>
                                        </div>
                                    <?php
                                    }
                                }
                                ?>
                            </div>
                            <div class="clearfix"></div>
                        </li>
                    <?php
                    }
                }else{
                    ?>
                    <li style="background:rgb(249, 249, 249)">
                        <div class="search-empty-panel">
                            <div class="content">
                                <img src="/template/source/images/no_shopping.png">
                                <div class="text">您的购物车还是空的哦~</div>
                                <div class="txtc mtr02"><a href="/?mod=weixin" class="shopping-btn">去选购吧</a></div>
                            </div>
                        </div>
                    </li>
                <?php
                }
                ?>
              </ul>
        </div>


        <div class="gg-shopping-bottom">
            <div class="fl whole-btn" id="all_sel" data-checked="true">
                <input type="checkbox"  <?php if($k==count($cart)){echo 'checked';} ?>>
                <span class="sz14r blackColor">全选</span>
            </div>
			<div class="fl" style="line-height:1rem;">
            	<a href="javascript:;" id="del" class="sz14r redColor">删除</a>
            </div>
			
            <div class="fr settlement">
                <a href="javascript:;" id="submit" class="sz16r">结算(<?php echo $k; ?>)</a>
            </div>
            <div class="fr totalprice mr10 sz14r">
                合计：<span>￥<?php echo $total; ?></span>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <div id="returnTop"></div>
 	<script type="text/javascript" src="/template/source/js/jquery-1.10.1.min.js"></script>
    <script type="text/javascript" src="/template/source/js/swiper.min.js"></script>
    <script type="text/javascript" src="/template/source/js/returnTop.js"></script>
    <script type="text/javascript" src="/template/source/js/jquery.lazyload.min.js"></script>
    <script type="text/javascript" src="/tool/layer/layer_mobile/layer.js"></script>
    <script>

        $(function(){
            $('.minus').click(function(){
                var now_nums = $(this).next().val();
                var cart_id = $(this).attr('cart_id');
                var new_nums = parseInt(now_nums)-1;
                event.stopPropagation();
                if(new_nums==0)
                {
                    $(this).css("color","#CCC");
                }else{
                    $(this).css("color","#5c5c5c");
                }
                if(new_nums==0){
                    layer_msg('至少保留一件');
                    return false;
                }
                $.ajax({
                    type:"post",
                    url:"/?mod=weixin&v_mod=cart&_action=ActionEditCartCount",
                    data:{'cart_id':cart_id,'nums':new_nums},
                    async:false,
                    success:function(res){
                        if(res.code!=0){
                            layer_msg(res.msg);
                            return false;
                        }else{
                            window.location.href='/?mod=weixin&v_mod=cart';
                        }
                    },
                    error:function(){
                        layer_msg('网络超时');
                    },
                    dataType:"json"
                });
            });

            $('.plus').click(function(event){
                var now_nums = $(this).prev().val();
                var cart_id = $(this).attr('cart_id');
                var new_nums =parseInt(now_nums)+1;
                event.stopPropagation();
                $.ajax({
                    type:"post",
                    url:"/?mod=weixin&v_mod=cart&_action=ActionEditCartCount",
                    data:{'cart_id':cart_id,'nums':new_nums},
                    async:false,
                    success:function(res){
                        if(res.code!=0){
                            layer_msg(res.msg);
                            return false;
                        }else{
                            window.location.href='/?mod=weixin&v_mod=cart';
                        }
                    },
                    error:function(){
                        layer_msg('网络超时');
                    },
                    dataType:"json"
                });
            });

            //修改数量
            $("#product_count").blur(function(){
                var now_nums = $(this).val();
                var cart_id = $(this).attr('cart_id');
                var new_nums =parseInt(now_nums);
                event.stopPropagation();
                $.ajax({
                    type:"post",
                    url:"/?mod=weixin&v_mod=cart&_action=ActionEditCartCount",
                    data:{'cart_id':cart_id,'nums':new_nums},
                    async:false,
                    success:function(res){
                        if(res.code!=0){
                            layer_msg(res.msg);
                            return false;
                        }else{
                            window.location.href='/?mod=weixin&v_mod=cart';
                        }
                    },
                    error:function(){
                        layer_msg('网络超时');
                    },
                    dataType:"json"
                });
            });

            $("#del").click(function () {
                var k = <?php echo $k; ?>;
                if(k==0)
                {
                    return false;
                }
                $.ajax({
                    type:"get",
                    url:"/?mod=weixin&v_mod=cart&_action=ActionDelProduct",
                    dataType:"json",
                    async:false,
                    success:function (res) {
                        if(res.code!=0){
                            layer_msg(res.msg);
                            return false;
                        }else{
                            window.location.href='/?mod=weixin&v_mod=cart';
                        }
                    },
                    error:function () {
                        layer_msg('网络超时');
                    }
                });
            });

            $('.cart_sel').click(function(){
                var cart_id = $(this).val();
                if(isNaN(cart_id) || cart_id==0){
                    return false;
                }
                $.ajax({
                    type:"post",
                    url:"/?mod=weixin&v_mod=cart&_action=ActionSelectOneCart",
                    data:{'cart_id':cart_id},
                    async:false,
                    success:function(res){
                        if(res.code!=0){
                            layer.msg(res.msg, {icon: 5});
                            return false;
                        }else{
                            window.location.href='/?mod=weixin&v_mod=cart';
                        }
                    },
                    error:function(){
                        layer_msg('网络超时');
                    },
                    dataType:"json"
                });
            });


            $('#all_sel').click(function(){
                var is_null = <?php echo count($cart); ?>;
                if(!is_null) {
                    return false;
                }
                $.ajax({
                    type:"get",
                    url:"/?mod=weixin&v_mod=cart&_action=ActionSelectAllCart",
                    async:false,
                    success:function(res){
                        if(res.code!=0){
                            layer_msg(res.msg);
                            return false;
                        }else{
                            window.location.href='/?mod=weixin&v_mod=cart';
                        }
                    },
                    error:function(){
                        layer_msg('网络超时');
                    },
                    dataType:"json"
                });
            });


            $(".numberBox").on('click',"input[type='number']",function(event){
                event.stopPropagation();
            });

            $(".numberBox").on('blur','input[type="number"]',function(){
                if($(this).val() < 1){
                    $(this).val(1);
                }
            });

            $(".whole-btn").click(function(){

                if($(this).attr("data-checked") == 'false'){

                    $(this).children("input[type='checkbox']").prop("checked","checked");
                    $(this).children("span").css("color","#000");

                    $(".gg-shopping-warp .gg-shopping-item").each(function(index,element){
                        $(element).attr("data-active","true");
                        $(element).children(".gg-shopping-checkbox").children("input[type='checkbox']").removeAttr("checked").prop("checked","checked");
                    });
                    $(this).attr("data-checked","true");
                }else{
                    $(this).children("input[type='checkbox']").removeAttr("checked");
                    $(this).children("span").css("color","#999999");
                    $(".gg-shopping-warp .gg-shopping-item").each(function(index,element){
                        $(element).attr("data-active","false");
                        $(element).children(".gg-shopping-checkbox").children("input[type='checkbox']").removeAttr("checked")
                    });
                    $(this).attr("data-checked","false");
                }
            });


            $("#submit").click(function () {
                var k = <?php echo $k; ?>;
                if(k)
                {
                    location.href='?mod=weixin&v_mod=checkout';
                }else{
                    layer_msg('无产品');
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