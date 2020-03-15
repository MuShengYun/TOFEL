<?php
/**
 * Created by PhpStorm.
 * User: yohane
 * Date: 2018-10-9
 * Time: 11:54
 */

class SQLC {
    private $dbh = null;
    public function __construct($dbName = "seuwords") {
        $this->connect($dbName);
    }
    public function connect($dbName = "seuwords") {
        // 连接MySQL
        $dbms='mysql';     //数据库类型 Oracle 用ODI,对于开发者来说，使用不同的数据库，只要改这个，不用记住那么多的函数了
        $host='localhost'; //数据库主机名
        // $dbName='seuwords';    //使用的数据库
        $user='root';      //数据库连接用户名
        $pass='114514i9i9810';          //对应的密码
        $dsn="$dbms:host=$host;dbname=$dbName";
        try {
            $this->dbh = new PDO($dsn, $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES'utf8';"));
            return [0, 'success'];
        } catch (PDOException $e) {
            return [2000, $e->getMessage()];
        }
    }
    public function query($sql) {
        try {
            $res = $this->dbh->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        } catch (PDOException $e) {
            return 'error: '.$e->getMessage();
        }/* catch (Error $e) {
            echo "error:\nSQL: ".$sql."\nMessage: ".$e->getMessage();
            return "error:\nSQL: ".$sql."\nMessage: ".$e->getMessage();
        }*/
    }
    public function _T($_t) {
        return $this->dbh->quote($_t);
    }
}