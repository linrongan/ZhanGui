
/**
 * 验证url格式
 * @author 刘阳(alexdany@126.com)
 * @date 2012-12-7 17:00:31
 */
function verUrl(url){
    var strRegex = "^((https|http|ftp|rtsp|mms)://)"
        + "?(([0-9a-z_!~*'().&=+$%-]+: )?[0-9a-z_!~*'().&=+$%-]+@)?" //ftp的user@
        + "(([0-9]{1,3}\.){3}[0-9]{1,3}" // IP形式的URL- 199.194.52.184
        + "|" // 允许IP和DOMAIN（域名）
        + "([0-9a-z_!~*'()-]+\.)*" // 域名- www.
        + "([0-9a-z][0-9a-z-]{0,61})?[0-9a-z]\." // 二级域名
        + "[a-z]{2,6})" // first level domain- .com or .museum
        + "(:[0-9]{1,4})?" // 端口- :80
        + "((/?)|" // a slash isn't required if there is no file name
        + "(/[0-9a-z_!~*'().;?:@&=+$,%#-]+)+/?)$";
    var re=new RegExp(strRegex);
    if (re.test(url)){
        return (true);
    }else{
        return (false);
    }
}// end of function verUrl


// 验证URL只能是本站域名
function verDomainUrl(url){
    var urlreg=/^(http(s)?:\/\/)?(www\.)?[ctrlv]+\.([c]{2})(\/[\w- .\/?%&=]*)?$/;
    if (!urlreg.test(url)){
        return false;
    }
    return true;
}

function in_array( a , arr ){
    var len  = arr.length ;
    if( len > 0 ){
        for(var i = 0 ; i < len ; i ++ ){
            if( a == arr[i] ){
                return true ;
            }
        }
    }
    return false ;
}

/**
 * *时间戳转化成日期
 */
function changetime(unixTime, isFull, timeZone) {
    if (typeof (timeZone) == 'number')
    {
        unixTime = parseInt(unixTime) + parseInt(timeZone) * 60 * 60;
    }
    if (unixTime=="")
    {
        return false;
    }
    var time = new Date(unixTime * 1000);
    var ymdhis = "";
    ymdhis += time.getUTCFullYear() + "-";
    ymdhis += (time.getUTCMonth()+1) + "-";
    ymdhis += time.getUTCDate();
    if (isFull === true)
    {
        ymdhis += " " + time.getUTCHours() + ":";
        ymdhis += time.getUTCMinutes() + ":";
        ymdhis += time.getUTCSeconds();
    }

    return ymdhis;
}


/* 校验 */
function ChkUtil_isNull(str){
    if (null == str || "" == str.trim()) {
        return true;
    } else {
        return false;
    }
}

// 校验电话号码
function is_Tel(str){
    var patrn = /^(0[\d]{2,3}-)?\d{6,8}(-\d{3,4})?$/;
    if (!patrn.test(str)){
        return false;
    }
    return true;
}

// 校验合法时间
function isDate(str){
    if (!/\d{4}(\.|\/|\-)\d{1,2}(\.|\/|\-)\d{1,2}/.test(str)) {
        return false;
    }
    var r = str.match(/\d{1,4}/g);
    if (r == null) {
        return false;
    }
    var d = new Date(r[0], r[1] - 1, r[2]);
    return d.getFullYear() == r[0] && d.getMonth() + 1 == r[1] && d.getDate() == r[2];
}

// 校验是否全是数字
function isDigit(str) {
    var patrn = /^\d+$/;
    return patrn.test(str);
}


function checkPhone(phone){
    //验证电话号码手机号码，包含至今所有号段
    var ab=/^(13[0-9]|14[0-9]|15[0-9]|16[0-9]|17[0-9]|18[0-9]|19[0-9])\d{8}$/;
    if(ab.test(phone) == false){
        return false;
    }
    return true;
}

function checkEmail(email){
    var myreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
    if(!myreg.test(email)){
        return false;
    }
    return true ;
}

//检查图片的上传格式
function checkImage(str){
    if(/^.*?\.(gif|png|jpg|jpeg)$/.test(str.toLowerCase())){
        return true ;
    } else {
        alert("只能上传jpg、jpeg、png或gif格式的图片！");
        return false;
    }
}

//检查文件的上传格式
function checkFile(str){
    if(/^.*?\.(doc|zip|rar|ppt|xls|docx|xlsx|pptx|pdf|pptx|txt)$/.test(str.toLowerCase())){
        return true ;
    } else {
        alert("只能上传doc、zip、rar、ppt、xls、docx、xlsx、pptx、pdf、pptx或txt格式的文件！");
        return false;
    }
}

//URL验证
function isURL(url){
    //在JavaScript中，正则表达式只能使用"default.htm"开头和结束，不能使用双引号
    //判断URL地址的正则表达式为:http(s)?://([\w-]+\.)+[\w-]+(/[\w- ./?%&=]*)?
    //下面的代码中应用了转义字符"\"输出一个字符"/"
    var Expression=/([\w-]+\.)+[\w-]+(\/[\w- .\/?%&=]*)?/;
    var objExp=new RegExp(Expression);
    if(objExp.test(url)==true){
        return true;
    }else{
        return false;
    }
}

//密码
function isPwd(str) {
    var patrn = /^\w{6,16}$/;
    return patrn.test(str);
}

