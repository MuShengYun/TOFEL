<?php
header('Content-type: application/json');

include_once 'requests.php';
include_once 'check_referer.php';
include_once '../SQLC.php';

error_reporting(0);

$lists = (isset($_REQUEST['list'])) ? $_REQUEST['list'] : null;
if (strlen($lists) < 1) $lists = null;
$t_cate = isset($_REQUEST['t_cate']) ? $_REQUEST['t_cate'] : null;
if (strlen($t_cate) < 1) $t_cate = null;

$dbh = new SQLC();
$uid = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : -1;
$sql = 'SELECT `problems`.`id`, `problems`.`time_start`,  `words_list`.`list_name`, `words_list`.`list_cate` FROM `problems` left join `words_list`
 on (`words_list`.`id` = `problems`.`use_list`) where `problems`.`uid` = '.$dbh->_T($uid).' and `problems`.`time_start` > '.(time() - 86400 * 3).' order by `problems`.`id` desc';
$quizs = $dbh->query($sql);
$sql = 'SELECT wordid, `words`.`word`, `words`.`json`, count(wordid) as cnt, avg(use_time) as a FROM `user_mistake_list` left join `words` on (`words`.`id` = `user_mistake_list`.`wordid`) where `uid` = 
'.$dbh->_T($uid).' and `result` = 3 and `ts` > '.(time() - 86400 * 3);
if ($lists !== null) $sql .= ' and `lid` = '.$dbh->_T($lists);
if ($t_cate === 'un_choice')
    $sql .= ' and `tcate` != "choice"';
elseif ($t_cate !== null)
    $sql .= ' and `tcate` = '.$dbh->_T($t_cate);
$sql .= ' group by wordid order by `cnt` desc';
$my_mistake = $dbh->query($sql);
if (isset($my_mistake[0]))
    foreach ($my_mistake as $k => $v) {
        $my_mistake[$k]['json'] = json_decode($v['json'], 1)['response']['explains'];
        $my_mistake[$k]['meanings'] = null;
        if (is_array($my_mistake[$k]['json']))
            foreach ($my_mistake[$k]['json'] as $expl)
                $my_mistake[$k]['meanings'] .= $expl.';';
        unset($my_mistake[$k]['json']);
    }
$sql = 'SELECT wordid, `words`.`word`, count(wordid) as cnt, avg(use_time) as a, count(distinct `user_mistake_list`.`uid`) as mx FROM `user_mistake_list` left join `words` on (`words`.`id` = `user_mistake_list`.`wordid`) where `result` = 3 ';
if ($lists !== null) $sql .= ' and `lid` = '.$dbh->_T($lists);
if ($t_cate === 'un_choice')
    $sql .= ' and `tcate` != "choice"';
elseif ($t_cate !== null) $sql .= ' and `tcate` = '.$dbh->_T($t_cate);
$sql .= ' group by wordid order by `cnt` desc';
$all_mistake = $dbh->query($sql);
$res = array(
    'code' => 0,
    'quizs' => $quizs,
    'my_mis' => $my_mistake,
    'all_mis' => $all_mistake
);
echo json_encode($res, 384);