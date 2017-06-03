<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data=  $obj->GetProductColle();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name = "format-detection" content="telephone = no" />
    <title>我的收藏</title>
    <link type="text/css" rel="stylesheet" href="/template/source/css/font.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/rest.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/ggPublic.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/main.css">
    <style type="text/css">
        .gg-shopping-container .gg-shopping-item{margin-bottom:0; border-top: none;}
        .gg-shopping-container .gg-shopping-item:first-child{border-top: 1px solid #dedede;}
        .weui-cells__title{padding:0 3%;}
        .gg-shopping-warp{
            cursor:pointer
        }
    </style>
</head>
<body>

<div id="gg-app" style="padding:.82rem 0 0 0">

    <div class="gg-detail-header">
        <span class="gg-detail_title sz16r">我的收藏</span>
        <div class="return-back" onclick="javascript :history.back(-1);"></div>
    </div>

    <div class="gg-shopping-container">
        <ul class="gg-shopping-warp">
            <?php
            if($data['data'])
            {
                foreach($data['data'] as $item)
                {
                    ?>
                    <li class="gg-shopping-item" data-active="true">
                        <a href="?mod=weixin&v_mod=product&_index=_view&product=<?php echo $item['product_id']; ?>">
                            <div class="fl gg-shopping-proImg">
                                <img src="<?php echo $item['product_img']; ?>">
                            </div>
                        </a>
                        <div class="fr gg-shopping-main">
                            <a href="?mod=weixin&v_mod=product&_index=_view&product=<?php echo $item['product_id']; ?>">
                                <p class="omit sz14r"><?php echo $item['product_name']; ?></p>
                            </a>
                            <div class="shopping-main-bottom">
                                <span class="fl cldb3652 sz14r">￥<?php echo $item['product_price']; ?></span>
                                <div class="fr removeprint cpanel_cole" ctype="<?php echo $item['product_type']; ?>" pid="<?php echo $item['product_id']; ?>" style="margin-top:.08rem;">
                                    <span class="cldb3652 glyphicon glyphicon-remove sz14r"></span>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </li>
                <?php
                }
            }
            ?>
        </ul>
    </div>
    <?php
    if(!$data['data'])
    {
        ?>
        <div class="search-empty-panel">
            <div class="content">
                <img src="/template/source/images/no_content.png">
                <div class="text">暂无足迹</div>
            </div>
        </div>
    <?php
    }
    ?>
</div>
</body>
<script type="text/javascript" src="/template/source/js/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="/template/source/js/swiper.min.js"></script>
<script type="text/javascript" src="/tool/layer/layer_mobile/layer.js"></script>
<script>
    $(function () {
        //删除收藏
        $(".gg-shopping-warp").on('click','.cpanel_cole',function () {
            var id = $(this).attr('pid');
            var type = $(this).attr('ctype');
            if(id=='' || id==undefined || isNaN(id))
            {
                return false;
            }
            var that = $(this);
            layer.open({
                content: '取消收藏？'
                ,btn: ['确定', '取消']
                ,skin: 'footer'
                ,yes: function(index){
                    $.ajax({
                        type:"get",
                        url:"/?mod=weixin&v_mod=product&id="+id+"&type="+type+"&_action=ActionCancelProductColle",
                        dataType:"json",
                        success:function (res) {
                            if(res.code==0)
                            {
                                that.parent().parent().parent().remove();
                            }
                            layer.open({
                                content: res.msg
                                ,skin: 'msg'
                                ,time: 2 //2秒后自动关闭
                            });
                        },
                        error:function (error) {
                            layer.open({
                                content: '网络超时'
                                ,skin: 'msg'
                                ,time: 2 //2秒后自动关闭
                            });
                        }
                    });
                }
            });
        });
    });

</script>
</html>