<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetProduct(6);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name = "format-detection" content="telephone = no" />
    <title>全部产品</title>
    <link type="text/css" rel="stylesheet" href="/tool/layer/layui/layui/css/layui.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/font.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/font.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/rest.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/ggPublic.css?9999">
    <link type="text/css" rel="stylesheet" href="/template/source/css/main.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/newmain.css">
    <style>
        .gg-product_text{padding:.1rem 5% 0;}
        .gg-product_price{padding:0 5% .1rem;}
        .red{color: red}
    </style>
</head>
<body>
<div id="gg-app" style="padding:.82rem 0 0 0">
    <div class="gg-detail-header">
        <span class="gg-detail_title sz16r">全部产品</span>
        <a href="/?mod=weixin" class="return-back" ></a>
    </div>

    <div class="gg-product" style="margin-top:.2rem;">
        <div id="load">
            <?php
            if(!empty($data['data'])){
                foreach($data['data'] as $item){
                    ?>
                    <div class="news_product  mtr02">
                        <a href="?mod=weixin&v_mod=product&_index=_view&product=<?php echo $item['product_id'];?>" class="home_product_item">
                            <div class="product_left">
                                <p class="sz12r goods_name"><?php echo $item['product_name']; ?></p>
                                <p class="priceColor sz12r">￥<?php echo $item['product_price']; ?></p>
                            </div>
                            <div class="product_right">
                                <img class="lazy" src="<?php echo $item['product_img']; ?>" alt=""/>
                            </div>
                        </a>
                    </div>
                <?php
                }
            }else{
                ?>
                <div class="search-empty-panel">
                    <div class="content">
                        <img src="/template/source/images/no_content.png">
                        <div class="text">没有了</div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

</div>
<?php include 'footer_tpl.php';?>
</body>
<script type="text/javascript" src="/tool/layer/layui/layui/layui.js"></script>
<script type="text/javascript" src="/tool/layer/layui/layui/lay/modules/flow.js"></script>
<script>
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
                        lis.push('<img src="'+item.product_img+'">');
                        lis.push('</div>');
                        lis.push('<div class="product_right">');
                        lis.push('<p class="sz12r goods_name">');
                        lis.push(item.product_name);
                        lis.push('</p>');
                        lis.push('<p class="priceColor sz12r">￥');
                        lis.push(item.product_price);
                        lis.push('</p>');
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
</html>