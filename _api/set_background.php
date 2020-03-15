<?php
header('Content-type: application/json');

include_once 'requests.php';
include_once 'check_referer.php';
include_once '../SQLC.php';

$bg = isset($_REQUEST['bgpic']) ? $_REQUEST['bgpic'] : null;
if ($bg !== null)
	$_SESSION['background-pic'] = base64_encode($bg);
else 
	unset($_SESSION['background-pic']);
$res = array(
    'code' => 0,
    'message' => $bg
);
echo json_encode($res, 384);