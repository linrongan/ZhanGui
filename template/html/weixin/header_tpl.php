<?php $user = $obj->GetUserInfo($_SESSION['userid']); ?>
<header data-fixed-type="cHead">
    <div class="left-bar">
        <a href="" class="">
            <img class="logo" src="<?php echo $user['headimgurl']; ?>">
            <span class="nickname"><?php echo $user['nickname']; ?></span>
        </a>
    </div>
    <div class="right-bar">

<!--        <a class="header-search" href="?mod=weixin&v_mod=search"></a>-->

        <a href="?mod=weixin&v_mod=order" target="_self">我的订单</a>
    </div>
</header>