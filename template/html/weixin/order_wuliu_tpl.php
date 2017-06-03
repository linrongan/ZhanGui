<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
if(!isset($_GET['no']) || empty($_GET['no']))
{
    redirect(NOFOUND.'&msg单号错误');
}
$data = $obj->GetWuliuStatus($_GET['no']);
if($data['status']!=0)
{
    redirect(NOFOUND.'&msg='.$data['msg']);
}
$wuliu_name = $obj->GetWuLiuName($data['result']['type']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone = no"/>
    <title><?php echo WEBNAME; ?></title>
    <link type="text/css" rel="stylesheet" href="/template/source/css/font.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/rest.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/ggPublic.css?66666aaaa">
    <link type="text/css" rel="stylesheet" href="/template/source/css/main.css">
    <script src="/template/source/js/jquery-1.10.1.min.js"></script>
    <style>
        .weui-cell{padding:.14rem 3%;}
        .weui-cells::before,.weui-cells::after,.weui-cells .weui-cell::before{border:none;}
        .weui-cell:before{left:0;}
        .wuliu-btn{display:inline-block; padding:3px 8px; border:1px solid #333; border-radius:3px; color:#333;}
        .porduct_hd{background:white; border-bottom:none; padding:.1rem 3%;}
        .porduct_jshao:last-child{border-bottom:none;}
        .noborder .weui-cell{padding:0 3%; line-height:.5rem;}
		
		.weui-wuliu .weui-cells .weui-cell{border-bottom:1px solid #e8e8e8;}
		.weui-wuliu .weui-cells .weui-cell:first-child{}
		.weui-wuliu .weui-cells .weui-cell:last-child{border-bottom:none;}
    </style>
</head>
<body>
<div class="weui-cells" style="margin-top:0;">
	<div class="weui-cell">
        <div class="weui-cell__hd">
            <span class="sz14r">物流类型：</span>
        </div>
        <div class="weui-cell__bd"></div>
        <div class="weui-cell__ft">
            <span class="sz14r redColor"><?php echo $wuliu_name['logistics_name']; ?></span>
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd">
            <span class="sz14r">物流单号：</span>
        </div>
        <div class="weui-cell__bd"></div>
        <div class="weui-cell__ft">
            <span class="sz14r"><?php echo $_GET['no']; ?></span>
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd">
            <span class="sz14r">物流状态：</span>
        </div>
        <div class="weui-cell__bd"></div>
        <div class="weui-cell__ft">
            <span class="sz14r">
                <?php
                $wuliu_status = array(1=>'在途中',2=>'派件中',3=>'已签收',4=>'派送失败(拒签等)');
                echo $wuliu_status[$data['result']['deliverystatus']];
                ?></span>
        </div>
    </div>
</div>
<div class="weui-wuliu">
    <div class="weui-cells">
        <?php
            if(!empty($data['result']['list']))
            {
                $result = $data['result']['list'];
                for($i=count($result)-1;$i>=0;$i--)
                {
                    ?>
                    <div class="weui-cell">
                        <div class="weui-cell__hd" style="width:2.5rem; margin-right:.2rem;">
                            <span class="sz12r cl999 "><?php echo $result[$i]['time']; ?></span>
                        </div>
                        <div class="weui-cell__bd">
                         
                        </div>
                        <div class="weui-cell__ft">
                           <p class="sz12r txtr"><?php echo $result[$i]['status']; ?></p>
                        </div>
                    </div>
                    <?php
                }
            }
        ?>
    </div>
</div>
</body>
<script type="text/javascript" src="/tool/layer/layer_mobile/layer.js"></script>
</html>