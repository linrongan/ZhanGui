<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data=$obj->GetProductList();
?>
<!DOCTYPE html>
<html lang="en">
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
            <h2></i> 产品中心 <span>商品列表</span></h2>
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
                <div class="panel-heading">
                    <h4 class="panel-title">条件查询</h4>
                    <p></p>
                </div>
                <div class="panel-body">
                    <form class="form-inline" method="post" action="">
                        <div class="form-group">
                            <label for="exampleInputEmail2" class="sr-only">选择条件</label>
                            <input value="<?php echo isset($_REQUEST['product_name'])?trim($_REQUEST['product_name']):""; ?>" type="text" placeholder="按商品名称模糊查询" id="product_name" name="product_name" class="form-control">
                        </div>
                        <button class="btn btn-primary" type="submit">查询</button>
                        <a href="?mod=admin&v_mod=product&_index=_list" class="btn btn-default">取消</a>
                        <a href="?mod=admin&v_mod=product&_index=_new" class="btn btn-primary">新增</a>
                    </form>
                </div><!-- panel-body -->
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <h5 class="subtitle mb5">商品列表</h5>
                    <br />
                    <div class="table-responsive dataTable">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>商品编号</th>
                                <th>产品分类</th>
                                <th>商品名称</th>
                                <th>商品图片</th>
                                <th>原价</th>
                                <th>售价</th>
                                <th>排序</th>
                                <th>状态</th>
                                <th>编辑</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($data['data'])){
                                foreach($data['data'] as $item){
                                    ?>
                                    <tr class="odd gradeX">
                                        <td class="center">
                                            <?php echo $item['product_id'] ?>
                                        </td>
                                        <td class="center">
                                            <?php echo $item['category_name']; ?>
                                        </td>
                                        <td class="center">
                                            <?php echo $item['product_name']; ?>
                                        </td>
                                        <td class="center">
                                            <?php
                                            if($item['product_img']){
                                                ?>
                                                <img width="50" src="<?php echo $item['product_img']; ?>" alt="">
                                                <?php
                                            }else
                                            {
                                                echo '-';
                                            }
                                            ?>
                                        </td>
                                        <td class="center">
                                            <?php echo $item['product_fake_price']; ?>
                                        </td>
                                        <td class="center">
                                            <?php echo $item['product_price']; ?>
                                        </td>
                                        <td class="center">
                                            <?php echo $item['product_sort']; ?>
                                        </td>

                                        <td class="center">
                                            <?php echo $item['product_status']==0?'上架':'下架'; ?>
                                        </td>

                                        <td class="center">
                                            <a title="编辑" href="/?mod=admin&v_mod=product&_index=_edit&id=<?php echo $item['product_id']; ?>">
                                                <span class="fa fa-edit"></span>
                                            </a>
                                            <a onclick="return confirm('确定要删除吗？')" title="删除"
                                               href="/?mod=admin&v_mod=product&_index=_list&id=<?php echo $item['product_id']; ?>&_action=ActionDelProduct">
                                                <span class="fa fa-trash-o"></span>
                                            </a>
                                            <a href="javascript:;" onclick="show_attr(<?php echo $item['product_id']; ?>,'<?php echo $item['product_name']; ?>')" title="属性">
                                                <span class="glyphicon glyphicon-tint"></span>
                                            </a>
                                        </td>
                                    </tr>
                                <?php }
                            } ?>
                            </tbody>
                        </table>
                        <?php
                        include RPC_DIR ."/inc/page_nav.php";
                        $page=new page_nav(array("total"=>$data['total'],
                            "page_size"=>$data['page_size'],
                            "curpage"=>$data['curpage'],
                            "extUrl"=>"",
                            "canshu"=>'&mod='.$_GET['mod'].'&v_mod='.$_GET['v_mod'].'&_index='.$_GET['_index'].$data['canshu']));
                        echo $page->page_nav();
                        ?>
                    </div>
                    <div class="clearfix mb30"></div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
<script src="/template/source/js/jquery.js"></script>
<script src="/tool/layer/layer/layer.js"></script>
<?php include "footer_tpl.php"; ?>
<script>
    function show_attr(id,title) {
        if(id && !isNaN(id))
        {
            layer.open({
                type: 2,
                title: title,
                shadeClose: true,
                shade: 0.8,
                area: ['80%', '90%'],
                content: '/?mod=admin&v_mod=product&_index=_attr_list&id='+id //iframe的url
            });
        }
    }
</script>
</html>