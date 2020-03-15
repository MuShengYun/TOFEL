<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-22
 * Time: 9:29
 */
header('Content-type: application/json');

include_once 'requests.php';
include_once 'check_referer.php';
include_once '../SQLC.php';

$auth = isset($_SESSION['auth']) ? $_SESSION['auth'] : -1;
if ($auth < 10) {
    $res = array(
        'code' => 10000,
        'message' => "auth required"
    );
    die(json_encode($res, 384));
}
$dbh = new SQLC();
$list_id = (isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 'null');
$list_name = $_REQUEST['lname'];
$list_cate = $_REQUEST['lcate'];
$creator = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : -1;
$words = json_decode($_REQUEST['words'], 1);
foreach ($words as $k => $r) {
    $words[$k] = intval($r);
}
$words = array_unique($words);
if (strlen($list_name) < 1 || count($words) < 1)
    $res = array(
        'code' => 1000,
        'message' => "你未添加单词"
    );
else {
    $sql = 'replace into `words_list` values (' . $list_id . ', ' . $dbh->_T($list_name) . ', ' . $dbh->_T($list_cate) . ', ' . $dbh->_T($creator) . ', ' . $dbh->_T(json_encode($words)) . ', ' . $dbh->_T(time()) . ')';
    $rs = $dbh->query($sql);
    $res = array(
        'code' => 0,
        'message' => $rs
    );
}
echo json_encode($res, 384);