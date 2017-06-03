<?php
$data = $obj->GetProductAttr();
?>
<html lang="en"><head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title><?php echo WEBNAME; ?></title>
    <link href="/template/html/admin/css/style.default.css" rel="stylesheet">
    <link href="/template/html/admin/css/jquery.datatables.css" rel="stylesheet">
    <script src="/template/html/admin/js/html5shiv.js"></script>
    <script src="/template/html/admin/js/respond.min.js"></script>
    <link rel="stylesheet" href="/tool/layer/layer/skin/layer.css" id="layui_layer_skinlayercss"></head>
<body>
<section>
    <div class="contentpanel">
        <div class="panel panel-default">
            <div class="panel-body">
                <a href="/?mod=admin&v_mod=product&_index=_attr_new&product=<?php echo $_GET['id']; ?>" class="btn btn-primary">新增</a>
            </div>
            <div class="panel-body">
                <div class="table-responsive dataTable">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>产品图片</th>
                            <th>产品名称</th>
                            <th>描述</th>
                            <th>价格</th>
                        </tr>
                        </thead>

                        <tbody>
                            <tr class="odd gradeX">
                                <td class="center"><img width="50" src="<?php echo $data['product']['product_img']; ?>" alt=""></td>
                                <td class="center" id="product_name"><?php echo $data['product']['product_name']; ?></td>
                                <td class="center" id="product_desc"><?php echo $data['product']['product_desc']; ?></td>
                                <td class="center"><?php echo $data['product']['product_price']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>属性名称</th>
                                <th>属性内容</th>
                                <th>价格</th>
                                <th>编辑</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if($data['attr'])
                                {
                                    foreach($data['attr'] as $item)
                                    {
                                        ?>
                                        <tr class="odd gradeX">
                                            <td class="center"><?php echo $item['attr_type_name']; ?></td>
                                            <td class="center"><?php echo $item['attr_temp_name']; ?></td>
                                            <td class="center"><?php echo $data['product']['product_price']."+".$item['attr_price']; ?></td>
                                            <td class="center">
                                                <a onclick="return confirm('确定要删除？')"
                                                   href="/?mod=admin&v_mod=product&_index_attr_list&product=<?php echo $_GET['id']; ?>&id=<?php echo $item['id']; ?>&_action=ActionDelProductAttr">
                                                    <span class="fa fa-trash-o"></span>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
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
</section>
<script src="/template/source/js/jquery.js"></script>
<script src="/tool/layer/layer/layer.js"></script>
</body>
</html>