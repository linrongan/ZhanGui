<?php
    include_once RPC_DIR .'/module/mobile/weixin/classify.php';
    $classify=new classify(array());
    $category = $classify->GetCategory();
?>
<div>
    <div style="height: 1rem;"></div>
    <ul class="web-footer bgF">
        <li>
            <a href="?mod=weixin" class="txtc f12 web-activer ">
                <i class="web-footer-icon"></i>
                <span>首页</span>
            </a>
        </li>
        <li>
            <a href="javascript:;" class="txtc f12" id="menu">
                <i class="web-footer-icon"></i>
                <span>分类</span>
            </a>
            <div class="subitem" style="display:none;">
                <?php
                    if(!empty($category)){
                        foreach($category as $item){
                            ?>
                            <a href="?mod=weixin&v_mod=category&id=<?php echo $item['category_id']?>"><p><?php echo $item['category_name']?></p> </a>
                        <?php
                        }
                    }
                ?>
            </div>
        </li>
        <li>
            <a href="?mod=weixin&v_mod=cart" class="txtc f12">
                <i class="web-footer-icon"></i>
                <span>购物车</span>
            </a>
        </li>
        <li>
            <a href="?mod=weixin&v_mod=user" class="txtc f12 ">
                <i class="web-footer-icon"></i>
                <span>我的</span>
            </a>
        </li>
    </ul>
</div>

<div id="returnTop"></div>
<script type="text/javascript" src="/template/source/js/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="/template/source/js/swiper.min.js"></script>
<script type="text/javascript" src="/template/source/js/returnTop.js"></script>
<script type="text/javascript" src="/template/source/js/jquery.lazyload.min.js"></script>
<script>
    $(".web-footer>a").eq(1).addClass("web-activer").siblings().removeClass("web-activer");
    $(function(){
        $('#menu').click(function(){
            $(this).siblings(".subitem").toggle();
        })
    })
</script>
