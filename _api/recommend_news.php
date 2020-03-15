<?php
header('Content-type: application/json');

include_once 'requests.php';
include_once 'check_referer.php';
include_once '../SQLC.php';

function txts($t) {
    $t = trim($t);
    if(file_exists($t)){
        $fp = @fopen($t,"r") or "nope";
        if ($fp === 'nope') return '读取文本失败，服务器繁忙，请刷新。';
        $str = @fread($fp, filesize($t));//指定读取大小，这里把整个文件内容读取出来
        @fclose($fp);
        return $str;
    }
    return '读取文本失败';
}

$auth = isset($_SESSION['auth']) ? $_SESSION['auth'] : -1;
if ($auth < 0) {
    $res = array(
        'code' => 10000,
        'message' => "auth required"
    );
    die(json_encode($res, 384));
}

$req = isset($_REQUEST['class']) ? $_REQUEST['class'] : '';

$dbh = new SQLC();

$sql = 'SELECT * FROM `tb_col` where clss like '.$dbh->_T('%'.$req.'%');
if (is_numeric($req)) $sql .= ' or news_id = '.$dbh->_T(intval($req));
$sql .= ' order by rand() limit 2';
$rs = $dbh->query($sql);
if (isset($rs[0])) {
//    print_r($rs);
    foreach ($rs as $k => $rr) {
        $rs[$k]['contents'] = explode("\r\n", txts('/var/www/html/static/txt/' . trim($rr['contents'])));
    }
    $res = array(
        'code' => 0,
        'result' => $rs,
        'sql' => null
    );
} else {
    $res = array(
        'code' => 1000,
        'result' => "服务器繁忙，请重试",
        'sql' => null
    );
}

echo json_encode($res, 384);