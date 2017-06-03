<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetNavigationlist();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
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
            <h2> 图片管理 <span>轮播图</span>  <span>首页导航</span></h2>
            <div class="breadcrumb-wrapper">
                <span class="label">当前导航:</span>
                <ol class="breadcrumb">
                    <li><a href="">导航</a></li>
                    <li class="active">图片管理</li>
                </ol>
            </div>
        </div>
        <div class="contentpanel">
            <div class="panel panel-default">
                <div class="panel-body">
                    <a href="?mod=admin&v_mod=navigation&_index=_new" class="btn btn-primary">新增</a>
                </div>
                <div class="panel-body">
                    <h5 class="subtitle mb5">产品分类</h5>
                    <br />
                    <div class="table-responsive dataTable">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>标题</th>
                                <th>图片</th>
                                <th>链接</th>
                                <th>排序</th>
                                <th>显示</th>
                                <th>添加时间</th>
                                <th>编辑</th>
                            </tr>
                            </thead>
                            </tbody>
                            <tbody>
                            <?php
                            if($data['data'])
                            {
                                foreach($data['data'] as $item)
                                {
                                    ?>
                                    <tr class="odd gradeX">
                                        <td class="center"><?php echo $item['fields_title']; ?></td>
                                        <td class="center"><img src="<?php echo $item['fields_image']; ?>" width="50" alt=""></td>
                                        <td class="center"><?php echo $item['fields_link']; ?></td>
                                        <td class="center"><?php echo $item['fields_order']; ?></td>
                                        <td class="center"><?php echo $item['fields_show']==0?'是':'否'; ?></td>
                                        <td class="center"><?php echo $item['fields_addtime']; ?></td>
                                        <td class="center">
                                            <a title="编辑" href="?mod=admin&v_mod=navigation&_index=_edit&id=<?php echo $item['id']; ?>" >
                                                <span class="fa fa-edit"></span>
                                            </a>
                                            <a onclick="return confirm('确定要删除吗？')" title="删除"
                                               href="/?mod=admin&v_mod=navigation&_index=_list&id=<?php echo $item['id']; ?>&_action=ActionDelNavigation"><span class="fa fa-trash-o"></span>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
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
<script src="/template/source/js/jquery.js"></script>
<script src="/tool/layer/layer/layer.js"></script>
<?php include "footer_tpl.php"; ?>
</body>
</html>