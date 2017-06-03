<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$info = $obj->GetCategory();
$data = $info['category'];
$id = 0;
if($data)
{
    if(isset($_GET['id']) && !empty($_GET['id']))
    {
        $id = $_GET['id'];
    }else{
        $id = $info['data'][0]['category_id'];
    }
}
//echo '<pre>';
//var_dump($data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name = "format-detection" content="telephone = no" />
    <title>产品分类</title>
    <link type="text/css" rel="stylesheet" href="/template/source/css/font.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/weui.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/swiper.min.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/rest.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/ggPublic.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/main.css">
    <link type="text/css" rel="stylesheet" href="/template/source/css/newmain.css?666666">
    <style>
        html,body{position:relative; width: 100%; height:100%; overflow: hidden;}
        #gg-app{padding: 0;}

    </style>
</head>
<body>
    <div id="gg-app" >
        <div class="gg-classify-box">
            <div class="gg-classify-leftnav fl">
                <ul>
                    <?php
                        if($data[0])
                        {
                            foreach($data[0] as $item)
                            {
                                ?>
                                <li class="<?php if($item['category_id']==$id){echo 'leftnav-active';} ?>">
                                    <a href="/?mod=weixin&v_mod=category&id=<?php echo $item['category_id']; ?>" class="sz14r omit">
                                        <?php echo $item['category_name']; ?>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                    ?>
                </ul>
            </div>
            <div class="gg-classify-rightpro fl">
                <div class="hot-pic mtr02">
                    <?php
                        if(!empty($data[0][$id]['category_img']))
                        {
                            ?>
                            <img src="<?php echo $data[0][$id]['category_img'];?>">
                            <?php
                        }
                    ?>
                </div>
                <div class="rightpro-warp">
                    <div class="rightpro-warp-item"></div>
                    <div class="rightpro-warp-item">
                        <h1 class="mtr01">分类选项</h1>
                        <div class="classify-product mtr01">
                            <ul>
                                <?php
                                if($data)
                                {
                                    if(isset($data[$id]) && !empty($data[$id]))
                                    {
                                        foreach($data[$id] as $item)
                                        {
                                            ?>
                                            <li>
                                                <a href="?mod=weixin&v_mod=classify&category=<?php echo $item['category_id']; ?>">
                                                    <div class="classify-product-img"><img src="<?php echo $item['category_img']; ?>"></div>
                                                    <p class="omit sz12r mtr01"><?php echo $item['category_name']; ?></p>
                                                </a>
                                            </li>
                                            <?php
                                        }
                                    }else
                                    {
                                        redirect('?mod=weixin&v_mod=classify&category='.$id);
                                    }
                                }
                                ?>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div id="returnTop"></div>
    <?php include 'footer_tpl.php';?>
</body>
    <script type="text/javascript" src="/template/source/js/jquery-1.10.1.min.js"></script>
    <script type="text/javascript" src="/template/source/js/swiper.min.js"></script>
    <script type="text/javascript " src="/template/source/js/returnTop.js"></script>
    <script>
        $(function(){

			
        })


		
		
    </script>
</html>