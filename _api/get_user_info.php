<?php
header('Content-type: application/json');

include_once 'requests.php';
include_once 'check_referer.php';
include_once 'class_user.php';
include_once '../SQLC.php';

error_reporting(0);

$uid = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : -1;
$us = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : -1;
date_default_timezone_set('PRC');
$dbh = new SQLC();

$user = new Users($us);

$res = array(
    'code' => 0,
    'message' => 'success',
    'qq' => $user->user_qq,
    'uname' => $user->user_name,
    'reg_time' => date("Y-m-d H:i:s", $user->reg_time),
    'school' => $user->school,
    'last_login' => ($user->last_login == '未登录')?($user->last_login):(date("Y-m-d H:i:s", $user->last_login))
);

$rs = $dbh->query('SELECT min(`use_time`) as m, avg(`use_time`) as v FROM `user_mistake_list` where uid = '.$us);
if (isset($rs[0])) {
	$res['min_time'] = $rs[0]['m'];
	$res['avg_time'] = sprintf("%.5lf", $rs[0]['v']);
}

echo json_encode($res, 384);