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
<form method="post" action="?mod=admin&_index=_operator_edit&_action=ActionEditAdmin&admin_id=<?php echo $_GET['admin_id']; ?>" id="checkform">
    <section>
        <div class="panel panel-default">
            <?php
            $data=$obj->GetAdminInfo();
            if (!empty($data))
            {
                ?>
                <div class="panel-body">
                    <div class="panel-heading">
                        <h4 class="panel-title">操作员信息</h4>
                        <p></p>
                    </div>
                    <div style="width: 100%;height: 10px"></div>




                    <div class="form-group">
                        <label for="disabledinput" class="col-sm-3 control-label">管理员姓名</label>
                        <div class="col-sm-6">
                            <input type="text" value="<?php echo $data['admin_name']; ?>" name="adminName" id="adminName" class="form-control" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="disabledinput" class="col-sm-3 control-label">管理员账号</label>
                        <div class="col-sm-6">
                            <input type="text" value="<?php echo $data['admin_account']; ?>" name="adminAccount" id="adminAccount" class="form-control"  >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="readonlyinput" class="col-sm-3 control-label">管理员状态</label>
                        <div class="col-sm-6" style="color: red">
                            <select class="form-control mb13" required name="admin_status" id="admin_status">
                                <option>请选择管理员状态</option>
                                <option value="0" <?php echo $data['admin_status']==0?'selected':''; ?>>正常</option>
                                <option value="1" <?php echo $data['admin_status']==1?'selected':''; ?>>锁定</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="disabledinput" class="col-sm-3 control-label">请输入原密码</label>
                        <div class="col-sm-6">
                            <input type="password" name="opwd" id="opwd" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="disabledinput" class="col-sm-3 control-label">请输入新密码</label>
                        <div class="col-sm-6">
                            <input type="password" name="npwd" id="npwd" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="disabledinput" class="col-sm-3 control-label">请确认新密码</label>
                        <div class="col-sm-6">
                            <input type="password" name="re_npwd" id="re_npwd" class="form-control">
                        </div>
                    </div>




                </div><!-- panel-body -->
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3">
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
    </section>
</form>
<script src="/template/source/js/jquery.js"></script>
<script src="/tool/CheckForm/dist/jquery.validate.js"></script>
<script src="/template/source/js/comm.js"></script>
<?php include "footer_tpl.php"; ?>
<script>
    $( "#checkform" ).validate( {
        rules: {
            opwd: {
                required: false,
                remote:"/?mod=admin&_action=CheckPwd"
            },
            npwd: {
                required: false,
                minlength: 5
            },
            re_npwd:{
                equalTo: "#npwd"
            }

        },
        messages: {

            opwd: {
                required: "请输入当前密码",
                remote:"密码输入错误"
            },
            npwd: {
                required: "请输入新密码",
                minlength: "至少5位"
            },
            re_npwd:{
                equalTo:"2次密码输入有误"
            }
        }
    });
</script>
</body>
</html>