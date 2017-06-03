<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
include RPC_DIR .'/inc/category_three.php';
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
<form id="checkform" method="post" action="?mod=admin&_index=_operator_new">
    <section>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="panel-heading">
                    <h4 class="panel-title">新增操作员</h4>
                    <p></p>
                </div>
                <div style="width: 100%;height: 10px"></div>
                <div class="form-group">
                    <label for="readonlyinput" class="col-sm-3 control-label">选择运营商</label>
                    <div class="col-sm-3">
                        <select class="form-control" name="usercode" id="usercode">
                            <option value="">请选择所属运营商</option>
                            <?php echo get_tree_change1($obj->AdminList(),$_SESSION['fid']); ?>
                        </select>
                    </div>
                </div>

                <div class="form-group"></div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">公司名称</label>
                    <div class="col-sm-6">
                        <input name="company_name" id="company_name" value="" type="text" class="form-control" placeholder="请输入公司名称">
                    </div>
                </div>

                <div class="form-group">
                    <label for="disabledinput" class="col-sm-3 control-label">操作员姓名</label>
                    <div class="col-sm-6">
                        <input type="text" value="" name="admin_name" id="admin_name" class="form-control"  placeholder="请输入操作员姓名">
                    </div>
                </div>

                <div class="form-group">
                    <label for="readonlyinput" class="col-sm-3 control-label">注册配额（人）</label>
                    <div class="col-sm-3" style="color: red">
                        <input type="number" value="1000" name="allow_reg_count" id="allow_reg_count" class="form-control"  placeholder="请输入注册配额">
                    </div>
                </div>

                <div class="form-group">
                    <label for="readonlyinput" class="col-sm-3 control-label">充值配额（元）</label>
                    <div class="col-sm-3" style="color: red">
                        <input type="number" value="10000" name="allow_charge_money" id="allow_charge_money" class="form-control"  placeholder="请输入充值配额">
                    </div>
                </div>

                <div class="form-group">
                    <label for="readonlyinput" class="col-sm-3 control-label">电话</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="phone" name="phone" value="">
                    </div>
                </div>

                <div class="form-group">
                    <label for="readonlyinput" class="col-sm-3 control-label">地址</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="address" name="address" value="">
                    </div>
                </div>

                <div class="form-group">
                    <label for="readonlyinput" class="col-sm-3 control-label">登录账号</label>
                    <div class="col-sm-6" style="color: red">
                        <input type="text" class="form-control" id="admin_account" name="admin_account" value="">
                    </div>
                </div>

                <div class="form-group">
                    <label for="readonlyinput" class="col-sm-3 control-label">登录密码</label>
                    <div class="col-sm-6" style="color: red">
                        <input type="text" class="form-control" id="admin_pwd" name="admin_pwd" value="">
                    </div>
                </div>

            </div><!-- panel-body -->
            <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                        <button class="btn btn-default" type="reset">重置</button>
                        <button class="btn btn-primary" type="submit">确定新增</button>
                    </div>
                </div>
            </div>
            <!-- panel-footer -->
        </div>
    </section>
</form>
<script src="/tool/CheckForm/dist/jquery.validate.js"></script>
<script type="text/javascript">
    $(function(){
        $("#checkform").validate({
            rules: {
                usercode: {
                    required: true
                },
                admin_name: {
                    required: true,
                    minlength: 2,
                    maxlength: 15
                },
                allow_reg_count: {
                    number: true,
                    min: 0,
                    max: 10000
                },
                admin_account: {
                    required: true,
                    minlength: 5,
                    maxlength: 18
                },
                admin_pwd: {
                    required: true,
                    minlength: 5,
                    maxlength: 18
                }
            },
            messages: {
                usercode: {
                    required: "运营商不能为空"
                },
                admin_name: {
                    required: "操作员姓名不能为空",
                    minlength: "至少两个字符"
                },

                allow_reg_count: {
                    number: "注册配额必须是数字",
                    min: "最小数字为0",
                    max: "最大数字为10000"
                },

                admin_account: {
                    required: "操作员登录账号不能为空",
                    minlength: "长度5-18位"
                },
                admin_pwd: {
                    required: "操作员密码不能为空",
                    minlength: "长度5-18位"
                }
            }
        })
    })
</script>
<?php include "footer_tpl.php"; ?>
</body>
</html>