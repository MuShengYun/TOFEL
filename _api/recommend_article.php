<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-4-12
 * Time: 20:35
 */

header('Content-type: application/json');

include_once 'requests.php';
include_once 'check_referer.php';
include_once '../SQLC.php';

function txts($t) {
    if(file_exists($t)){
        $fp = fopen($t,"r");
        $str = fread($fp, filesize($t));//指定读取大小，这里把整个文件内容读取出来
        fclose($fp);
        return $str;
    }
    return '读取文本失败';
}

function commas($arr) {
    if (!is_array($arr)) return $arr;
    $comma = false; $str = '';
    foreach ($arr as $a) {
        if ($comma == false) $comma = true; else $str .= ",";
        $str .= $a;
    }
    return $str;
}

function get_ti($ids) {
    global $dbh;
    $ids = intval($ids);
    $sql = 'SELECT * FROM `tb_col` where `news_id` = '.$dbh->_T($ids);
    $rs = $dbh->query($sql);
    if (!isset($rs[0])) return 'No Title';
    return $rs[0]['news_title'];
}

function deal_words($ids, $need = [0]) {
    global $dbh;
    $sql = 'SELECT * FROM `wordlist` where id in('.commas($ids).')';
    $rs = $dbh->query($sql);
    if (isset($rs[0])) {
        $arr = [];
        foreach ($rs as $i => $v) {
            $json = json_decode($v['json'], 1);
            $explains = commas($json['response']['explains']);
            $arr[] = array(
                'id' => $v['id'],
                'word' => $v['word'],
                'diff' => $v['word_difficulty'],
                'expl' => $explains,
                'dt' => $need[$i]
            );
        }
        return $arr;
    } else {
        return null;
    }
}

$auth = isset($_SESSION['auth']) ? $_SESSION['auth'] : -1;
if ($auth < 0) {
    $res = array(
        'code' => 10000,
        'message' => "auth required"
    );
    die(json_encode($res, 384));
}

$uid = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : -1;

if ($uid !== -1) {
    $dbh = new SQLC();
    $sql = 'SELECT * FROM `user_level` WHERE `uid` = '.$dbh->_T($uid);
    $rs = $dbh->query($sql);
    if (isset($rs[0])) {
        for ($i = 1; $i <= 3; $i++) {
            $p = $rs[0]['article'.$i] = json_decode($rs[0]['article'.$i], 1);
            $deal['wrong'] = deal_words($p[0][1]);
            $array = $need = [];
            foreach ($p as $pp) { $array[] = $pp[3]; $need[] = $pp[5]; }
            $deal['new'] = deal_words($array, $need);
            if (isset($rs[0]['article'.$i][0][0])) {
                $passage[$i] = iconv("GB2312","UTF-8//IGNORE", txts('/var/www/html/static/txt/'.$rs[0]['article'.$i][0][0]));
                $title[$i] = get_ti($rs[0]['article'.$i][0][0]);
            } else {
                $passage[$i] = 'no';
                $title[$i] = '...';
            }
            $rs[0]['article'.$i] = $deal;
        }
        $res = array(
            'code' => 0,
            'message' => "success",
            'result' => array(
                array( "title" => $title[1], "info" => $rs[0]['article1'] , 'article' => array_values(array_filter(explode("\r\n", $passage[1]))) ),
                array( "title" => $title[2], "info" => $rs[0]['article2'] , 'article' => array_values(array_filter(explode("\r\n", $passage[2]))) ),
                array( "title" => $title[3], "info" => $rs[0]['article3'] , 'article' => array_values(array_filter(explode("\r\n", $passage[3]))) )
            )
        );
//        print_r($res);
        echo json_encode($res, 384);
    } else {
        $res = array(
            'code' => 1000,
            'message' => "没有文章推荐"
        );
        die(json_encode($res, 384));
    }
} else {
    $res = array(
        'code' => 20000,
        'message' => "登录丢失，请重新登录"
    );
    die(json_encode($res, 384));
}