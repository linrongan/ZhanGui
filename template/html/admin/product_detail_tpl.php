<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$prodcut = $obj->GetProductDetail();
$data = $obj->GetProductAttrDetail();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title><?php echo WEBNAME; ?></title>
    <link href="/template/html/admin/css/style.default.css" rel="stylesheet">
    <link href="/template/html/admin/css/jquery.datatables.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="/template/html/admin/js/html5shiv.js"></script>
    <script src="/template/html/admin/js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<section>
        <div class="contentpanel">
            <div class="panel panel-default">
                <div class="panel-body">
                    <a href="?mod=admin&v_mod=product&_index=_detail_new&id=<?php echo $_GET['id']; ?>" class="btn btn-primary">新增</a>
                </div>
                <div class="panel-body">
                    <div class="table-responsive dataTable">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>产品图片</th>
                                <th>产品名称</th>
                                <th>描述</th>
                                <th>积分</th>
                            </tr>
                            </thead>
                            </tbody>
                            <tbody>
                            <tr class="odd gradeX">
                                <td class="center"><img width="50" src="<?php echo $prodcut['product_img']; ?>" alt=""></td>
                                <td class="center" id="product_name" onmouseover="layer.tips('<?php echo $prodcut['product_name']; ?>', '#product_name', {tips: [1, '#3595CC'],time: 4000});"><?php echo mb_substr($prodcut['product_name'],0,8,'utf-8'); ?></td>
                                <td class="center" id="product_desc" onmouseover="layer.tips('<?php echo $prodcut['product_desc']; ?>', '#product_desc', {tips: [1, '#3595CC'],time: 4000});"><?php echo mb_substr($prodcut['product_desc'],0,8,'utf-8'); ?></td>
                                <td class="center"><?php echo $prodcut['product_point']; ?></td>
                            </tr>
                        </table>

                        <table class="table">
                            <thead>
                            <tr>
                                <th>属性名称</th>
                                <th>属性内容</th>
                                <th>添加时间</th>
                                <th>编辑</th>
                            </tr>
                            </thead>
                            </tbody>
                            <tbody>
                            <?php
                            if(!empty($data)){
                                foreach($data as $item){
                                    ?>
                                    <tr class="odd gradeX">
                                        <td class="center"><?php echo $item['attr_type_name']; ?></td>
                                        <td class="center"><?php echo $item['attr_name']; ?></td>
                                        <td class="center"><?php echo $item['addtime']; ?></td>
                                        <td class="center">
                                            <a onclick="return confirm('确定要删除吗？')" title="删除"
                                               href="?mod=admin&v_mod=product&_index=_detail_new&id=<?php echo $_GET['id']; ?>&del_id=<?php echo $item['id']; ?>&_action=ActionDelProductAtrr"><span class="fa fa-trash-o"></span>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </table>
                    </div>
                    <div class="clearfix mb30"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="/template/source/js/jquery.js"></script>
<script src="/tool/layer/layer/layer.js"></script>
<?php include "footer_tpl.php"; ?>
</body>
</html>