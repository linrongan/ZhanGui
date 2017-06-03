<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data = $obj->GetAllMerchant();
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
            <h2><i class="fa fa-home"></i> 统计中心 <span>短信验证明细</span></h2>
            <div class="breadcrumb-wrapper">
                <span class="label">当前导航:</span>
                <ol class="breadcrumb">
                    <li><a href="">导航</a></li>
                    <li class="active">短信验证明细</li>
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
                            <input value="<?php echo isset($_REQUEST['sms_date'])?trim($_REQUEST['sms_date']):""; ?>" type="date" placeholder="" id="sms_date" name="sms_date" class="form-control">
                        </div>
                        <button class="btn btn-primary" type="submit">查询</button>
                        <button onclick="window.location.href='/?mod=admin&v_mod=statistic&_index=_sms'" class="btn btn-default" type="button">重置</button>
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
                                <th>时间</th>
                                <th>手机号</th>
                                <th>验证码</th>
                                <th>编辑</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($data['data'])){
                                foreach($data['data'] as $item){
                                    ?>
                                    <tr class="odd gradeX">
                                        <td class="center">
                                            <?php echo $item['sms_date'].'&nbsp;'.$item['sms_time']; ?>
                                        </td>
                                        <td class="center">
                                            <?php echo $item['phone'] ?>
                                        </td>
                                        <td class="center">
                                            <?php echo $item['smscode']; ?>
                                        </td>
                                        <td class="center">
                                            <a onclick="return confirm('确定要删除吗？')" title="删除" href="/?mod=admin&v_mod=statistic&_index=_sms&id=<?php echo $item['id']; ?>&_action=ActionStatisticSmsDel">
                                                <span class="fa fa-trash-o"></span>
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
                            "canshu"=>'&mod='.$_GET['mod'].'&v_mod='.$_GET['v_mod'].'&_index=_sms'.$data['canshu']));
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
</body>
</html>