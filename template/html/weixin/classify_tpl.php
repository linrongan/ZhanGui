<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetCategoryDetails(intval($_GET['category']),6);
$category = $obj->GetCategory();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone = no"/>
    <title><?php echo $data['category']['category_name'];?></title>
    <link rel="stylesheet" href="/tool/layer/layui/layui/css/layui.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/font.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/rest.css?6666666666">
    <link type="text/css" rel="stylesheet" href="/template/source/css/ggPublic.css?77777777777">
    <link type="text/css" rel="stylesheet" href="/template/source/css/main.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/newmain.css?666666">
    <style>
		.weui-search-bar{background:#f9f9f9;}
        .swiper-container{min-height:2rem;}
        .swiper-slide img{width:100%; display:block}
        .swiper-pagination{text-align: right}
        .swiper-pagination-bullet{background:#ad0e11; }
        .weui-search-bar{background:#f9f9f9;}
    </style>

</head>
<body style="background:#f9f9f9">
    <?php include 'header_tpl.php';?>
    <div class="pre-group">
        <div class="custom-image4 clearfix">
            <ul>
                <?php
                if(!empty($category)){
                    foreach($category as $item){
                        ?>
                        <li><a href="?mod=weixin&v_mod=category&id=<?php echo $item['category_id']?>"
                                class="<?php if($data['category']['parent_id']==$item['category_id']
                                    ||$_GET['category']==$item['category_id']){ echo 'redColor';}?>"><span class="sz12r"><?php echo $item['category_name']?></span></a></li>
                    <?php
                    }
                }
                ?>
            </ul>
        </div>
    </div>


    <div class="search-bar">
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
            <a href="javascript:;" class="sz14r"><?php echo $data['category']['category_name'];?></a>
        </div>
    </div>

    <div class="web-yp-product" id="load">
        <?php
            if(!empty($data['products']['data'])){
                foreach($data['products']['data'] as $item){
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
        <div class="clearfix"></div>
    </div>
    <div class="mtr02">
        <?php echo $data['category']['category_desc']?>
    </div>
    
    
    
    <?php include 'footer_tpl.php';?>
    <script type="text/javascript" src="/tool/layer/layui/layui/layui.js"></script>
    <script type="text/javascript" src="/tool/layer/layui/layui/lay/modules/flow.js"></script>
    <script>

        var swiper = new Swiper('.swiper-container', {
            pagination: '.swiper-pagination',
            paginationClickable: true,
            autoplay:3000,
            autoplayDisableOnInteraction : true
        });

        layui.use('flow', function()
        {
            var flow = layui.flow;
            var category = '<?php echo intval($_GET['category']);?>';
            flow.load({
                elem: '#load' //指定列表容器
                ,done: function(page,next)
                {
                    var lis = [];

                    $.getJSON('/?mod=weixin&v_mod=classify&category='+category+'&page='+page, function(res)
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
		
    </script>
</body>
</html>