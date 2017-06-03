<?php
/**
 *      (C)2014-2099 Guangzhou RuoYuWangLuo KeJi Inc.
 * 		若宇网 ruoyw.com
 *		这不是一个开源和免费软件,使用前请获得作者授权
 *      /inc/dbclass.php
 */
if(!defined('RUOYWCOM'))
{
    exit('Access Denied');
}
/**
 * 数据库操作工具类
 *
 */
class dbtemplate
{
    protected static $_instance = null;
    protected static $_instance1 = null;
    function __construct($dsn, $user,$pwd)
    {
        try {
            $_opts_values = array(PDO::ATTR_PERSISTENT=>true,PDO::ATTR_ERRMODE=>2,PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8');
            $this->dbh = new PDO($dsn, $user, $pwd,$_opts_values);
         } catch (PDOException $e){
            echo $e->getMessage();
            die();
        }
    }
    /**
     * 防止克隆
     *
     */
    private function __clone() {}

    /**
     * Singleton instance
     *
     * @return Object
     */
    public static function getInstance($dsn, $user, $pwd)
    {
        if (self::$_instance === null) {
            self::$_instance = new self($dsn, $user, $pwd);
        }
        return self::$_instance;
    }

    /**
     * Singleton instance
     *
     * @return Object
     */
    public static function getInstance1($dsn, $user, $pwd)
    {
        if (self::$_instance1 === null) {
            self::$_instance1 = new self($dsn, $user, $pwd);
        }
        return self::$_instance1;
    }


    /**
     * 返回多行记录
     * @param  $sql
     * @param  $parameters
     * @return  记录数据
     */
    public function queryrows($sql, $parameters = null) {
        return $this->exequery($sql, $parameters);
    }

    /**
     * 返回为单条记录
     * @param  $sql
     * @param  $parameters
     * @return
     */
    public function queryrow($sql, $parameters = null) {
        $rs = $this->exequery($sql, $parameters);
        if (count($rs) > 0) {
            return $rs[0];
        } else {
            return null;
        }
    }

    /**
     * 查询单字段，返回整数
     * @param  $sql
     * @param  $parameters
     * @return
     */
    public function queryforint($sql, $parameters = null) {
        $rs = $this->exequery($sql, $parameters);
        if (count($rs) > 0) {
            return intval($rs[0][0]);
        } else {
            return null;
        }
    }

    /**
     * 查询单字段，返回浮点数(float)
     * @param  $sql
     * @param  $parameters
     * @return
     */
    public function queryforfloat($sql, $parameters = null) {
        $rs = $this->exequery($sql, $parameters);
        if (count($rs) > 0) {
            return floatval($rs[0][0]);
        } else {
            return null;
        }
    }

    /**
     * 查询单字段，返回浮点数(double)
     * @param  $sql
     * @param  $parameters
     * @return
     */
    public function queryfordouble($sql, $parameters = null) {
        $rs = $this->exequery($sql, $parameters);
        if (count($rs) > 0) {
            return doubleval($rs[0][0]);
        } else {
            return null;
        }
    }

    /**
     * 查询单字段，返回对象，实际类型有数据库决定
     * @param  $sql
     * @param  $parameters
     * @return
     */
    public function queryforobject($sql, $parameters = null) {
        $rs = $this->exequery($sql, $parameters);
        if (count($rs) > 0) {
            return $rs[0][0];
        } else {
            return null;
        }
    }

    /**
     * 执行一条语句.insert / upadate / delete
     * @param  $sql
     * @param  $parameters
     * @return  影响行数
     */
    public function query($sql, $parameters = null)
    {
        return $this->exeupdate($sql, $parameters);
    }

    /**
     * 执行一条插入语句.insert,只适合插入自增的
     * @param  $sql
     * @param  $parameters
     * @return  返回插入的自增id
     */
    public function insertquery($sql, $parameters = null) {
        return $this->insertlastid($sql, $parameters);
    }
    //开始事务
    public function StartTransaction()
    {
        $this->dbh->beginTransaction();
    }
    //提交事务
    public function SubmitTransaction()
    {
        $this->dbh->commit();
    }
    //回滚事务
    public function RollbackTransaction()
    {
        $this->dbh->rollBack();
    }

    private function exequery($sql, $parameters = null) {
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute($parameters);
        if ($stmt->errorCode() != '00000')
        {
            //此处进行数据错误记录并预警！
            $err=$stmt->errorInfo();
            print_r($err);
            die('db exception code1：'.$err[0]);
        }
        $rs = $stmt->fetchall(PDO::FETCH_ASSOC);
        $stmt = null;
        return $rs;
    }

    private function exeupdate($sql, $parameters = null)
    {

        $stmt = $this->dbh->prepare($sql);
        $stmt->execute($parameters);
        if ($stmt->errorCode() != '00000')
        {
            //此处进行数据错误记录并预警！
            $err=$stmt->errorInfo();
            print_r($err);
            die('db exception code2：'.$err[0]);
        }
        $affectedrows = $stmt->rowcount();
        $stmt = null;
        return $affectedrows;
    }

    private  function insertlastid($sql, $parameters = null)
    {
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute($parameters);
        if ($stmt->errorCode() != '00000')
        {
            //此处进行数据错误记录并预警！
            $err=$stmt->errorInfo();
            print_r($err);
            die('db exception code3：'.$err[0]);
        }
        $lastinsertid = $this->dbh->lastInsertId();
        $stmt = null;
        return $lastinsertid;
    }

        function test()
        {
            var_dump($this->dbh);
        }

}?>