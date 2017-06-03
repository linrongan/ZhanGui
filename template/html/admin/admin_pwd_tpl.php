<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}

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
<section id="top">
    <div class="mainpanel">
        <div class="pageheader">
            <h2><i class="fa fa-home"></i> 管理员 <span>修改密码</span></h2>
            <div class="breadcrumb-wrapper">
                <span class="label">当前导航:</span>
                <ol class="breadcrumb">
                    <li><a href="">导航</a></li>
                    <li class="active">修改密码</li>
                </ol>
            </div>
        </div>
        <div class="contentpanel">
            <div class="panel panel-default">
                <div class="panel-body">
                    <!-- BASIC WIZARD -->
                    <div class="basic-wizard" id="basicWizard">
                        <div class="tab-content">
                            <div class="tab-pane active">
                                <div class="panel panel-default">
                                    <form enctype="multipart/form-data" id="checkform" method="post"
                                          action="/?mod=admin&v_mod=admin&_index=_pwd&_action=EditPwd" class="form-horizontal form-bordered">
                                        <div class="panel-body panel-body-nopadding">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">账号</label>
                                                <div class="col-sm-3">
                                                    <input name="" id="" readonly type="text" class="form-control" value="<?php echo $_SESSION['admin_name']; ?>" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">请输入当前密码</label>
                                                <div class="col-sm-3">
                                                    <input name="opwd" id="opwd" type="password" class="form-control" value="" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">请输入新密码</label>
                                                <div class="col-sm-3">
                                                    <input name="npwd" id="npwd" type="password" class="form-control" value="" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">请确认新密码</label>
                                                <div class="col-sm-3">
                                                    <input name="re_npwd" id="re_npwd" type="password" class="form-control" value="" />
                                                </div>
                                            </div>

                                        </div>
                                        <!-- panel-body -->
                                        <div class="panel-footer">
                                            <div class="row">
                                                <div class="col-sm-6 col-sm-offset-3">
                                                    <button onclick="return save_edit()" class="btn btn-primary" type="submit">
                                                        确定修改
                                                    </button>&nbsp;
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- panel-footer -->
                                </div>
                            </div>
                        </div><!-- tab-content -->
                    </div><!-- #basicWizard -->
                </div><!-- panel-body -->
            </div><!-- panel -->
        </div>
    </div>
</section>
<script src="/template/source/js/jquery.js"></script>
<script src="/tool/CheckForm/dist/jquery.validate.js"></script>
<script src="/template/source/js/comm.js"></script>
<?php include "footer_tpl.php"; ?>
<script>
    $( "#checkform" ).validate( {
        rules: {
            opwd: {
                required: true,
                remote:"/?mod=admin&_action=CheckPwd"
            },
            npwd: {
                required: true,
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