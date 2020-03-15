<?php
header('Content-type: application/json');

include_once 'requests.php';
include_once 'check_referer.php';
include_once '../SQLC.php';

$e_to_c = (isset($_REQUEST['e_to_c']) && is_numeric($_REQUEST['e_to_c'])) ? intval($_REQUEST['e_to_c']) : 5;
$c_to_e = (isset($_REQUEST['c_to_e']) && is_numeric($_REQUEST['c_to_e'])) ? intval($_REQUEST['c_to_e']) : 5;
$e_to_e = (isset($_REQUEST['e_to_e']) && is_numeric($_REQUEST['e_to_e'])) ? intval($_REQUEST['e_to_e']) : 5;
$spell = (isset($_REQUEST['spell']) && is_numeric($_REQUEST['spell'])) ? intval($_REQUEST['spell']) : 5;
$sel = (isset($_REQUEST['sel']) && is_numeric($_REQUEST['sel'])) ? intval($_REQUEST['sel']) : 5;

$uid = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : -1;
if ($uid == -1) {
    $res = array(
        'code' => 20000,
        'message' => '登录丢失'
    );
} else {
    $wr = array(
        'uid' => $uid,
        'settings' => array(
            'ec' => $e_to_c,
            'ce' => $c_to_e,
            'ee' => $e_to_e,
            'sp' => $spell,
            'sel' => $sel
        )
    );
    file_put_contents('../user_settings/quiz/'.$uid.".json", json_encode($wr));
    $res = array(
        'code' => 0,
        'message' => '设置成功',
        'result' => $wr
    );
}
echo json_encode($res, 384);