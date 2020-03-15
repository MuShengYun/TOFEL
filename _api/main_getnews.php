<?php
header('Content-type: application/json');

include_once 'requests.php';
include_once 'check_referer.php';
include_once '../SQLC.php';

$auth = isset($_SESSION['auth']) ? $_SESSION['auth'] : -1;
if ($auth < 0) {
    $res = array(
        'code' => 10000,
        'message' => "auth required"
    );
    die(json_encode($res, 384));
}
$dbh = new SQLC();
$sql = 'SELECT * FROM `tb_col` where not instr(`news_title`, "chin") order by rand() limit 5';
$rs = $dbh->query($sql);
foreach($rs as $k=>$rr) {
	$rs[$k]['contents'] = @file('/var/www/html/static/txt/'.trim($rr['contents']))[0];
}
$res = array(
	'code' => 0,
	'result' => $rs
);

echo json_encode($res, 384);