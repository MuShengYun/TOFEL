<?php
/**
 * Created by PhpStorm.
 * User: yohane
 * Date: 2018-10-22
 * Time: 8:33
 */
header('Content-type: application/json');

include_once 'requests.php';
include_once 'check_referer.php';
include_once '../SQLC.php';
include_once 'class_user.php';

$dbh = new SQLC();
$uname = $dbh->_T($_REQUEST['uname']);
$upass = $dbh->_T($_REQUEST['upass']);
$sql = "select * from `users` where `uname` = $uname and `upass` = $upass";
$rs = $dbh->query($sql);
if (isset($rs[0])) {
    // 登录成功
    $ip = $_SERVER['REMOTE_ADDR'];
    $ua = $_SERVER['HTTP_USER_AGENT'];
    $_SESSION['user_id'] = $rs[0]['uid'];
    $usr = new Users($rs[0]['uid']);
    $_SESSION['username'] = $usr->user_name;
    $_SESSION['auth'] = $rs[0]['auth'];
    $tok = $_SESSION['token'] = md5(time().$ip.'make_yohane_voice');
    $expire = time() + 86400;
    $sql = "delete from `user_token` where `uid` = ".$dbh->_T($_SESSION['user_id']);
    $dbh->query($sql);
    $sql = "insert into `user_token` values (".$dbh->_T($_SESSION['user_id']).", 
    ".$dbh->_T($tok).", ".$dbh->_T($ip).", ".$dbh->_T($ua).", ".$dbh->_T($expire).")";
    $dbh->query($sql);
    $res = array(
        'code' => 0,
        'message' => '登录成功'
    );
} else {
    $res = array(
        'code' => 1000,
        'message' => '登录失败'
    );
}
echo json_encode($res, 384);