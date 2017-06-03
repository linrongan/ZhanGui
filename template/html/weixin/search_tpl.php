<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetSearchText(6);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone = no"/>
    <title>搜索到的产品</title>
    <link rel="stylesheet" href="/tool/layer/layui/layui/css/layui.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/font.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/rest.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/ggPublic.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/main.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/newmain.css">
    <style>
        .search-bar {
            position: relative;
            padding: 10px 65px 10px 10px;
            background-color: #fff;
        }
        .search-bar .search-btn_ {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 60px;
            height: 30px;
            line-height: 30px;
            font-size: 1.0em;
            text-align: center;
            color: #333;
        }
    </style>
</head>
<body style="background:#f9f9f9">
<div class="search-page">
    <div class="search-bar">
        <div class="search-input">
            <input placeholder="输入关键字搜索产品" id="search">
            <div class="close-btn"></div>
            <div class="search-pro-btn" onclick="search()"></div>
        </div>
        <div class="search-btn_" onclick="javascript :history.back(-1);">取消</div>
    </div>
    <div class="search-questions">
        <div class="search-questions-well" id="load">
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
                <!---没有提示-->
                <div class="search-empty-panel">
                    <div class="content">
                        <img src="/template/source/images/no_content.png">
                        <div class="text">暂无相关产品</div>
                    </div>
                </div>
            <?php
            }
            ?>

        </div>
    </div>
</div>
<div id="returnTop"></div>

<?php include 'footer_tpl.php';?>
<script type="text/javascript" src="/template/source/js/swiper.min.js"></script>
<script type="text/javascript" src="/template/source/js/returnTop.js"></script>
<script type="text/javascript" src="/template/source/js/jquery.lazyload.min.js"></script>
<script type="text/javascript" src="/tool/layer/layui/layui/layui.js"></script>
<script type="text/javascript" src="/tool/layer/layui/layui/lay/modules/flow.js"></script>
<script type="text/javascript">

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
            $(".search-input>input").val('');
        });

        $(".search-tab-bar .tab").each(function(index,elemnt){
            $(elemnt).click(function(){
                $(this).addClass("active questions").siblings().removeClass("active questions");
                $(".search-questions .search-questions-well").eq(index).show().siblings().hide();
            })

        })


    });

    $(".search-list").click(function () {
        var link = $(this).attr('link');
        if(link=='')
        {
            var world = $(this).children().eq(0).html();
            $("#search").val(world);
        }
    });
    function search() {
        var search  = $("#search").val();
        if(search!='')
        {
            window.location.href='/?mod=weixin&v_mod=search&search='+search
        }
    }
    layui.use('flow', function()
    {
        var flow = layui.flow;
        var search = '<?php echo $_REQUEST['search'];?>';
        flow.load({
            elem: '#load' //指定列表容器
            ,done: function(page,next)
            {
                var lis = [];
                $.getJSON('/?mod=weixin&v_mod=search&search='+search+'&page='+page, function(res)
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