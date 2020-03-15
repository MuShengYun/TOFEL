<?php

header('Content-type: application/json');
require_once 'requests.php';

function truncate($q) {
    $len = abslength($q);
    return $len <= 20 ? $q : (mb_substr($q, 0, 10) . $len . mb_substr($q, $len - 10, $len));
}

function get_from_youdao($query) {
    $url = 'http://openapi.youdao.com/api';
    $appKey = '6828b413970b5530';
    $salt = '1';
    $pswd = 'UlKUp2gsaUbwhnV1tJNSR8aN1TBsu2Ct';
    $sign = md5($appKey.$query.$salt.$pswd);
    $pst = array(
        'q' => $query,
        'from' => 'EN',
        'to' => 'zh_CHS',
        'appKey' => $appKey,
        'salt' => $salt,
        'sign' => $sign
    );
    $api = json_decode(getContents($url, $pst), 1);
    return $api;
}

$req = $_REQUEST["query"];
$trans = get_from_youdao($req)['translation'];
$m = "";
foreach ($trans as $t) {
    if ($m != "") $m .= "<br>";
    $m .= $t;
}
echo json_encode([$m], 384);