<?php
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
Class page_nav {
        function __construct($data) {
            $this->data=daddslashes($data);
        }
        function page_nav() {
            $total=$this->data['total'];
            $page_size=intval($this->data['page_size']);
            $curpage=intval($this->data['curpage']);
            $extUrl=$this->data['extUrl'];
            $canshu=$this->data['canshu'];
            $total=intval($total);
            $page_size=intval($page_size);
            if ($page_size==0){$page_size=1;}
            if ($curpage==0){$curpage=1;}
            $maxPage=10;
            $minPage=3;
            $from = 1;
            $to = 1;
            if( $total){
                if( $total < $page_size ){ $page_count = 1; }
                if( $total % $page_size ){
                    $page_count = (int)($total / $page_size) + 1;
                }else{$page_count = $total / $page_size;}
            }else{$page_count = 0;}
            if ($curpage>$minPage){$from = $curpage-$minPage;}
            $to=$curpage+$maxPage-$minPage-1;
            if (($to-$from)<($maxPage-1)){$to=$maxPage;}
            if ($page_count<=$maxPage){
                $from = 1;
                $to = $page_count;
            }
            $pageNav='<div class="dataTables_info" >显示:'.$from.'/ '.$to.'页 总数：'.$total.' 条</div><div class="dataTables_paginate paging_full_numbers" id="table2_paginate">';
            if ($to>$page_count){$to = $page_count;$from=$page_count-$maxPage+1;
            }
            if ($curpage>1) {$pageNav.='<a class="paginate_button previous" href="'.$extUrl.'?curpage='.($curpage-1).''.$canshu.'">前一页</a>';}else{
                $pageNav.='<a class="paginate_button previous disabled" href="javascript:;">前一页';
            }
            if ($from>1){$pageNav.='<a href="'.$extUrl.'?curpage=1'.$canshu.'" class="paginate_button"> 1 </a><a class="paginate_button" href="javascript:;"> ... </a>';}
            for ($i=$from;$i<=$to;$i++){
                if ($i==$curpage){
                    $pageNav.='<a class="paginate_button current" href="javascript:;">'.$i.'</a>';
                }else{
                    $pageNav.='<a class="paginate_button" href="'.$extUrl.'?curpage='.$i.''.$canshu.'">'.$i.'</a>';
                }
            }
            if ($to<$page_count){$pageNav.='<a class="paginate_button" href="javascript:;"> ... </a> <a class="paginate_button " href="'.$extUrl.'?curpage='.$page_count.''.$canshu.'">'.$page_count.'</a>';}
            if ($curpage<$page_count) {$pageNav.='<a class="paginate_button  next" href="'.$extUrl.'?curpage='.($curpage+1).''.$canshu.'">下一页</a>';}
            else
            {
                $pageNav.='<a class="paginate_button" href="javascript:;">下一页</a>';
            }
            $pageNav.='</div>';
            return $pageNav;
    }
}

?>