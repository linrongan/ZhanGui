<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$user = $obj->GetUserInfo($_SESSION['userid']);
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
		
	.weui-cell_access:active{background:none;}
    </style>
</head>
<body style="background:#f9f9f9">

	
    
   <div id="gg-app" style="padding:0 0 53px 0">
        <div class="gg-my-header">

            <div class="weui-cells" style="margin-top: 0; background:#333;">
                <a class="weui-cell weui-cell_access" href="?mod=weixin&amp;v_mod=user&amp;_index=_info" style="padding:.4rem 3%;">
                    <div class="weui-cell__hd user-img">
                        <img src="<?php echo $user['headimgurl']; ?>">
                    </div>
                    <div class="weui-cell__bd user-text" style="width:50%;">
                        <p class="sz14r omit lhr05 fffColor"><?php echo $user['nickname']; ?></p>
                        <p class="sz12r omit lhr05 fffColor"></p>
                    </div>
                    <div class="weui-cell__ft sz12r fffColor user-mess">修改资料</div>
                </a>
            </div>
        </div>
        <div class="mod-user-content mtr02">
            <div class="mod-user-content_project">
                <a href="?mod=weixin&v_mod=order" class="item">
                       <span class="mr10 left-icon">
                           <img src="/template/source/images/nav/my-nav0.png">
                       </span>
                    <div class="right-text">
                        <p class="sz14r omit">我的订单</p>
                        <p class="sz12r omit cl999">查看所有订单</p>
                    </div>
                </a>
                <a href="?mod=weixin&v_mod=user&_index=_colle" class="item">
                       <span class="mr10 left-icon">
                          <img src="/template/source/images/nav/my-nav1.png">
                       </span>
                    <div class="right-text">
                        <p class="sz14r omit">收藏夹</p>
                        <p class="sz12r omit cl999">收藏过的产品</p>
                    </div>
                </a>
                <div class="clearfix"></div>
            </div>

            <div class="mod-user-content_project">
                <a href="?mod=weixin&v_mod=user&_index=_comment" class="item">
                   <span class="mr10 left-icon">
                       <img src="/template/source/images/nav/my-nav4.png">
                   </span>
                    <div class="right-text">
                        <p class="sz14r omit">我的评价</p>
                        <p class="sz12r cl999 omit">评价记录</p>
                    </div>
                </a>

                <a href="?mod=weixin&v_mod=user&_index=_feedback" class="item">
                   <span class="mr10 left-icon">
                       <img src="/template/source/images/nav/my-nav5.png">
                   </span>
                    <div class="right-text">
                        <p class="sz14r omit">意见反馈</p>
                        <p class="sz12r omit cl999">填写你的意见反馈</p>
                    </div>
                </a>
                <div class="clearfix"></div>
            </div>
        </div>
	    <?php include 'footer_tpl.php';?>
    </div>
    <script>
     
		
		$(".web-footer>a").eq(3).addClass("web-activer").siblings().removeClass("web-activer");
		
		
		
    </script>
</body>
</html>