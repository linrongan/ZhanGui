<?php if (isset($_return) && !empty($_return)){?>
    <div id="close_action_tip" class="modal-backdrop fade in"></div>
    <div id="myModal" class="modal fade in" style="display: block;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button id="close_action_tip1" class="close" type="button">×</button>
                    <h4 id="myModalLabel" class="modal-title">操作提示</h4>
                </div>
                <div class="modal-body">
                    <?php echo $_return['msg']; ?>
                </div>
                <div class="modal-footer">
                    <?php if (!isset($_return['url'])){?>
                        <button id="close_action_tip2" class="btn btn-primary" type="button">关闭</button>
                    <?php }else
                    {
                        ?>
                        <a target="_parent" href="<?php echo $_return['url']; ?>">
                            <button class="btn btn-primary" type="button">关闭</button>
                        </a>
                    <?php
                    }
                    ?>
                </div>
            </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div>
    <script src="/template/html/admin/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(function(){
            $("#close_action_tip1,#close_action_tip2").click(function(){

                $("#close_action_tip,#myModal").remove();
            })
        })
    </script>
<?php } ?>
