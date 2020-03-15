<?php
header('Content-type: application/json');

include_once 'requests.php';
include_once 'check_referer.php';
include_once '../SQLC.php';

$cate = $_REQUEST['cate'];

switch ($cate) {
	case 0:
	
}