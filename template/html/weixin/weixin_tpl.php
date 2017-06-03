<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$products = $obj->getHomeProduct(6);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone = no"/>
    <title><?php echo WEBNAME ;?></title>
    <link rel="stylesheet" href="/tool/layer/layui/layui/css/layui.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/font.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/rest.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/ggPublic.css?77777777777">
    <link type="text/css" rel="stylesheet" href="/template/source/css/main.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/newmain.css?124">
    <style>
		.swiper-container{min-height:2rem;}
        .swiper-slide img{width:100%; display:block}
        .swiper-pagination{text-align: right}
        .swiper-pagination-bullet{background:#ad0e11; }
		.weui-search-bar{background:#f9f9f9;}
        .search-input .close-btn {
            position: absolute;
            height: 20px;
            width: 20px;
            -webkit-border-radius: 50%;
            -moz-border-radius: 50%;
            -o-border-radius: 50%;
            border-radius: 50%;
            right: 40px;
            top: 50%;
            margin-top: -10px;
            background: url(../images/close_166a6c4.png) no-repeat;
            background-color: #bababa;
            background-size: 14px 14px;
            background-position: center;
            display: none;
        }
        .contact{
            font-size: .25rem;
            border: 1px solid #ff4546;
            padding: 2px;
            margin-bottom: 10px;
            display: -webkit-box;
            display: -webkit-flex;
            display: flex;
            position: relative;
        }
        .tel-box{
            -webkit-box-flex: 1;
            -webkit-flex: 1;
            flex: 1;
        }



    </style>

    

    
    
</head>
<body style="background:#f9f9f9">
    <?php include 'header_tpl.php';?>
    <div class="pre-group">
        <div class="custom-image4 clearfix">
            <ul>
                <?php
                    $category = $obj->GetHomeCategory();
                    if(!empty($category)){
                        foreach($category as $item){
                            ?>
                            <li><a href="?mod=weixin&v_mod=category&id=<?php echo $item['category_id']?>"><span class="sz12r"><?php echo $item['category_name']?></span></a></li>
                        <?php
                        }
                    }
                ?>
            </ul>
        </div>
    </div>
    <div class="gg-banner">
        <!-- Swiper -->
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php
                $banner = $obj->GetPicture(0);
                if($banner)
                {
                    foreach($banner as $img)
                    {
                        ?>
                        <div class="swiper-slide"><a href="<?php echo $img['fields_link']; ?>"><img title="<?php echo $img['fields_title']; ?>" src="<?php echo $img['fields_image']; ?>"></a></div>
                    <?php
                    }
                }
                ?>
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <div class="search-bar">
        <div class="contact">
            <div class="tel-box"><span style="color: #ff4546">咨询热线</span>：<a href="tel:020-36082857">020-36082857</a></div>
            <div class="tel-box"><span style="color: #ff4546">微信</span>：A1498115138</div>
        </div>
        <form method="post" action="/?mod=weixin&v_mod=search">
            <div class="search-input">
                <input type="search" name="search" placeholder="搜索您想要的产品" id="search">
                <div class="close-btn"></div>
                <div class="search-pro-btn"></div>
            </div>
        </form>
    </div>

    <div class="news-body mtr02">
        <div class="news-body_title txtc">
            <a href="/?mod=weixin&v_mod=product&new" class="sz14r">全部商品<span></span></a>
        </div>
    </div>
    <div id="load">
        <?php
            if(!empty($products['data'])){
                foreach($products['data'] as $item){
                    ?>
                    <div class="news_product  mtr02">
                        <a href="?mod=weixin&v_mod=product&_index=_view&product=<?php echo $item['product_id'];?>" class="home_product_item">
                            <div class="product_left">
                                <p class="sz12r goods_name"><?php echo $item['product_name']; ?></p>
                                <p class="sz12r goods_name"><?php echo $item['product_desc']; ?></p>
                                <p class="priceColor sz12r">￥<?php echo $item['product_price']; ?></p>
                            </div>
                            <div class="product_right">
                                <img class="lazy" src="<?php echo $item['product_img']; ?>" alt=""/>
                            </div>
                        </a>
                    </div>
                <?php
                }
            }
        ?>
    </div>

    <?php include 'footer_tpl.php';?>
    <script type="text/javascript" src="/tool/layer/layui/layui/layui.js"></script>
    <script type="text/javascript" src="/tool/layer/layui/layui/lay/modules/flow.js"></script>
    <script>
        var swiper = new Swiper('.swiper-container', {
            pagination: '.swiper-pagination',
            paginationClickable: true,
            autoplay:3000,
            autoplayDisableOnInteraction : false
        });
        $(function(){
              $(".lazy").lazyload({
                placeholder : "images/grey.gif",
                effect      : "fadeIn",
                threshold : 200
            });
        });

        $(window).scroll(function(){

            var scrTop = $(this).scrollTop();
            var hdNav = $(".news-nav").height();
            if(scrTop > hdNav){
                $(".news-nav").css('position','fixed')
            }else{
                $(".news-nav").css('position','inherit')
            }

        })
        layui.use('flow', function()
        {
            var flow = layui.flow;
            flow.load({
                elem: '#load' //指定列表容器
                ,done: function(page,next)
                {
                    var lis = [];
                    $.getJSON('/?mod=weixin&page='+page, function(res)
                    {
                        //假设你的列表返回在data集合中
                        layui.each(res.data, function(index, item)
                        {
                            lis.push('<div class="news_product  mtr02">');
                            lis.push('<a href="?mod=weixin&v_mod=product&_index=_view&product='+item.product_id+'" class="home_product_item">');
                            lis.push('<div class="product_left">');
                            lis.push('<p class="sz12r goods_name">');
                            lis.push(item.product_name);
                            lis.push('</p><p class="sz12r goods_name">');
                            lis.push(item.product_desc);
                            lis.push('</p><p class="priceColor sz12r">￥');
                            lis.push(item.product_price);
                            lis.push('</p>');
                            lis.push('</div>');
                            lis.push('<div class="product_right">');
                            lis.push('<img src="'+item.product_img+'">');
                            lis.push('</div>');
                            lis.push('</a>');
                            lis.push('</div>');
                        });
                        next(lis.join(''), page < res.pages);
                    });
                }
            });
        });

        $(function(){

            $(".search-input>input").focus(function(){

                $(this).keyup(function(){
                    if($(this).val()){
                        $(".close-btn").show();
                    }else{
                        $(".close-btn").hide();
                    }
                })
            });
            $(".close-btn").click(function(){
                $(this).hide();
                $(".search-input>input").val('').focus();
            });

            $(".search-tab-bar .tab").each(function(index,elemnt){
                $(elemnt).click(function(){
                    $(this).addClass("active questions").siblings().removeClass("active questions");
                    $(".search-questions .search-questions-well").eq(index).show().siblings().hide();
                })

            })

        });

        function search() {
            var search  = $("#search").val();
            if(search!='')
            {
                window.location.href='/?mod=weixin&v_mod=search&search='+search
            }
        }
	
		
		
		
    </script>
</body>
</html>