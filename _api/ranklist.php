<?php
//SELECT `problems`.`uid` as `user_id`, count(point) as cnt, avg(point) as `avg`,
// `user_info`.* FROM `problems` left join `user_info` on (`user_info`.`uid` = `problems`.`uid`)
// where time_end != null group by `user_id` order by `avg` desc
header('Content-type: application/json');

include_once 'requests.php';
include_once 'check_referer.php';
include_once '../SQLC.php';

error_reporting(0);

$uid = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : -1;
date_default_timezone_set('PRC');
$dbh = new SQLC();
$limits = isset($_REQUEST['limits']) ? intval($_REQUEST['limits']) : 100;

$sql = 'SELECT `problems`.`uid` as `user_id`, count(point) as cnt, sum(perfects) as `pt`, avg(point) as `avg`, `result`, `user_info`.*, wordcnt, allcnt FROM `problems` 
left join `user_info` on (`user_info`.`uid` = `problems`.`uid`) 
left join (select uid as u2, count(distinct wordid) as wordcnt, count(1) as allcnt from user_mistake_list group by uid) as t on (t.u2 = problems.uid) 
group by `user_id` order by `pt` desc, max(`problems`.`time_start`) desc limit '.$limits;
// exit($sql);
$all_rank = $dbh->query($sql);

$sql = 'SELECT `problems`.`uid` as `user_id`, count(point) as cnt, sum(perfects) as `pt`, avg(point) as `avg`,
`user_info`.* FROM `problems` left join `user_info` on (`user_info`.`uid` = `problems`.`uid`)
where time_end > 0 and time_start > '.(time() - 86400 * 7).' group by `user_id` order by `pt` desc limit '.$limits;
$week_rank = $dbh->query($sql);

$sql = 'SELECT `problems`.`uid` as `user_id`, count(point) as cnt, sum(perfects) as `pt`, avg(point) as `avg`, 
`result`, `user_info`.* FROM `problems` left join `user_info` on (`user_info`.`uid` = `problems`.`uid`) 
where time_end > 0 and `problems`.`uid` = '.$uid;
$my_pt = $dbh->query($sql)[0];
if (is_array($my_pt)) {
    $my_pts = intval($my_pt['pt']);
    $sql = 'select count(`pt`) as `cnts` from (select `uid`, sum(perfects) as `pt` 
    FROM `problems` group by `uid`) `tmp` where `pt` > '.$dbh->_T($my_pts);
    $cntss = intval($dbh->query($sql)[0]['cnts']);
} else {
    $my_pts = null;
    $cntss = -10;
}

$sql = 'SELECT `problems`.`uid` as `user_id`, count(point) as cnt, sum(perfects) as `pt`, avg(point) as `avg`, 
`result`, `user_info`.* FROM `problems` left join `user_info` on (`user_info`.`uid` = `problems`.`uid`) 
where time_end > 0 and `problems`.`uid` = '.$uid.' and time_start > '.(time() - 86400 * 7);
$my_wk_pt = $dbh->query($sql)[0];
if (is_array($my_wk_pt)) {
    $my_pts = intval($my_pt['pt']);
    $sql = 'select count(`pt`) as `cnts` from (select `uid`, sum(perfects) as `pt` 
    FROM `problems` where time_start > '.(time() - 86400 * 7).' group by `uid`) `tmp` 
    where `pt` > '.$dbh->_T($my_pts);
    $cntss_wk = intval($dbh->query($sql)[0]['cnts']);
} else {
    $my_pts = null;
    $cntss_wk = -10;
}

$res = array(
    'code' => 0,
    'message' => 'success',
    'all_rank' => $all_rank,
    'week_rank' => $week_rank,
    'my_pt' => $my_pt,
    'my_rank' => $cntss + 1,
    'my_week_pt' => $my_wk_pt,
    'my_week_rank' => $cntss_wk + 1

);


echo json_encode($res, 384);