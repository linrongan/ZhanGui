<?php
/**
 * PHP正则验证类
 */
class regExp
{
    //去除字符串空格
    static function strTrim($str)
    {
        return preg_replace("/\s/","",$str);
    }

    //验证非空
    static function checkNULL($str)
    {
        if(!isset($str) || self::strTrim($str)=='')
        {
            return false;
        }else{
            return true;
        }
    }
    /**
     * 通用验证
     * @param $str string 字符串
     * @param $type string 字符串类型：纯英文、英文数字、允许的符号(|-_字母数字)
     * @param $len string 字符串长度
     * @return bool true/false
     */
    static function Checkstr($str, $type, $len)
    {
        $str=self::strTrim($str);
        if($len < strlen($str))
        {
            return false;
        }
        else
        {
            switch($type)
            {
                case "EN"://纯英文
                    return preg_match("/^[a-zA-Z]+$/",$str) ? true : false;
                    break;
                case "ENNUM"://英文数字
                    return preg_match("/^[a-zA-Z0-9]+$/",$str) ? true : false;
                    break;
                case "ALL": //允许的符号(|-_字母数字)
                    return preg_match("/^[\|\-\_a-zA-Z0-9]+$/",$str) ? true : false;
                    break;
                default:
                    break;
            }
        }
    }

    /**
     * 验证密码长度
     * @param $str string 密码字符串
     * @param $min num 最小长度
     * @param $max num 最大长度
     * @return bool true/false
     */
    static function passWord($min,$max,$str)
    {
        $str=self::strTrim($str);
        return (strlen($str) >= $min && strlen($str) <= $max) ? true : false;
    }

    /**
     * 验证Email
     * @param $str string 邮箱
     * @return bool true/false
     */
    static function Email($str)
    {
        $str = self::strTrim($str);
        return preg_match("/^([a-z0-9_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.){1,2}[a-z]{2,4}$/i",$str) ? true : false;
    }

    /**
     * 验证身份证(中国)
     * @param $str string 身份证号码
     * @return bool true/false
     */
    static function idCard($str)
    {
        $str = self::strTrim($str);
        return preg_match("/^([0-9]{15}|[0-9]{17}[0-9a-z])$/i",$str) ? true : false;
    }

    //手机验证
    static function Phone($str)
    {
        if(strlen($str) == 11)
        {
            return true;
        }
        return false;
    }
    /**
     * 验证座机电话
     * @param $str string 座机电话
     * @param $type 座机类型，分国内(CHN)和国际(INT)
     * @return bool true/false
     */
    static function Tel($type, $str)
    {
        $str=self::strTrim($str);
        switch($type)
        {
            case "CHN":
                return preg_match("/^([0-9]{3}|0[0-9]{3})-[0-9]{7,8}$/",$str) ? true : false;
                break;
            case "INT":
                return preg_match("/^[0-9]{4}-([0-9]{3}|0[0-9]{3})-[0-9]{7,8}$/",$str) ? true : false;
                break;
            default:
                break;
        }
    }
    /**
     * 验证邮编
     * @param $str string 邮编
     * @return bool true/false
     */
    static function Zipcode($str)
    {
        $str=self::strTrim($str);
        return preg_match("/^[1-9]\d{5}$/", $str) ? true : false;
    }
    /**
     * 验证URL
     * @param $str string 邮编
     * @return bool true/false
     */
    static function Url($str)
    {
        $str=self::strTrim($str);
        return preg_match("/^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/",$str) ? true : false;
    }


    /**
     * 验证日期格式是否正确
     * @param string $date
     * @param string $format
     * @return boolean
     */
    static function is_date($date,$format='Y-m-d'){
        $t=date_parse_from_format($format,$date);
        if(empty($t['errors'])){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 是否为正整数
     * @param int $number
     * @return boolean
     */
    static function is_positive_number($number){
        if(ctype_digit ($number)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 是否为大于0的数字数
     * @param int $number
     * @return boolean
     */
    static function is_float_number($number){
        if(is_numeric($number) && $number>0){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 是否是AJAX请求
     * @return boolean
     */
    static public function is_ajax()
    {
        if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) &&
            strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){
            return true;
        }else{
            return false;
        }
    }


    /**
     * 是否是微信访问
     * @return boolean
     */
    static public function is_Weixin()
    {
        if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
            return true;
        }
        return false;
    }
}
?>