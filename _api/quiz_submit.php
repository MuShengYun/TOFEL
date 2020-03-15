<?php
header('Content-type: application/json');

include_once 'requests.php';
include_once 'check_referer.php';
include_once '../SQLC.php';

$dbh = new SQLC();

$quiz_id = $_REQUEST['qid'];
$perfect_cnt = intval($_REQUEST['cnt1']);
$great_cnt = intval($_REQUEST['cnt2']);
$good_cnt = intval($_REQUEST['cnt3']);
$miss_cnt = intval($_REQUEST['cnt4']);
if ($perfect_cnt + $great_cnt + $good_cnt + $miss_cnt > $_SESSION['now_tid'] + 5) {
    $res = array(
        'code' => 5000,
        'message' => 'cheat_detected'
    );
    die(json_encode($res, 384));
}
$combo = intval($_REQUEST['cnt5']);
$score = $_REQUEST['score'];
if ($score > 100 || $score < 0) {
    $res = array(
        'code' => 5000,
        'message' => 'cheat_detected'
    );
} else {
    $rst = [$perfect_cnt, $great_cnt, $good_cnt, $miss_cnt, $combo];
    $sql = 'UPDATE `problems` SET `time_end` = '.$dbh->_T(time()).', `perfects` = '.$dbh->_T($perfect_cnt).'
    , `result` = '.$dbh->_T(json_encode($rst)).', `point` = '.$dbh->_T($score).' WHERE `problems`.`id` = '.$dbh->_T($quiz_id).';';
    $dbh->query($sql);
    $res = array(
        'code' => 0,
        'message' => 'success'
    );
}

echo json_encode($res, 384);
