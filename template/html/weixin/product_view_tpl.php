<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetProductDetails();
$attr = $obj->GetProductAttr($data['product_id']);
$comment = $obj->GetProductComment($data['product_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name = "format-detection" content="telephone = no" />
    <title><?php echo $data['product_name']; ?></title>
    <link rel="stylesheet" href="/tool/layer/layui/layui/css/layui.css">
    <link rel="stylesheet" href="/tool/layer/layer_mobile/need/layer.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/font.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/rest.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/main.css?66666">
    <link type="text/css" rel="stylesheet" href="/template/source/css/ggPublic.css?66666">
    <style type="text/css">
        .swiper-slide {
            background: #fff;
        }
        .swiper-slide>a{display:block}
        .swiper-slide>a>img{width:100%; height:auto; display:block;}
        .user-img>img{border-radius: 0; width:.8rem; height:.8rem;}
        .weui-cell {
            border-bottom: 1px solid #dedede;
        }
        .numberBox>a{width:.7rem; height:.5rem; line-height: .5rem;}
        .numberBox>input[type='number']{width:.7rem; height:.48rem;}
        .fill_box_btn a {
            width: 100%;
        }
    </style>
</head>

<body>

<div id="gg-app" style="padding:.82rem 0 61px 0">

    <div class="gg-detail-header">
        <span class="gg-detail_title sz16r"><?php echo $data['product_name']; ?></span>
        <div class="return-back" onclick="javascript :history.back(-1);"></div>
        <a href="/?mod=weixin&v_mod=cart" class="fr sz16r" style="margin-right:3%;"><span class="glyphicon glyphicon-shopping-cart"></span></a>
    </div>

    <div class="gg-banner">
        <!-- Swiper -->
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php
                if($data['product_details_img'])
                {
                    foreach(unserialize($data['product_details_img']) as $img)
                    {
                        ?>
                        <a><div class="swiper-slide"><a><img src="<?php echo $img; ?>"></a></div></a>
                    <?php
                    }
                }
                ?>
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <div id="pro-message">
        <div class="nameorshare">
            <div class="l-name sz14r"><?php echo $data['product_name']; ?></div>
        </div>
        <div class="price-line">
            <span class="orange">￥<?php echo $data['product_price']; ?></span>
            <span class="cl999 fr">市场价 <del class="cl999">￥<?php echo $data['product_fake_price']; ?></del></span>
            <div class="clearfix"></div>
        </div>
        <div class="dtif-p">
            <span class="cl999 txtl">快递：到付<?php //echo $data['freight']; ?></span>
            <span class="cl999 txtr">已销出<?php echo $data['product_sold']; ?>笔</span>
        </div>
        <?php
            if(!empty($data['reminder'])){
                ?>
                <div class="reminder" style="padding-top: 10px;">
                    <span style="color: #ff4546;">温馨提示：</span><span style="text-decoration: underline;"><?php echo $data['reminder']; ?></span>
                </div>
                <?php
            }
        ?>
        <div class="contact" style="padding-top: 10px;"><span style="color: #ff4546">咨询热线</span>：020-36082857</div>
        <div class="extend-info">
            <div class="guarantee">
                <div class="guarantee-item"><i class="img"></i><span class="text">正品保证</span></div>
                <div class="guarantee-item"><i class="img"></i><span class="text">假一赔十</span></div>
                <div class="guarantee-item"><i class="img"></i><span class="text">七天包换</span></div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>


    <div class="dt-content mtr01">
        <nav class="dt-nav">
            <a href="javascript:;" class="sel">商品参数</a>
            <a href="javascript:;" class="">图文详情</a>
            <a href="javascript:;" class="">评论</a>
        </nav>

        <div class="dt-con">

            <div class="dt-con-item" style="display: block;padding: 15px;">
                <?php echo $data['product_param']; ?>
            </div>
            <div class="dt-con-item" style="display: none;">
                <?php echo $data['product_text']; ?>
            </div>
            <div class="dt-con-item" style="display: none;">
                <div class="tab-box">
                    <div class="tab-box-item" style="display: block;">
                        <div class="weui-cells"  style="margin-top: 0;">
                            <div id="show_comment">
                                <?php
                                if($comment['data'])
                                {
                                    foreach($comment['data'] as $item)
                                    {
                                        ?>
                                        <div class="weui-cell">
                                            <div class="weui-cell__hd user-img topImg">
                                                <img title="<?php echo $item['nickname']; ?>" src="<?php echo $item['headimgurl']; ?>" alt="">
                                            </div>
                                            <div class="weui-cell__bd w83Ml17">
                                                <div class="sz14r"><?php echo $item['product_name'].$item['product_attr_name']; ?></div>
                                                <div class="nandu-item">
                                                    <?php
                                                    for($i=0;$i<$item['comment_level'];$i++)
                                                    {
                                                        ?>
                                                        <span class="active-2"></span>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div>
                                                    <span class="sz14r"><?php echo $item['comment']; ?></span>
                                                </div>
                                                <div>
                                                    <span class=" sz12r cl999"><?php echo $item['addtime']; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                }
                                ?>
                            </div>
                            <div id="page1" style="text-align: center"></div>
                            <?php
                            if(!$comment['data'])
                            {
                                ?>
                                <div class="search-empty-panel">
                                    <div class="content">
                                        <img src="/template/source/images/no_content.png">
                                        <div class="text">暂无评论</div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="weui-tabbar">
        <a href="javascript:;" onclick="cpanelcolle(<?php echo $data['product_id']; ?>,this)" class="weui-tabbar__item" style="width:15%; -webkit-box-flex:inherit; -webkit-flex: inherit; flex: inherit; ">
            <?php
            $colle = $obj->GetOneProductColle($data['product_id'],1);
            ?>
            <img src="/template/source/images/<?php echo $colle?'icon-stars.png':'icon-stare.png'; ?>" alt="" class="weui-tabbar__icon">
            <p class="weui-tabbar__label sz14r cl999"><?php echo $colle?'已收藏':'收藏'; ?></p>
        </a>
        <a href="javascript:;" class="weui-tabbar__item cart-btn">
            <p class="weui-tabbar__label sz16r" style="line-height: 46px;">加入购物车</p>
        </a>

        <a href="javascript:;" class="weui-tabbar__item purchase-btn">
            <p class="weui-tabbar__label sz16r" style="line-height: 46px;">立即购买</p>
        </a>
    </div>

</div>

<div id="Bgcon" ></div>
<div id="product_fill_box" >
    <div class="fill_box_head">
        <div class="fill_box_head_img"><img src="<?php echo $data['product_img']; ?>" title="" alt="<?php echo $data['product_name']; ?>"></div>
        <div class="fill_box_head_mess">
            <p class="title omit sz14r"><?php echo $data['product_name']; ?></p>
            <p class="price"><span>￥<?php echo $data['product_price'];?></span></p>
        </div>
        <a href="javascript:;" id="close"><span class="glyphicon glyphicon-remove-circle rsz16"></span></a>
    </div>

    <?php
    if($attr)
    {
        //echo '<pre>';
        //var_dump($attr);exit;
        foreach($attr as $val)
        {
            ?>
            <div class="fill_box_item">
                <p class="fill_box_item_title sz14r"><?php echo $val['attr_type']; ?></p>
                <div class="fill_box_item_number">
                    <?php
                    if(!empty($val['attr']))
                    {
                        for($i=0;$i<count($val['attr']);$i++)
                        {
                            ?>
                            <a href="javascript:;" attr_price="<?php echo $val['attr'][$i]['attr_price'];?>" attr_id="<?php echo $val['attr'][$i]['id'];?>" class="<?php if($i==0){echo 'select-active';} ?>"><?php echo $val['attr'][$i]['attr_temp_name']; ?></a>
                        <?php
                        }
                    }
                    ?>
                </div>
            </div>
        <?php
        }
    }
    ?>
    <div class="fill_box_item">
        <div class="fill_box_item_quantity">
            <p class="fill_box_item_title fl sz14r" style="width:50%">购买数量</p>
            <div class="numberBox fr">
                <a href="javascript:;" class=" glyphicon glyphicon-minus minus sz14r"  style="color: rgb(204, 204, 204);"></a>
                <input type="number" id="product_count"  value="1" style="    vertical-align: baseline;" >
                <a href="javascript:;" class=" glyphicon  glyphicon-plus plus sz14r"></a>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="fill_box_btn">
        <a href="javascript:;" id="add-cart" onclick="add_cart(this,<?php echo $data['product_id']; ?>)" class="left sz16r">确认</a>
        <div class="clearfix"></div>
    </div>
</div>
<div class="win" style="display: none"><div class="tips" style="position: absolute;top: 0px"></div></div>
<div id="layui-m-layer0" style="display: none" class="layui-m-layer layui-m-layer0" index="0">
    <div class="layui-m-layermain"><div class="layui-m-layersection">
            <div class="layui-m-layerchild layui-m-layer-msg  layui-m-anim-up">
                <div class="layui-m-layercont"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/template/source/js/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="/template/source/js/swiper.min.js"></script>
<script type="text/javascript" src="/tool/layer/layui/layui/layui.js"></script>
<script type="text/javascript" src="/tool/layer/layui/layui/lay/modules/laypage.js"></script>
<script>
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        autoplay:3000,
        autoplayDisableOnInteraction : false
    });
    $(function(){

        $(".swiper-pagination .swiper-pagination-bullet").each(function(index,element){
            if(index == 0){
                $(element).parent().hide();
            }else{
                $(element).parent().show();
            }
        });
        $(".dt-nav>a").click(function(){
            $(this).addClass("sel").siblings().removeClass("sel");
            var _index = $(this).index();
            $(".dt-con .dt-con-item").eq(_index).show().siblings().hide();
        });


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
        });

        $(".cart-btn").click(function()
        {
            $("#add-cart").attr('data-type',1);
            $("#Bgcon").show();
            $("#product_fill_box").show();
            setTimeout(function(){
                $("#product_fill_box").css({"transform":"translate3d(0,0,0)","-webkit-transform":"translate3d(0,0,0)","-moz-transform":"translate3d(0,0,0)"})
            },150);
        });

        $(".purchase-btn").click(function(){
            $("#add-cart").attr('data-type',2);
            $("#Bgcon").show();
            $("#product_fill_box").show();
            setTimeout(function(){
                $("#product_fill_box").css({"transform":"translate3d(0,0,0)","-webkit-transform":"translate3d(0,0,0)","-moz-transform":"translate3d(0,0,0)"})
            },150);
        });

        $("#close").click(function(){
            $("#product_fill_box").css({"transform":"translate3d(0,400px,0)","-webkit-transform":"translate3d(0,400px,0)","-moz-transform":"translate3d(0,400px,0)"})
            setTimeout(function(){
                $("#Bgcon").hide();
                $("#product_fill_box").hide();

            },300);

            $(".numberBox>input[type='number']").val(1);

        });

        $("#Bgcon").click(function(){
            $("#product_fill_box").css({"transform":"translate3d(0,400px,0)","-webkit-transform":"translate3d(0,400px,0)","-moz-transform":"translate3d(0,400px,0)"})
            setTimeout(function(){
                $("#product_count").val(1);
                $("#Bgcon").hide();
                $("#product_fill_box").hide();
            },300);
            $(".numberBox>input[type='number']").val(1);

        });



        $('.fill_box_item').each(function(){
            $(this).find('.fill_box_item_number').children().click(function(){
                if($(this).hasClass('select-active')){
                    return false;
                }else{
                    $(this).addClass('select-active').siblings().removeClass('select-active');
                }
                var price = $(this).attr('attr_price');
                if(price!=0){
                    $('.fill_box_head_mess .price').html("<span>￥<?php echo $data['product_price'];?>+"+price+"</span>");
                }

            });
        });
        //属性价钱
        //$('.fill_box_item_number').children().click(function(){
    });
    //1加入购物车 2是直接下单
    var post = true;
    function add_cart(obj,product_id) {
        if(post==false){return false;}
        var type = $(obj).attr('data-type');
        //alert(type);
        var attr_id = CheckSel();
        var product_count = $("#product_count").val();
        if(product_count=='' || isNaN(product_count) || product_count<=0)
        {
            return false;
        }
        var data = {
            attr_id:attr_id,
            product_count:product_count,
            product_id:product_id
        };
        post = false;
        $.ajax({
            type:"post",
            url:"/?mod=weixin&v_mod=cart&_action=ActionAddCart",
            data:data,
            dataType:"json",
            async:false,
            success:function (res) {
                post = true;
                if(type!=2)
                {
                    timeOutHide(res.msg,2000);
                }
                if(res.code==0)
                {
                    $("#product_count").val(1);
                    $("#Bgcon").hide();
                    $("#product_fill_box").hide();
                    if(type==2)
                    {
                        location.href='?mod=weixin&v_mod=checkout';
                        //timeOutHide(res.msg,2000);
                    }
                }
            },
            error:function () {
                post = true;
                timeOutHide('网络超时',2000);
            }
        });
    }


    function cpanelcolle(id,obj)
    {
        var that = $(obj);
        $.ajax({
            type:"get",
            url:"/?mod=weixin&v_mod=product&_index=_view&product="+id+"&type=1&_action=ActionCancelProductColle",
            dataType:"json",
            async:false,
            success:function (res) {
                if(res.code==0)
                {
                    if(res.type==1)
                    {
                        that.children('img').attr('src','/template/source/images/icon-stars.png');
                        that.children('p').html('已收藏');
                    }else{
                        that.children('img').attr('src','/template/source/images/icon-stare.png');
                        that.children('p').html('收藏');
                    }
                }
                timeOutHide(res.msg,2000);
            },
            error:function (error)
            {
                timeOutHide('网络超时',2000);
            }
        });
    }
    //获取选中的属性
    function CheckSel()
    {
        var is_attr = <?php echo $attr?1:0; ?>;
        if(is_attr==1)
        {
            var attr = '';
            var sel = 0;
            var all_len = 0;    //减去  重复class
            $('.fill_box_item').each(function()
            {
                all_len++;
                $(this).find('.fill_box_item_number').children().each(function()
                {
                    if($(this).hasClass('select-active')){
                        sel++;
                        attr+=$(this).attr('attr_id')+',';
                    }
                });
            });
            if(all_len-1 !=sel)
            {
                timeOutHide('请选择属性',2000);
                return false;
            }
            var attr_id = attr.substring(0,attr.length-1);
        }else{
            var attr_id = '';
        }
        return attr_id;
    }
    function timeOutHide(msg,m)
    {
        $(".layui-m-layercont").html(msg);
        $("#layui-m-layer0").show();
        setTimeout(function(){//5秒后隐藏
            $("#layui-m-layer0").fadeOut();
        }, m);
    }
</script>
</body>
</html>