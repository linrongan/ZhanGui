<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title><?php echo WEBNAME; ?></title>
    <link href="/template/html/admin/css/style.default.css" rel="stylesheet">
    <script language="javascript">
        function getObject(objectId) {
            if(document.getElementById && document.getElementById(objectId)) {
                // W3C DOM
                return document.getElementById(objectId);
            }
            else if (document.all && document.all(objectId)) {
                // MSIE 4 DOM
                return document.all(objectId);
            }
            else if (document.layers && document.layers[objectId]) {
                // NN 4 DOM.. note: this won't find nested layers
                return document.layers[objectId];
            }
            else
            {
                return false;
            }
        }

        function showHide(objname){
            var obj = getObject(objname);
            if(obj.style.display == "none"){
                obj.style.display = "block";
            }else{
                obj.style.display = "none";
            }
        }
    </script>
    <base target="main">
</head>
<body style="background: #1d2939;">
<div class="leftpanel">
    <div class="leftpanelinner">
        <h5 class="sidebartitle">导航菜单</h5>
        <ul class="nav nav-pills nav-stacked nav-bracket">
            <?php
            $page_array=$obj->GetAdminAuthPage(0);
            if (!empty($page_array))
            {
            $auth_menu=$obj->GetMyAuthMenu();
            foreach ($page_array as $page)
            {
                if (!in_array($page['id'],$auth_menu) || $page['menu_type'])
                {
                    continue;
                }
            ?>
            <li class="nav-parent" id="user_list">
                <a href="javascript:void(0)">
                    <i class="fa <?php echo $page['style_class']?$page['style_class']:" fa-chevron-circle-left"; ?>"></i>
                    <span>
                        <?php echo $page['ry_menu'];?>
                    </span>
                </a>
            <?php
            if (!empty($page))
            {
            $array_key=array_keys($page);
            ?>
                <ul class="children">
                    <?php //找出需要循环数组的二级分类
                    foreach ($array_key as $key=>$value)
                    {
                    if (is_array($page[$value]))
                    {
                        if (!in_array($page[$value]['id'],$auth_menu) || $page[$value]['menu_type'])
                        {
                            continue;
                        }
                        ?>
                    <li>
                        <a href="<?php echo $page[$value]['ry_link'];?>">
                            <i class="fa fa-caret-right"></i>
                            <?php echo $page[$value]['ry_menu'];?>
                        </a>
                    </li>
                    <?php }
                    }
                    ?>
                </ul>
                <?php } ?>
            </li>
            <?php
            }
        } ?>
        </ul>
    </div>
</div>
</body>
<script src="/template/source/js/jquery.js"></script>
<script src="/template/html/admin/js/custom.js"></script>
</html>