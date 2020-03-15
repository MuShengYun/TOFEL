<?php
header('Content-type: application/json');

include_once 'requests.php';
include_once 'check_referer.php';
include_once '../SQLC.php';

function is_json($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

$dbh = new SQLC();
$lid = intval($_REQUEST['lid']);
$tid = intval($_REQUEST['tid']);
$last_tid = intval($_SESSION['now_tid']);
if ($tid == $last_tid || $tid == $last_tid + 1) {
    $_SESSION['now_tid'] = $tid;
} else {
    $res = array(
        'code' => 5000,
        'message' => 'cheat_detected'
    );
    die(json_encode($res, 384));
}
$ans = $_REQUEST['ans'];
$tcate = $_REQUEST['tcate'];
$use_time = doubleval($_REQUEST['usetime']);
$uid = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : -1;
$sql = 'SELECT * FROM `problems` WHERE `id` = '.$lid;
$true_ans_ = $dbh->query($sql);
if (isset($true_ans_[0])) {
    $true_ans = json_decode($true_ans_[0]['true_ans'], 1)[$tid];
    $word_id = json_decode($true_ans_[0]['word_list'], 1)[$tid];
    if (is_array($true_ans) && in_array($ans, $true_ans) || $ans == $true_ans) {
        $res = array(
            'code' => 0,
            'message' => 'right',
            "word_id" => $word_id,
            "my_ans" => $ans,
            'true_ans' => $true_ans
        );
        $sql = 'insert into `user_mistake_list` values (null, '.$dbh->_T($uid).', '.$dbh->_T($lid).', '.$dbh->_T($word_id).', '.$dbh->_T(time()).', '.$dbh->_T($use_time).', '.$dbh->_T($tid).', '.$dbh->_T($tcate).', '.$dbh->_T(0).')';
        // $dbh->query($sql);
    } else {
        $res = array(
            'code' => 1,
            'message' => 'wrong answer',
            "word_id" => $word_id,
            'true_answer' => $true_ans
        );
        $sql = 'insert into `user_mistake_list` values (null, '.$dbh->_T($uid).', '.$dbh->_T($lid).', '.$dbh->_T($word_id).', '.$dbh->_T(time()).', '.$dbh->_T($use_time).', '.$dbh->_T($tid).', '.$dbh->_T($tcate).', '.$dbh->_T(3).')';
//        exit($sql);
        $dbh->query($sql);
    }
} else {
    $res = array(
        'code' => 5000,
        'message' => 'cheat_detected'
    );
}
echo json_encode($res, 384);