<?php
// SELECT `problems`.*, `words_list`.`list_name`, `words_list`.`list_cate` FROM `problems` left join `words_list` on (`words_list`.`id` = `problems`.`use_list`) where `uid` = 1
header('Content-type: application/json');

include_once 'requests.php';
include_once 'check_referer.php';
include_once '../SQLC.php';

error_reporting(0);

date_default_timezone_set('PRC');
$dbh = new SQLC();
$uid = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : -1;
$sql = "SELECT `problems`.*, `words_list`.`list_name`, `words_list`.`list_cate` FROM `problems` left join `words_list` on (`words_list`.`id` = `problems`.`use_list`) where `uid` = ".$dbh->_T($uid)." order by `id` desc";
$rs = $dbh->query($sql);
$arr = [];
if (isset($rs[0])) {
    foreach ($rs as $r) {
        $pnt = doubleval($r['point']);
        if ($pnt >= 99.0) { $color = '#0a0'; }
        elseif ($pnt >= 97.0) { $color = '#008'; }
        elseif ($pnt >= 90.0) { $color = '#000'; }
        elseif ($pnt >= 80.0) { $color = '#aaa'; }
        else { $color = '#f00'; }
        $arr[] = array(
            'list_name' => $r['list_name'],
            'list_cate' => $r['list_cate'],
            'time_start' => date("Y-m-d H:i:s", $r['time_start']),
            'time_use' => (isset($r['time_end']) ? intval($r['time_end']) - intval($r['time_start']) : "Unfinished"),
            'result' => json_decode($r['result'], 1),
            'score' => $pnt,
            'usecolor' => $color
        );
    }
    $res = array(
        'code' => 0,
        'message' => 'success',
        'result' => $arr
    );
} else {
    $res = array(
        'code' => 2,
        'message' => 'not take any exams'
    );
}

echo json_encode($res, 384);