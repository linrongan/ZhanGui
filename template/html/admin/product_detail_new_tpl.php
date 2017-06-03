<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$prodcut = $obj->GetProductDetail();
$attr_list = $obj->GetAllAttrDetail();
$check = $obj->GetProudctAttr($_GET['id']);
$array = array();
foreach($check as $item)
{
    $array[] = $item['attr_id'];
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
    <![endif]-->
</head>
<body>
<section id="top">
    <div class="mainpanel">
        <div class="contentpanel">
            <div class="panel panel-default">
                <div class="panel-body">
                    <!-- BASIC WIZARD -->
                    <div class="basic-wizard" id="basicWizard">
                        <div class="tab-content">
                            <div class="tab-pane active">
                                <div class="panel panel-default">
                                    <form id="checkform" method="post"
                                          action="?mod=admin&v_mod=product&_index=_detail_new&id=<?php echo $_GET['id']; ?>&_action=ActionNewProductAtrr" class="form-horizontal form-bordered">
                                        <div class="panel-body panel-body-nopadding">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">属性</label>
                                                <div class="col-sm-3">
                                                    <select class="form-control mb13" name="attr_id" id="attr_id" required>
                                                        <option value="">请选择属性</option>
                                                        <?php
                                                            if(!empty($attr_list))
                                                            {
                                                                foreach($attr_list as $item)
                                                                {
                                                                    ?>
                                                                        <optgroup label="<?php echo $item['attr_type_name']; ?>">
                                                                            <?php
                                                                                if(!empty($item['attr_name']))
                                                                                {
                                                                                    foreach($item['attr_name'] as $k=>$v)
                                                                                    {
                                                                                        ?>
                                                                                        <option <?php if(in_array($k,$array)){echo 'disabled';}?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                                                                        <?php
                                                                                    }
                                                                                }
                                                                            ?>
                                                                        </optgroup>
                                                                    <?php
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- panel-body -->
                                        <div class="panel-footer">
                                            <div class="row">
                                                <div class="col-sm-6 col-sm-offset-3">
                                                    <button  class="btn btn-primary" type="submit">
                                                        确定
                                                    </button>&nbsp;
                                                    <a href="/?mod=admin&v_mod=product&_index=_detail&id=<?php echo $_GET['id']; ?>" class="btn btn-default"  type="button">
                                                        返回上一页
                                                    </a>
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
<script src="/tool/CheckForm/dist/localization/messages_zh.js"></script>
<?php include "footer_tpl.php"; ?>
</body>
<script>
    $(function(){
        $("#checkform").validate();
    });
</script>
</html>