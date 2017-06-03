<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/21
 * Time: 10:23
 */
$data = $obj->GetProductDetail();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
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
<div class="contentpanel">
<?php
    if($data['group_product']==1)
    {
    ?>
            <div class="panel panel-default">
                <div class="panel-body editable-list-group">
                    <div class="row editable-list-item">
                        <div class="col-sm-3">团购开始时间：</div>
                        <div class="col-sm-9"><?php echo $data['group_start']; ?></div>
                    </div><!-- row -->

                    <div class="row editable-list-item">
                        <div class="col-sm-3">团购结束时间：</div>
                        <div class="col-sm-9"><?php echo $data['group_over']; ?></div>
                    </div><!-- row -->

                    <div class="row editable-list-item">
                        <div class="col-sm-3">团购价：</div>
                        <div class="col-sm-9"><?php echo $data['group_price']; ?></div>
                    </div><!-- row -->

                    <div class="row editable-list-item">
                        <div class="col-sm-3">单次团购有效时间：</div>
                        <div class="col-sm-9"><?php echo $obj->time2second($data['group_time']); ?></div>
                    </div><!-- row -->

                </div><!-- panel-body -->
            </div><!-- panel -->
        <?php
    }
?>
    <div class="panel panel-default">
        <div class="panel panel-default">
            <form enctype="multipart/form-data" id="checkform" method="post"
                  action="/?mod=admin&v_mod=product&_index=_group&id=<?php echo $_GET['id']; ?>&_action=ActionProductGroup" class="form-horizontal form-bordered">
                <div class="form-group">
                    <label class="col-sm-3 control-label">状态</label>
                    <span class="asterisk">*</span>
                    <div class="col-sm-6">
                        <select class="form-control mb13" required name="group_product">
                            <option value="">请选择分类</option>
                            <option value="0" <?php echo $data['group_product']==0?'selected':''; ?>>普通</option>
                            <option value="1" <?php echo $data['group_product']==1?'selected':''; ?>>团购</option>
                        </select>
                    </div>
                </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">团购价</label>
                        <div class="col-sm-3">
                            <input  name="group_price" maxlength="11" required id="group_price" type="number" class="form-control" value="<?php echo $data['group_price']; ?>"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">团购开始时间：</label>
                        <div class="col-sm-3">
                            <input name="group_start" required id="group_start" type="text" value="<?php echo $data['group_start']; ?>" class="form-control">
                        </div>
                    </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">团购结束时间：</label>
                    <div class="col-sm-3">
                        <input name="group_over" required id="group_over" type="text" value="<?php echo $data['group_over']; ?>" class="form-control">
                    </div>
                </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">单次有效期(秒)</label>
                        <div class="col-sm-3">
                            <input name="group_time" id="group_time" maxlength="11" required type="number" class="form-control" value="<?php echo $data['group_time']; ?>" />
                        </div>
                    </div>
                <div class="form-group">
                    <label class="col-sm-1 control-label">转换器(x天x时x分->秒)：<span id="show" style="color: #0D8BBD"></span></label>
                    <div class="col-sm-2">
                        天：<input  id="day"   type="number" class="form-control"/>
                        时：<input  id="hour"  type="number" class="form-control"/>
                        分：<input  id="min"  type="number" class="form-control"/>
                        <a href="javascript:;" class="btn btn-primary" onclick="sums()">计算</a>
                    </div>
                </div>
                <!-- panel-body -->
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3">
                            <button  class="btn btn-primary" type="submit">确定</button>
                        </div>
                    </div>
                </div>
            </form>
            <!-- panel-footer -->
        </div>
    </div>
    </div>
</div>
</body>
<script src="/template/source/js/jquery.js"></script>
<script src="/tool/CheckForm/dist/jquery.validate.js"></script>
<script src="/tool/CheckForm/dist/localization/messages_zh.js"></script>
<script type="text/javascript" src="/tool/layer/layer/layer.js"></script>
<script type="text/javascript" src="/tool/time/jedate/jedate.min.js"></script>
<script>
    $(function(){
        $("#checkform").validate();
        var myDate = new Date();
        var date = myDate.getFullYear();
        jeDate({
            dateCell:"#group_start",
            isinitVal:false,
            isTime:true, //isClear:false,
            minDate:"1999-01-01 00:00:00"
        });
        jeDate({
            dateCell:"#group_over",
            isinitVal:false,
            isTime:true, //isClear:false,
            minDate:"1999-01-01 00:00:00"
        });

    });

    function sums(){
        var tian = $("#day").val();
        var shi = $("#hour").val();
        var fen = $("#min").val();
        if(tian=='' || tian<=0){
            tian = 0;
        }
        if(shi=='' || shi<=0){
            shi = 0;
        }
        if(fen=='' || fen<=0){
            fen = 0;
        }
        var s = 3600*24*parseInt(tian)+parseInt(shi)*3600+parseInt(fen)*60;
        $("#show").html(s);
    }
</script>
</html>
