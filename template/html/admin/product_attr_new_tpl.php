<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
if(!isset($_GET['product']))
{
    redirect(ADMIN_ERROR);

}
$select_attr_array = array();
$select_attr = $obj->GetProductAttrList($_GET['product']);
if($select_attr)
{
    foreach($select_attr as $arr)
    {
        $select_attr_array[] = $arr['attr_temp_id'];
    }
}
$_product = $obj->GetThisProduct($_GET['product']);
//echo '<pre>';
//var_dump($_product);exit;
$attr = $obj->GetProductAttrValue();
$attr_array  = array();
if($attr)
{
    foreach($attr as $value)
    {
        $attr_array[$value['attr_type_id']]['attr_id'] = $value['attr_id'];
        $attr_array[$value['attr_type_id']]['attr_type_name'] = $value['attr_type_name'];
        $attr_array[$value['attr_type_id']]['val'][$value['attr_id']] = $value['attr_name'];
    }
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
       <!-- <div class="pageheader">
             <h2> 产品中心 <span>产品属性</span>  <span>新增</span></h2>
             <div class="breadcrumb-wrapper">
                 <span class="label">当前导航:</span>
                 <ol class="breadcrumb">
                     <li><a href="">导航</a></li>
                     <li class="active">产品中心</li>
                 </ol>
             </div>
         </div>-->
        <div class="contentpanel">
            <div class="panel panel-default">
                <div class="panel-body">
                    <!-- BASIC WIZARD -->
                    <div class="basic-wizard" id="basicWizard">
                        <div class="tab-content">
                            <div class="tab-pane active">
                                <div class="panel panel-default">
                                    <form id="checkform" method="post"
                                          action="/?mod=admin&v_mod=product&_index=_attr_new&_action=ActionNewProductAttr&product=<?php echo $_GET['product']; ?>" class="form-horizontal form-bordered">
                                        <div class="panel-body panel-body-nopadding">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">属性</label>
                                                <div class="col-sm-3">
                                                    <select class="form-control mb13" name="attr_temp_id" required aria-required="true">
                                                        <option value="">请选择属性</option>
                                                        <?php
                                                            if($attr_array)
                                                            {
                                                                foreach($attr_array as $item)
                                                                {
                                                                    ?>
                                                                    <optgroup label="<?php echo $item['attr_type_name']; ?>">
                                                                        <?php
                                                                            if($item['val'] && count($item['val'])>0)
                                                                            {
                                                                                foreach($item['val'] as $k=> $v)
                                                                                {
                                                                                    ?>
                                                                                    <option <?php if(in_array($k,$select_attr_array)){echo 'disabled';} ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
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

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">价钱</label>
                                                <div class="col-sm-3">
                                                    <span style="padding: 10px;"><?php echo $_product['product_price']?>+</span><input maxlength="11" required name="attr_price" number="true" placeholder="0.00"  type="text" class="form-control" value="" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">排序</label>
                                                <div class="col-sm-3">
                                                    <input name="product_attr_sort" digits="true" required maxlength="11" type="number" class="form-control" value="0" aria-required="true">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- panel-body -->
                                        <div class="panel-footer">
                                            <div class="row">
                                                <div class="col-sm-6 col-sm-offset-3">
                                                    <input type="submit" name="submit" value="确定" class="btn btn-primary">
                                                    <a href="/?mod=admin&v_mod=product&_index=_attr_list&id=<?php echo $_GET['product']; ?>" class="btn btn-default"  type="button">
                                                        返回
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
<script src="/template/source/js/comm.js"></script>
<?php include "footer_tpl.php"; ?>
</body>
<script>
    $(function(){
        $("#checkform").validate();
    });

</script>
</html>