<?php
header('Content-type: application/json');

include_once 'requests.php';
include_once 'check_referer.php';
include_once '../SQLC.php';

$dbh = new SQLC();
$sql = 'select *, `user_info`.`nick` from (`words_list` left join `user_info` on (`words_list`.`creator` = `user_info`.`uid`)) 
 left join (SELECT use_list, count(`use_list`) as cnt FROM `problems` group by `use_list`) `tmpl` on (`words_list`.`id` = `tmpl`.`use_list`) order by `id` desc';
$res = [];
$rs = $dbh->query($sql);
foreach ($rs as $r) {
    $res[$r['list_cate']][] = array(
        'id' => $r['id'],
        'lname' => $r['list_name'],
        'lcate' => $r['list_cate'],
        'creator' => $r['nick'],
        'creator_uid' => $r['creator'],
        'create_time' => date("Y-m-d H:i:s", $r['create_time']),
        'cnts' => intval($r['cnt'])
    );
}
$res = array(
    'code' => 0,
    'result' => $res
);
echo json_encode($res, 384);