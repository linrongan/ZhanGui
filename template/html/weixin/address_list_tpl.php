<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetUserAddress();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name = "format-detection" content="telephone = no" />
    <title>我的地址</title>
    <link type="text/css" rel="stylesheet" href="/template/source/css/font.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/rest.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/ggPublic.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/main.css">

    <style type="text/css">

        .weui-cells:before {
         border-top:none;
        }
    </style>
</head>
<body>
    <div id="gg-app" style="padding:1.06rem 0 0 0">

        <div class="gg-detail-header">
            <span class="gg-detail_title sz16r">我的地址</span>
            <div class="return-back" onclick="javascript :history.back(-1);"></div>
        </div>

        <div class="weui-cells" style="margin-top: 0;">
            <?php
                if($data)
                {
                    foreach($data as $item)
                    {
                        ?>
                        <div class="arrder-item">
                            <a class="weui-cell weui-cell_access"
                               href="/?mod=weixin&v_mod=address&_index=_edit&id=<?php echo $item['id']; ?>&redirect=<?php echo urlencode('/?mod=weixin&v_mod=address&_index=_list'); ?>">
                                <div class="weui-cell__bd" >
                                    <p class="sz14r"><?php echo $item['shop_name']; ?>&nbsp;&nbsp;<?php echo $item['shop_phone']; ?></p>
                                    <p class="sz12r cl999 "><?php echo $item['address']; ?></p>
                                </div>
                                <div class="weui-cell__ft"><?php echo $item['default_select']==0?'<span class="moren sz12r">默认</span>':''; ?></div>
                            </a>
                        </div>
                        <?php
                    }
                }
            ?>

        </div>
        <?php
            if(count($data)<10)
            {
                ?>
                <div class="weui-cells mtr02">
                    <a class="weui-cell weui-cell_access" href="?mod=weixin&v_mod=address&_index=_add&redirect=<?php echo urlencode('/?mod=weixin&v_mod=address&_index=_list'); ?>">
                        <div class="weui-cell__hd address-img"><img src="/template/source/images/icon-address.png"></div>
                        <div class="weui-cell__bd">
                            <p class="sz14r">添加新地址</p>
                        </div>
                        <div class="weui-cell__ft"></div>
                    </a>
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