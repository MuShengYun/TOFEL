<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-4-22
 * Time: 13:50
 */
header('Content-type: application/json');

include_once 'requests.php';
include_once 'check_referer.php';
include_once '../SQLC.php';
set_time_limit(200);

$dbh = new SQLC();
$t_start = time();

//$word = isset($_REQUEST['word'])?$_REQUEST['word']:null;
function webster($word) {
    $url = 'https://www.merriam-webster.com/dictionary/' . trim($word);
    preg_match_all("/<span class=\"sb-0\">(.|\n)*?<strong class=\"mw_t_bc\">(.|\n)*?<span(.|\n)*?<\/div>/", getContents($url), $match);
    $res = [];
    foreach ($match[0] as $t) {
        $mean = trim(strip_tags(strget($t, 'class="mw_t_bc">', "\n")));
        $res[] = preg_replace("/\s(?=\s)/", "\\1", $mean);
    }
    $res = array_unique($res);
    return $res;
}

$sql = 'select max(word_id) as m from `words_meaning_en`';
$rs = $dbh->query($sql);
if (isset($rs[0])) $start = intval($rs[0]['m']); else $start = 0;
$sql = 'select id, word from `words` where `id` > '.$start;
$rs = $dbh->query($sql);
echo date("Y-m-d H:i:s   ").$start."\n";

if (isset($rs[0])) {
    if (is_array($rs)) {

        foreach ($rs as $p) {
            if (time() - $t_start > 200) exit("Time Over. Stop getting Data. \n\n");
            $arr = webster($p['word']);
            if (isset($arr[0])) {
                foreach ($arr as $T0) {
                    $sql = 'insert into `words_meaning_en` values (null, '.$dbh->_T($p['id']).', '.$dbh->_T($T0).')';
                    $dbh->query($sql);
                }
            }
            echo $p['id'].' '.$p['word']."\n";
        }
    }
}