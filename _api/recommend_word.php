<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-4-12
 * Time: 21:10
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

$auth = isset($_SESSION['auth']) ? $_SESSION['auth'] : -1;
if ($auth < 0) {
    $res = array(
        'code' => 10000,
        'message' => "auth required"
    );
    die(json_encode($res, 384));
}

$uid = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : -1;

$hour = intval(date("H"));

if ($uid !== -1) {
    $dbh = new SQLC();
    $sql = 'SELECT * FROM `user_recomwd` WHERE `uid` = '.$dbh->_T($uid);
    $rs = $dbh->query($sql);
    if (isset($rs[0])) {
        $sim_uid = json_decode($rs[0]['sim_uid'], 1);
        $recomwd = json_decode($rs[0]['recom_wd'], 1);
        // $sql = 'SELECT `user_info`.uid, `user_info`.nick, `user_info`.qq, `user_info`.school, `user_word_inf`.c, `user_word_inf`.a, `user_word_inf`.wrd FROM (`user_info` left join `user_word_inf` on `user_info`.uid = `user_word_inf`.uid) WHERE `user_info`.`uid` IN ('.commas($sim_uid).')';
        $sql = 'select `word`, `json`, `cnt`, `use_time`, `word_difficulty` from `user_mistake_stat` where `uid` in ('.commas($sim_uid).') order by `cnt` desc, `use_time` desc limit 5';
        $ps = $dbh->query($sql);
        foreach ($ps as $i => $v) {
            $json = json_decode($ps[$i]['json'], 1);
            $explains = commas($json['response']['explains']);
            $ps[$i]['expl'] = $explains;
            $ps[$i]['use_time'] = sprintf("%.3f", $ps[$i]['use_time']);
            unset($ps[$i]['json']);
        }
        $sql = 'SELECT * FROM `wordlist` WHERE `id` IN ('.commas($recomwd).')';
        $recomwd = $dbh->query($sql);
        if (isset($recomwd[0])) {
            foreach ($recomwd as $k => $v) {
                // 处理单词释义部分
                $decode = json_decode($v['json'], 1);
                $explain = '';
                foreach ($decode['response']['explains'] as $r) {
                    $explain .= $r.";";
                }
                $cnt_sen = count($decode['sentence']);
                if ($cnt_sen > 0) {
                    $z = (intval($k) + $hour) % $cnt_sen;
                    $recomwd[$k]['sentence'] = $decode['sentence'][$z];
                    $recomwd[$k]['sentence']['eng'] = str_replace($recomwd[$k]['sentence']['needle'], '<hli>'.$recomwd[$k]['sentence']['needle'].'</hli>', $recomwd[$k]['sentence']['eng']);
                } else {
                    $recomwd[$k]['sentence'] = array(
                        'eng' => $v['word'],
                        'chn' => $explain,
                        'needle' => $v['word']
                    );
                }
                unset($recomwd[$k]['json']);
                $recomwd[$k]['explain'] = $explain;
            }
        }
        $res = array(
            'code' => 0,
            'message' => "success",
            'result' => array(
                'similar_user' => $ps,
                'recommend_word' => $recomwd
            )
        );
        echo json_encode($res, 384);
    } else {
        $res = array(
            'code' => 1000,
            'message' => "没有单词推荐"
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