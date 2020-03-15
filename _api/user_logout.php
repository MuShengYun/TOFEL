<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-22
 * Time: 9:04
 */
header('Content-type: application/json');

include_once 'requests.php';
include_once 'check_referer.php';
include_once '../SQLC.php';

unset($_SESSION['user_id']);
unset($_SESSION['auth']);
unset($_SESSION['token']);

$res = array(
    'code' => '0',
    'message' => 'success'
);
echo json_encode($res, 384);