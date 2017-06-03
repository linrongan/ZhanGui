<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data=$obj->GetAdminAuthPage(1);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title><?php echo WEBNAME; ?></title>
    <link href="/template/html/admin/css/style.default.css" rel="stylesheet">
    <link href="/template/html/admin/css/jquery.datatables.css" rel="stylesheet">
    <script src="/template/html/admin/js/html5shiv.js"></script>
    <script src="/template/html/admin/js/respond.min.js"></script>
</head>
<body>
<section>
    <div class="mainpanel">
        <div class="pageheader">
            <h2><i class="fa fa-home"></i> 权限菜单 <span>所有菜单</span></h2>
            <div class="breadcrumb-wrapper">
                <span class="label">当前导航:</span>
                <ol class="breadcrumb">
                    <li><a href="">导航</a></li>
                    <li class="active">所有菜单</li>
                </ol>
            </div>
        </div>
        <div class="contentpanel">
            <div class="panel panel-default">
                <div class="panel-body">
                    <a href="?mod=admin&_index=_role_page_new" class="btn btn-default">新增</a>
                </div><!-- panel-body -->
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <h5 class="subtitle mb5">菜单列表</h5>
                    <br />
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>名称</th>
                                <th>排序</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($data)){
                                foreach($data as $item){
                                    ?>
                                    <tr class="odd gradeX">
                                        <td class="center">
                                            <span class="fa fa-folder-o"></span>
                                            <?php echo $item['ry_menu'];?>
                                        </td>
                                        <td class="center">
                                            <?php echo $item['ry_order'];?>
                                        </td>
                                        <td class="center">
                                            <a href="?mod=admin&_index=_role_page_edit&id=<?php echo $item['id']; ?>"><i class="fa fa-pencil"></i></a>
                                            <a href="?mod=admin&_index=_role_page_edit&_action=DelAuthPage&id=<?php echo $item['id']; ?>" onClick="return confirm('确定要删除吗？删除该项目将同时删除分类下的其他子页面')">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                    if (!empty($item))
                                    {
                                        $array_key=array_keys($item);
                                        //找出需要循环数组的二级分类
                                        foreach ($array_key as $key=>$value)
                                        {
                                            if (is_array($item[$value]))
                                            {
                                                ?>
                                                <tr class="odd gradeX">
                                                    <td class="center">
                                                        &nbsp;&nbsp;&nbsp;|_____ <span class="fa fa-folder-open-o"></span>
                                                        <?php echo $item[$value]['ry_menu'];?>
                                                    </td>
                                                    <td class="center">
                                                        <?php echo $item[$value]['ry_order'];?>
                                                    </td>
                                                    <td class="center">
                                                        <a href="?mod=admin&_index=_role_page_edit&id=<?php echo $item[$value]['id']; ?>"><i class="fa fa-pencil"></i></a>
                                                        <a href="?mod=admin&_index=_role_page_edit&_action=DelAuthPage&id=<?php echo $item[$value]['id']; ?>" onClick="return confirm('确定要删除吗？删除该分类将同时删除分类下的商品和相关购物车内商品')">
                                                            <i class="fa fa-trash-o"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php

                                            $array_key_sub=array_keys($item[$value]);
                                            foreach ($array_key_sub as $k=>$v)
                                            {
                                                if (is_array($item[$value][$v]))
                                                {
                                                    ?>

                                                    <tr class="odd gradeX">
                                                        <td class="center">
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|_____<span class="fa fa-key"></span>
                                                            <?php echo $item[$value][$v]['ry_menu'];?>
                                                        </td>
                                                        <td class="center">
                                                            <?php echo $item[$value][$v]['ry_order'];?>
                                                        </td>
                                                        <td class="center">
                                                            <a href="?mod=admin&_index=_role_page_edit&id=<?php echo $item[$value][$v]['id']; ?>"><i class="fa fa-pencil"></i></a>
                                                            <a href="?mod=admin&_index=_role_page_edit&_action=DelAuthPage&id=<?php echo $item[$value][$v]['id']; ?>" onClick="return confirm('确定要删除吗？删除该分类将同时删除分类下的商品和相关购物车内商品')">
                                                                <i class="fa fa-trash-o"></i>
                                                            </a>
                                                        </td>
                                                    </tr>

                            <?php

                                                }
                                            }
                                          }
                                        }
                                    }
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="clearfix mb30"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="/template/source/js/jquery.js"></script>
<script src="/template/html/admin/js/custom.js"></script>
</body>
</html>