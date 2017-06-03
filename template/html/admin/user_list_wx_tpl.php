<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$data=$obj->UserListWx();
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
            <h2><i class="fa fa-home"></i> 会员管理 <span>微信粉丝列表</span></h2>
            <div class="breadcrumb-wrapper">
                <span class="label">当前导航:</span>
                <ol class="breadcrumb">
                    <li><a href="">导航</a></li>
                    <li class="active">会员管理</li>
                </ol>
            </div>
        </div>

        <div class="contentpanel">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h5 class="subtitle mb5">粉丝列表</h5>
                    <br />
                    <div class="table-responsive dataTable">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>昵称</th>
                                <th>头像</th>
                                <th>订阅时间</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($data['data'])){
                                foreach($data['data'] as $item){
                                    ?>
                                    <tr class="odd gradeX">
                                        <td class="center">
                                            <?php echo $item['nickname'] ?>
                                        </td>
                                        <td class="center">
                                            <img width="50px" src="<?php echo $item['headimgurl'] ?>" />
                                        </td>
                                        <td class="center">
                                            <?php echo $item['subscribe_time']>0?date("Y-m-d H:i:s",$item['subscribe_time']):''; ?>
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
                            "canshu"=>'&mod='.$_GET['mod'].'&v_mod='.$_GET['v_mod'].'&_index=_list_wx'.$data['canshu']));
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