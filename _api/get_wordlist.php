<?php
// SELECT * FROM `words` where `id` in (1, 4, 3, 5) order by field(`id`, 1, 4, 3, 5)
header('Content-type: application/json');

include_once 'requests.php';
include_once 'check_referer.php';
include_once '../SQLC.php';

$dbh = new SQLC();
$list_id = $_REQUEST['lid'];
$sql = 'select * from `words_list` where `id` = '.$dbh->_T($list_id);
$rs = $dbh->query($sql);
if (isset($rs[0])) {
    $array = json_decode($rs[0]['list_words'], 1);
    if (is_array($array)) {
        $str = '';
        $comma = false;
        foreach ($array as $r) {
            if ($comma == false) $comma = true; else $str .= ', ';
            $str .= intval($r);
        }
        $sql = 'SELECT * FROM `words` where `id` in ('.$str.') order by field(`id`, '.$str.')';
        $rs = $dbh->query($sql);
        $word_id = []; $word = [];
        foreach ($rs as $sp) {
            $word_id[] = $sp['id'];
            $word[] = $sp['word'];
        }
        $res = array(
            'code' => 0,
            'message' => 'success.',
            'result' => array(
                'id' => $word_id,
                'word' => $word
            )
        );
    } else {
        $res = array(
            'code' => 0,
            'message' => 'There is no words in the list.',
            'result' => array(
                'id' => [],
                'word' => []
            )
        );
    }
} else {
    $res = array(
        'code' => 10000,
        'message' => 'It doesn\'t exist.'
    );
}

echo json_encode($res);