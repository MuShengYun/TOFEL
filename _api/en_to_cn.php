<?php
include_once 'baidu_transapi.php';

header('Content-type: application/json');

try {
	$arr = translate('don\'t gay', 'en', 'zh');
	print_r($arr);
} catch (Error $e) {
	$fname = $e->getFile();
    $res = array(
        'code' => 20000,
        'message' => '【服务器提出了一个问题】'
            ."\n错误种类：Error"
            ."\n错误信息：".$e->getMessage()
            ."\n错误文件：".$fname
            ."\n错误行数：".$e->getLine()
            ."\n你可以复读这条消息给子曦（"
    );
}