<?php
/**
 *      (C)2014-2099 Guangzhou RuoYuWangLuo KeJi Inc.
 * 		若宇网 ruoyw.com
 *		这不是一个开源和免费软件,使用前请获得作者授权
 *      inc_system.php
 */
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}

function get_tree_child($data, $fid) {
    $result = array();
    $fids = array($fid);
    do {
        $cadmin_ids = array();
        $flag = false;
        foreach($fids as $fid) {
            for($i = count($data) - 1; $i >=0 ; $i--) {
                $node = $data[$i];
                if($node['fid'] == $fid) {
                    array_splice($data, $i , 1);
                    $result[] = $node['admin_id'];
                    $cadmin_ids[] = $node['admin_id'];
                    $flag = true;
                }
            }
        }
        $fids = $cadmin_ids;
    } while($flag === true);
    return $result;
}

function get_tree_parent($data, $admin_id) {
    $result = array();
    $obj = array();
    foreach($data as $node) {
        $obj[$node['admin_id']] = $node;
    }

    $value = isset($obj[$admin_id]) ? $obj[$admin_id] : null;
    while($value) {
        $admin_id = null;
        foreach($data as $node) {
            if($node['admin_id'] == $value['fid']) {
                $admin_id = $node['admin_id'];
                $result[] = $node['admin_id'];
                break;
            }
        }
        if($admin_id === null) {
            $result[] = $value['fid'];
        }
        $value = isset($obj[$admin_id]) ? $obj[$admin_id] : null;
    }
    unset($obj);
    return $result;
}

function get_tree_ul($data, $fid) {
    $stack = array($fid);
    $child = array();
    $added_left = array();
    $added_right= array();
    $html_left     = array();
    $html_right    = array();
    $obj = array();
    $loop = 0;
    foreach($data as $node) {
        $padmin_id = $node['fid'];
        if(!isset($child[$padmin_id])) {
            $child[$padmin_id] = array();
        }
        array_push($child[$padmin_id], $node['admin_id']);
        $obj[$node['admin_id']] = $node;
    }

    while (count($stack) > 0) {
        $admin_id = $stack[0];
        $flag = false;
        $node = isset($obj[$admin_id]) ? $obj[$admin_id] : null;
        if (isset($child[$admin_id])) {
            $cadmin_ids = $child[$admin_id];
            $length = count($cadmin_ids);
            for($i = $length - 1; $i >= 0; $i--) {
                array_unshift($stack, $cadmin_ids[$i]);
            }
            $obj[$cadmin_ids[$length - 1]]['isLastChild'] = true;
            $obj[$cadmin_ids[0]]['isFirstChild'] = true;
            $flag = true;
        }
        if ($admin_id != $fid && $node && !isset($added_left[$admin_id])) {
            if(isset($node['isFirstChild']) && isset($node['isLastChild']))  {
                $html_left[] = '<li id="end">';
            } else if(isset($node['isFirstChild'])) {
                $html_left[] = '<li>';
            } else if(isset($node['isLastChild'])) {
                $html_left[] = '<li id="end">';
            } else {
                $html_left[] = '<li>';
            }
            if ($node['admin_type']==1)
            {
                $html_left[] = ($flag === true) ? "<em class='on'></em>{$node['admin_name']}<ul>" : "<em class='on'></em>{$node['admin_name']}";
            }else
            {
                $html_left[] = ($flag === true) ? "<em class='off1'></em>{$node['admin_name']} <ul>" : "<em class='off1'></em><a class='f_strong' href='?mod=admin&_index=_operator_detail&admin_id={$node['admin_id']}#p1'>{$node['admin_name']} <span class='glyphicon glyphicon-pencil'></span></a> ";
            }
            //$html_left[] = ($flag === true) ? "<em class='off'></em>{$node['admin_name']}<a class='queren' href='?action=new&admin_id={$node['admin_id']}'>[新增操作员]</a><ul class='off'>" : "<em class='off'></em><a href='?action=edit&admin_id={$node['admin_id']}'>{$node['admin_name']}</a>";
            $added_left[$admin_id] = true;
        }
        if ($admin_id != $fid && $node && !isset($added_right[$admin_id])) {
            $html_right[] = ($flag === true) ? '</ul></li>' : '</li>';
            $added_right[$admin_id] = true;
        }

        if ($flag == false) {
            if($node) {
                $cadmin_ids = $child[$node['fid']];
                for ($i = count($cadmin_ids) - 1; $i >= 0; $i--) {
                    if ($cadmin_ids[$i] == $admin_id) {
                        array_splice($child[$node['fid']], $i, 1);
                        break;
                    }
                }
                if(count($child[$node['fid']]) == 0) {
                    $child[$node['fid']] = null;
                }
            }
            array_push($html_left, array_pop($html_right));
            array_shift($stack);
        }
        $loop++;
        if($loop > 5000) return $html_left;
    }
    unset($child);
    unset($obj);
    return implode('', $html_left);
}

function get_tree_ul2($data, $fid) {
    $stack = array($fid);
    $child = array();
    $added_left = array();
    $added_right= array();
    $html_left     = array();
    $html_right    = array();
    $obj = array();
    $loop = 0;
    foreach($data as $node) {
        $padmin_id = $node['fid'];
        if(!isset($child[$padmin_id])) {
            $child[$padmin_id] = array();
        }
        array_push($child[$padmin_id], $node['admin_id']);
        $obj[$node['admin_id']] = $node;
    }

    while (count($stack) > 0) {
        $admin_id = $stack[0];
        $flag = false;
        $node = isset($obj[$admin_id]) ? $obj[$admin_id] : null;
        if (isset($child[$admin_id])) {
            $cadmin_ids = $child[$admin_id];
            $length = count($cadmin_ids);
            for($i = $length - 1; $i >= 0; $i--) {
                array_unshift($stack, $cadmin_ids[$i]);
            }
            $obj[$cadmin_ids[$length - 1]]['isLastChild'] = true;
            $obj[$cadmin_ids[0]]['isFirstChild'] = true;
            $flag = true;
        }

        if ($admin_id != $fid && $node && !isset($added_left[$admin_id])) {
            if(isset($node['isFirstChild']) && isset($node['isLastChild']))  {
                $html_left[] = '<li id="end">';
            } else if(isset($node['isFirstChild'])) {
                $html_left[] = '<li>';
            } else if(isset($node['isLastChild'])) {
                $html_left[] = '<li id="end">';
            } else {
                $html_left[] = '<li>';
            }
            $html_left[] = ($flag === true) ? "<em class='off1'></em>{$node['admin_name']} <ul>" : "<em class='off1'></em><a class='f_strong' href='?mod=admin&_index=_operator_details&admin_id={$node['admin_id']}#p1'>{$node['admin_name']} <span class='glyphicon glyphicon-pencil'></span></a> ";
            $added_left[$admin_id] = true;
        }
        if ($admin_id != $fid && $node && !isset($added_right[$admin_id])) {
            $html_right[] = ($flag === true) ? '</ul></li>' : '</li>';
            $added_right[$admin_id] = true;
        }

        if ($flag == false) {
            if($node) {
                $cadmin_ids = $child[$node['fid']];
                for ($i = count($cadmin_ids) - 1; $i >= 0; $i--) {
                    if ($cadmin_ids[$i] == $admin_id) {
                        array_splice($child[$node['fid']], $i, 1);
                        break;
                    }
                }
                if(count($child[$node['fid']]) == 0) {
                    $child[$node['fid']] = null;
                }
            }
            array_push($html_left, array_pop($html_right));
            array_shift($stack);
        }
        $loop++;
        if($loop > 5000) return $html_left;
    }
    unset($child);
    unset($obj);
    return implode('', $html_left);
}


function get_tree_option($data, $fid) {
    $stack = array($fid);
    $child = array();
    $added = array();
    $options = array();
    $obj = array();
    $loop = 0;
    $depth = -1;
    foreach($data as $node) {
        $padmin_id = $node['fid'];
        if(!isset($child[$padmin_id])) {
            $child[$padmin_id] = array();
        }
        array_push($child[$padmin_id], $node['admin_id']);
        $obj[$node['admin_id']] = $node;
    }

    while (count($stack) > 0) {
        $admin_id = $stack[0];
        $flag = false;
        $node = isset($obj[$admin_id]) ? $obj[$admin_id] : null;
        if (isset($child[$admin_id])) {
            for($i = count($child[$admin_id]) - 1; $i >= 0; $i--) {
                array_unshift($stack, $child[$admin_id][$i]);
            }
            $flag = true;
        }
        if ($admin_id != $fid && $node && !isset($added[$admin_id])) {
            $node['depth'] = $depth;
            $options[] = $node;
            $added[$admin_id] = true;
        }
        if($flag == true){
            $depth++;
        } else {
            if($node) {
                for ($i = count($child[$node['fid']]) - 1; $i >= 0; $i--) {
                    if ($child[$node['fid']][$i] == $admin_id) {
                        array_splice($child[$node['fid']], $i, 1);
                        break;
                    }
                }
                if(count($child[$node['fid']]) == 0) {
                    $child[$node['fid']] = null;
                    $depth--;
                }
            }
            array_shift($stack);
        }
        $loop++;
        if($loop > 5000) return $options;
    }
    unset($child);
    unset($obj);
    return $options;
}

//切换专用
function get_tree_change1($data, $fid) {
    $stack = array($fid);
    $child = array();
    $added_left = array();
    $added_right= array();
    $html_left     = array();
    $html_right    = array();
    $obj = array();
    $loop = 0;
    foreach($data as $node) {
        $padmin_id = $node['fid'];
        if(!isset($child[$padmin_id])) {
            $child[$padmin_id] = array();
        }
        array_push($child[$padmin_id], $node['admin_id']);
        $obj[$node['admin_id']] = $node;
    }

    while (count($stack) > 0) {
        $admin_id = $stack[0];
        $flag = false;
        $node = isset($obj[$admin_id]) ? $obj[$admin_id] : null;
        if (isset($child[$admin_id])) {
            $cadmin_ids = $child[$admin_id];
            $length = count($cadmin_ids);
            for($i = $length - 1; $i >= 0; $i--) {
                array_unshift($stack, $cadmin_ids[$i]);
            }
            $obj[$cadmin_ids[$length - 1]]['isLastChild'] = true;
            $obj[$cadmin_ids[0]]['isFirstChild'] = true;
            $flag = true;
        }
        if ($admin_id != $fid && $node && !isset($added_left[$admin_id])) {
            if(isset($node['isFirstChild']) && isset($node['isLastChild']))  {
                $html_left[] = '';
            } else if(isset($node['isFirstChild'])) {
                $html_left[] = '';
            } else if(isset($node['isLastChild'])) {
                $html_left[] = '';
            } else {
                $html_left[] = '';
            }
            if ($node['admin_type']==1)
            {
                $html_left[] = ($flag === true) ? "<option value='{$node['usercode']}'>{$node['admin_name']}({$node['usercode']})</option>" : "<option value='{$node['usercode']}'>&nbsp;&nbsp;{$node['admin_name']}({$node['usercode']})</option>";

            }else
            {
                //$html_left[] = ($flag === true) ? "<optgroup label='{$node['admin_name']}'>" : "<optgroup //label='{$node['admin_name']}'>";
            }


            $added_left[$admin_id] = true;
        }
        if ($admin_id != $fid && $node && !isset($added_right[$admin_id])) {
            //$html_right[] = ($flag === true) ? '</optgroup></option>' : '</option>';
            $added_right[$admin_id] = true;
        }

        if ($flag == false) {
            if($node) {
                $cadmin_ids = $child[$node['fid']];
                for ($i = count($cadmin_ids) - 1; $i >= 0; $i--) {
                    if ($cadmin_ids[$i] == $admin_id) {
                        array_splice($child[$node['fid']], $i, 1);
                        break;
                    }
                }
                if(count($child[$node['fid']]) == 0) {
                    $child[$node['fid']] = null;
                }
            }
            array_push($html_left, array_pop($html_right));
            array_shift($stack);
        }
        $loop++;
        if($loop > 5000) return $html_left;
    }
    unset($child);
    unset($obj);
    return implode('', $html_left);
}


function get_tree_change2($data, $fid) {
    $stack = array($fid);
    $child = array();
    $added_left = array();
    $added_right= array();
    $html_left     = array();
    $html_right    = array();
    $obj = array();
    $loop = 0;
    foreach($data as $node) {
        $padmin_id = $node['fid'];
        if(!isset($child[$padmin_id])) {
            $child[$padmin_id] = array();
        }
        array_push($child[$padmin_id], $node['admin_id']);
        $obj[$node['admin_id']] = $node;
    }

    while (count($stack) > 0) {
        $admin_id = $stack[0];
        $flag = false;
        $node = isset($obj[$admin_id]) ? $obj[$admin_id] : null;
        if (isset($child[$admin_id])) {
            $cadmin_ids = $child[$admin_id];
            $length = count($cadmin_ids);
            for($i = $length - 1; $i >= 0; $i--) {
                array_unshift($stack, $cadmin_ids[$i]);
            }
            $obj[$cadmin_ids[$length - 1]]['isLastChild'] = true;
            $obj[$cadmin_ids[0]]['isFirstChild'] = true;
            $flag = true;
        }
        if ($admin_id != $fid && $node && !isset($added_left[$admin_id])) {
            if(isset($node['isFirstChild']) && isset($node['isLastChild']))  {
                $html_left[] = '';
            } else if(isset($node['isFirstChild'])) {
                $html_left[] = '';
            } else if(isset($node['isLastChild'])) {
                $html_left[] = '';
            } else {
                $html_left[] = '';
            }
            if ($node['admin_type']==1)
            {
                $html_left[] = ($flag === true) ? "<option value='{$node['fid']}'>{$node['admin_name']}({$node['usercode']})</option>" : "<option value='{$node['usercode']}'>&nbsp;&nbsp;{$node['admin_name']}({$node['usercode']})</option>";

            }else
            {
                //$html_left[] = ($flag === true) ? "<optgroup label='{$node['admin_name']}'>" : "<optgroup //label='{$node['admin_name']}'>";
            }


            $added_left[$admin_id] = true;
        }
        if ($admin_id != $fid && $node && !isset($added_right[$admin_id])) {
            //$html_right[] = ($flag === true) ? '</optgroup></option>' : '</option>';
            $added_right[$admin_id] = true;
        }

        if ($flag == false) {
            if($node) {
                $cadmin_ids = $child[$node['fid']];
                for ($i = count($cadmin_ids) - 1; $i >= 0; $i--) {
                    if ($cadmin_ids[$i] == $admin_id) {
                        array_splice($child[$node['fid']], $i, 1);
                        break;
                    }
                }
                if(count($child[$node['fid']]) == 0) {
                    $child[$node['fid']] = null;
                }
            }
            array_push($html_left, array_pop($html_right));
            array_shift($stack);
        }
        $loop++;
        if($loop > 5000) return $html_left;
    }
    unset($child);
    unset($obj);
    return implode('', $html_left);
}



?>