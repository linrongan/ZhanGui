<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetProductAttrDetailList();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="images/favicon.png" type="image/png">
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
    <div class="mainpanel">
        <div class="pageheader">
            <h2> 产品中心 <span>产品分类</span></h2>
            <div class="breadcrumb-wrapper">
                <span class="label">当前导航:</span>
                <ol class="breadcrumb">
                    <li><a href="">导航</a></li>
                    <li class="active">产品中心</li>
                </ol>
            </div>
        </div>
        <div class="contentpanel">
            <div class="panel panel-default">
                <div class="panel-body">
                    <a href="?mod=admin&v_mod=product&_index=_attr_detail_new" class="btn btn-primary">新增</a>
                </div>
                <div class="panel-body">
                    <h5 class="subtitle mb5">产品分类</h5>
                    <br />
                    <div class="table-responsive dataTable">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>编号</th>
                                <th>属性</th>
                                <th>属性分类</th>
                                <th>编辑</th>
                            </tr>
                            </thead>
                            </tbody>
                            <tbody>
                            <?php
                            if(!empty($data['data'])){
                                foreach($data['data'] as $item){
                                    ?>
                                    <tr class="odd gradeX">
                                        <td class="center"><?php echo $item['attr_id']; ?></td>
                                        <td class="center"><?php echo $item['attr_type_name']; ?></td>
                                        <td class="center"><?php echo $item['attr_name']; ?></td>
                                        <td class="center">
                                            <a title="编辑" href="?mod=admin&v_mod=product&_index=_attr_detail_edit&id=<?php echo $item['attr_id']; ?>">
                                                <span class="fa fa-edit"></span>
                                            </a>
                                            <a onclick="return confirm('确定要删除吗？')" title="删除"
                                               href="/?mod=admin&v_mod=product&_index=_attr_detail&id=<?php echo $item['attr_id']; ?>&_action=ActionDelAttrDetail"><span class="fa fa-trash-o"></span>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </table>
                        <?php
                        include RPC_DIR ."/inc/page_nav.php";
                        $page=new page_nav(array("total"=>$data['total'],
                            "page_size"=>$data['page_size'],
                            "curpage"=>$data['curpage'],
                            "extUrl"=>"",
                            "canshu"=>'&mod=admin&v_mod=feedback&_index=_list'.$data['canshu']));
                        echo $page->page_nav();
                        ?>
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