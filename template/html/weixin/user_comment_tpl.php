<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetCommentList();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name = "format-detection" content="telephone = no" />
    <title>评论记录</title>
    <link type="text/css" rel="stylesheet" href="/template/source/css/font.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/rest.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/ggPublic.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/main.css">
    <style type="text/css">
        .user-img>img{width:.8rem; height:.8rem; border-radius: 0;}
    </style>
</head>
<body>
<div id="gg-app" style="padding:1.06rem 0 0 0">
    <div class="gg-detail-header">
        <span class="gg-detail_title sz16r">评论记录</span>
        <div class="return-back" onclick="javascript :history.back(-1);"></div>
    </div>
    <div class=" weui-cells" style="margin-top:0;">
        <?php
        $link = array('/?mod=weixin&v_mod=product&_index=_view&product=','/?mod=weixin&v_mod=group&_index=_details&id=');
        if($data['data'])
        {
            foreach($data['data'] as $val)
            {
                ?>
                <div class="weui-cell" onclick="location.href='<?php echo $link[$val['product_type']].$val['product_id']; ?>'">
                    <div class="weui-cell__hd user-img topImg">
                        <img src="<?php echo $val['product_img']; ?>" alt="">
                    </div>
                    <div class="weui-cell__bd w83Ml17">
                        <div class="sz14r"><?php echo $val['product_name']; ?></div>
                        <div class="nandu-item">
                            <?php
                            for($i=0;$i<$val['comment_level'];$i++)
                            {
                                ?>
                                <span class="active-2"></span>
                            <?php
                            }
                            ?>
                        </div>
                        <div>
                            <span class="sz14r"><?php echo $val['comment']; ?></span>
                        </div>
                        <div>
                            <span class=" sz12r cl999"><?php echo $val['addtime']; ?></span>
                        </div>
                    </div>
                </div>
            <?php
            }
        }
        ?>
    </div>


    <?php
    if(!$data['data'])
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


<script type="text/javascript" src="/template/source/js/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="/template/source/js/swiper.min.js"></script>
<script>

</script>


</body>
</html>