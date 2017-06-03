<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title><?php echo WEBNAME; ?></title>
    <link href="/template/html/admin/css/style.default.css" rel="stylesheet">
    <link href="/template/html/admin/css/jquery.datatables.css" rel="stylesheet">
    <script src="/template/source/js/jquery.js"></script>
    <script src="/template/html/admin/js/html5shiv.js"></script>
    <script src="/template/html/admin/js/respond.min.js"></script>
</head>
<body>
<form method="post" action="?mod=admin&_index=_operator_detail&id=7&_action=ActionEditAdminInfo">
    <section>
        <div class="panel panel-default">
            <?php
            $data=$obj->GetAdminInfo();
            if (!empty($data))
            {
                ?>
                <div class="panel-body">
                    <div class="panel-heading">
                        <h4 class="panel-title">运营商信息</h4>
                        <p></p>
                    </div>
                    <div style="width: 100%;height: 10px"></div>
                    <div class="form-group"></div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">运营商名称</label>
                        <div class="col-sm-6">
                            <input name="company_name" id="company_name" value="<?php echo $data['admin_name']; ?>" type="text" class="form-control" placeholder="请输入公司名称">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="readonlyinput" class="col-sm-3 control-label">注册配额/已使用</label>
                        <div class="col-sm-6" style="color: red">
                            <?php echo $data['allow_reg_count']; ?>/<?php echo $data['already_reg_count']; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="readonlyinput" class="col-sm-3 control-label">充值配额/已使用</label>
                        <div class="col-sm-6" style="color: red">
                            <?php echo $data['allow_charge_money']; ?>/<?php echo $data['already_charge_money']; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="readonlyinput" class="col-sm-3 control-label">电话</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $data['phone']; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="readonlyinput" class="col-sm-3 control-label">地址</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="address" name="address" value="<?php echo $data['address']; ?>">
                        </div>
                    </div>


                </div><!-- panel-body -->
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3">
                            <button class="btn btn-default" type="button" onclick="window.location.href='/?mod=admin&_index=_operator_auth&admin_id=<?php echo $_GET['admin_id']; ?>'">权限设置</button>
                            &nbsp; &nbsp; &nbsp;
                            <button class="btn btn-primary" type="submit">提交保存</button>
                        </div>
                    </div>
                </div>
            <?php }else{?>
                <div class="panel-heading">
                    <h4 class="panel-title">提示</h4>
                    <p>无记录信息</p>
                </div>
            <?php } ?>
            <!-- panel-footer -->
        </div>
    </section></form>
<?php include "footer_tpl.php"; ?>
</body>
</html>