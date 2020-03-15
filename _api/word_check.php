<?php
header('Content-type: application/json');

include_once 'requests.php';
include_once 'check_referer.php';
include_once '../SQLC.php';

$dbh = new SQLC();

$word_id = intval($_REQUEST['id']);

function get_option($json) {
    $arr = json_decode($json, 1);
    if (isset($arr['response']['explains'])) {
        if (!is_array($arr['response']['explains']))
            return $arr['response']['explains'];
        else {
            $str = "";
            foreach ($arr['response']['explains'] as $ex) {
                $str .= $ex . ' ';
            }
            return $str;
        }
    }
    return false;
}

$sql = 'select * from `words` where id = '.$word_id.' limit 1';
$res = $dbh->query($sql);
if (!isset($res[0]))
    exit('{"code": 1000, "message": "not found"}');

$word = $res[0]['word'];
$true_ans = get_option($res[0]['json']);

$len = strlen($word);
$sub = [];

for ($i = $len; $i >= 1; --$i) {
    for ($j = 0; $j <= $len - $i; ++$j) {
        $sub[] = substr($word, $j, $i);
    }
}

$sql = "select *, (case \n";
$T = 0;
foreach ($sub as $r) {
    $sql .= "when word like '%$r%' then $T\n";
    ++$T;
    if ($T > 100) break;
}
$sql .= "   else $T end) as similarity from words where id != $word_id
order by similarity, rand() asc limit 10";
//exit($sql);
$res = $dbh->query($sql);
shuffle($res);
$res = array_slice($res, 0, 5);
$wordsheet = [];
$anssheet = [];
foreach ($res as $item) {
    $wordsheet[] = $item['word'];
    $anssheet[] = get_option($item['json']);
}
$ansnum = mt_rand(0, 5);
array_splice($wordsheet, $ansnum, 0, [$word]);
array_splice($anssheet, $ansnum, 0, [$true_ans]);
$resp = array(
    'code' => 0,
    'message' => array (
        'word' => $word,
        'options' => $anssheet,
        'answer' => $ansnum,
        'answord' => $wordsheet
    )
);
echo json_encode($resp, 384);