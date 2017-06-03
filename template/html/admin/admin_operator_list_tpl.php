<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
$admin=$obj->AdminList();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title><?php echo WEBNAME; ?></title>
    <link href="/template/html/admin/css/style.default.css" rel="stylesheet">
    <link href="/template/html/admin/css/jquery.datatables.css" rel="stylesheet">
    <script src="/template/html/admin/js/html5shiv.js"></script>
    <script src="/template/html/admin/js/respond.min.js"></script>
    <script type="text/javascript">
        $(function()
        {
            $("#menu em").click(function()
            {
                if ($(this).hasClass("on")==true)
                {
                    $(this).removeClass('on').addClass('off');
                    $(this).parent().children().show();
                }else
                {
                    $(this).removeClass('off').addClass('on');
                    $(this).parent().find('ul').hide();
                    $(this).parent().find('em').removeClass('off').addClass('on');
                }
            })
        })

        function close_all(id)
        {
            if (id==1)
            {
                $("#menu ul").find('em').removeClass("off").addClass("on");
                $("#menu ul").find('ul').hide();
            }else if(id==2)
            {
                $("#menu ul").find('em').removeClass("on").addClass("off");
                $("#menu ul").find('ul').show();
            }
        }
    </script>
    <style type="text/css">
        body,ul,h3 {margin:0px; padding:0px;}
        li {list-style-type:none;}
        body{
            font-size:12px;
            color:#333;
            font-family: Simsun;
            line-height:15px;
        }
        a{text-decoration:none;color:#004285;border:none;}
        a:hover{text-decoration:none;color:#C33;}
        #menu {
            padding:10px;
        }
        #menu h3 {
            font-size:12px;
        }
        #menu ul {
            background:url("/upload/admin/ul-bg.gif") repeat-y 5px 0px; overflow:hidden;
        }
        #menu ul li {
            padding:5px 0 2px 30px;
            background:url("/upload/admin/tree-ul-li.gif") no-repeat 5px -32px;
        }
        #menu ul li ul{display: none;}
        #menu ul li em {
            cursor:pointer;
            display:inline-block;
            width:15px;
            float:left;
            height:15px;
            margin-left:-14px;
            background:url("/upload/admin/tree-ul-li.gif") no-repeat -32px 2px;
        }
        #menu ul li em.off1 {
            background-position: -17px -15px;
        }
        .f_strong{font-weight: bold;color: red;}

        #menu ul.off1 {
            display:block;
        }
        #menu ul li em.off {
            background-position: -17px -15px;
        }

        #menu ul.off {
            display:block;
        }
    </style>
    <base target="p1">
</head>
<body>
<section>
    <div class="mainpanel">
        <div class="pageheader">
            <h2><i class="fa fa-home"></i> 管理员列表 <span>所有管理员</span></h2>
            <div class="breadcrumb-wrapper">
                <span class="label">当前导航:</span>
                <ol class="breadcrumb">
                    <li><a href="">导航</a></li>
                    <li class="active">管理列表</li>
                </ol>
            </div>
        </div>

        <div class="contentpanel">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title"></h4>
                    <p></p>
                </div>
                <div class="panel-body">
                    <form class="form-inline" method="post" action="">
                        <div class="form-group">
                           <a href="/?mod=admin&_index=_operator_new" target="_blank"><button class="btn btn-default" type="button">
                               新增管理员
                           </button></a>
                        </div>
                    </form>
                </div><!-- panel-body -->
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <h5 class="subtitle mb5">管理员管理</h5>
                    <br/>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>姓名</th>
                            <th>账号</th>
                            <th>登录次数</th>
                            <th>最后登录时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($admin)){
                            foreach($admin as $item){
                                ?>
                                <tr class="odd gradeX">
                                    <td class="center">
                                        <?php echo $item['admin_name'];?>
                                    </td>
                                    <td class="center">

                                        <?php echo $item['admin_account'];?>
                                    </td>

                                    <td class="center">
                                        <?php echo $item['admin_login_count'];?>
                                    </td>
                                    <td class="center">
                                        <?php echo $item['admin_last_login'];?>
                                    </td>
                                    <td class="center">
                                        <a title="编辑操作员信息" href="/?mod=admin&_index=_operator_detail&admin_id=<?php echo $item['admin_id']; ?>">
                                            <span class="fa fa-edit"></span>
                                        </a>
                                        <a title="编辑操作员权限" href="?mod=admin&_index=_operator_auth&admin_id=<?php echo $item['admin_id']; ?>">
                                            <span class="fa fa-key"></span>
                                        </a>
                                    </td>
                                </tr>
                        <?php }
                        } ?>
                        </tbody>
                    </table>
                    <div class="clearfix mb30"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="/template/source/js/jquery.js"></script>
</body>
</html>
