<?php
include_once "../SQLC.php";
header('Content-type: application/json');
$dbh = new SQLC("coca");
$wrd = trim($_REQUEST['word']);
$sql = "SELECT * FROM `words_freq` WHERE `word` = ".$dbh->_T($wrd)." or `word` = ".$dbh->_T(substr($wrd, 0, -1))." limit 1";
$rs = $dbh->query($sql);
if (isset($rs[0])) {
	foreach ($rs[0] as $k1 => $v1) {
		if (is_numeric($v1)) $rs[0][$k1] = intval($rs[0][$k1]);
		else $rs[0][$k1] = iconv("GB2312","UTF-8//IGNORE", $rs[0][$k1]);
	}
	$res = array(
		'code' => 0,
		'message' => "success",
		'result' => $rs[0]
	);
} else {
	$res = array(
		'code' => 100,
		'message' => "Not Found",
		'result' => null
	);
}
echo json_encode($res, 384);