<?php
header('Content-type: application/json');

include_once 'requests.php';
include_once 'check_referer.php';
include_once '../SQLC.php';


// error_reporting(0);

function get_meaning($id) {
    global $dbh;
    $rs = $dbh->query('SELECT * FROM `words_meaning` where `word_id` = '.$dbh->_T($id).' and `meaning`  NOT LIKE \'%人名%\' and `meaning`  NOT LIKE \'%姓%\'');
    $s = [];
    if (!is_array($rs)) return false;
    foreach ($rs as $t) {
        $s[] = $t['meaning'];
    }
    shuffle($s);
    return $s;
}

function get_meaning_en($id) {
    global $dbh;
    $rs = $dbh->query('SELECT * FROM `words_meaning_en` where `word_id` = '.$dbh->_T($id).' order by rand()');
    $s = [];
    if (!is_array($rs)) return false;
    foreach ($rs as $t) {
        $s[] = $t['mean'];
    }
    return $s;
}

function rangeC($cnt, $exc, $all) {
    $arr = range(0, $all - 1);
    unset($arr[$exc]);
    shuffle($arr);
//    sort($arr);
    $arr = array_slice($arr, 0, $cnt);
    return $arr;
}

function sentences($id) {
    global $dbh;
    $rs = $dbh->query('SELECT * FROM `words_sentence` WHERE `word_id` = '.$dbh->_T($id));
    if (!isset($rs[0])) return false;
    $cnts = count($rs);
    $ind = mt_rand(0, $cnts - 1);
    return $rs[$ind];
}

$list_id = intval($_REQUEST['lid']);
$uid = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : -1;
$limited = isset($_REQUEST['limited']) ? intval($_REQUEST['limited']) : 0;
$dbh = new SQLC();
$sql = 'SELECT * FROM `problems` where `time_start` > '.(time() - 120).' and uid = '.$uid." and use_list = ".$dbh->_T($list_id);
$rs = $dbh->query($sql);
$_SESSION['now_tid'] = 0;
if (file_exists("../user_settings/quiz/".$uid.".json")) {
    $settings = json_decode(file_get_contents("../user_settings/quiz/".$uid.".json"), 1);
}
$ec_cnt =  isset($settings['settings']['ec']) ? $settings['settings']['ec'] : 5;
$ce_cnt = isset($settings['settings']['ce']) ? $settings['settings']['ce'] : 5;
$ee_cnt = isset($settings['settings']['ee']) ? $settings['settings']['ee'] : 5;
$sp_cnt = isset($settings['settings']['sp']) ? $settings['settings']['sp'] : 5;
$sel_cnt = isset($settings['settings']['sel']) ? $settings['settings']['sel'] : 5;

if (isset($rs[0])) {
    $quiz_id = $rs[0]['id'];
    $file = '../userquiz_json/quiz_'.$quiz_id.'.json';
    $res = json_decode(file_get_contents($file), 1);
    $_SESSION['quiz_id'] = $quiz_id;
} else {
    $prob = $res = $ans_arr = $nowwordid = [];
	if ($list_id > 0) {
		$sql = 'select * from `words_list` where `id` = '.$dbh->_T($list_id);
		$rs = $dbh->query($sql);
	} else {
		unset($rs);
		$rs = array(); $rs[0]['list_words'] = isset($_REQUEST['wids']) ? $_REQUEST['wids'] : null;
	}
    if (isset($rs[0])) {
        $array = json_decode($rs[0]['list_words'], 1);
        if (is_array($array)) {
            $str = '';
            $comma = false;
            foreach ($array as $r) {
                if ($comma == false) $comma = true; else $str .= ', ';
                $str .= intval($r);
            }
            $sql = 'SELECT `id`, `word` FROM `words` where `id` in (' . $str . ') order by field(`id`, ' . $str . ')';
            $wrd = $dbh->query($sql);
            $cnts = count($wrd);
            if (!is_array($wrd) || count($wrd) < 8) {
                $res = array(
                    'code' => 1000,
                    'message' => '题目生成失败，单词数小于8个。'
                );
                exit(json_encode($res, 384));
            }
            shuffle($wrd);
            $mean = [];
            foreach ($wrd as $wid => $item) {
                $mean[$wid] = get_meaning($item['id']);
            }
            // 英译中题目（选择全部释义）
			$choice_cnt = 0;
            foreach ($wrd as $wid => $item) {
                $choice_cnt++;
                if ($limited != 0 && $choice_cnt > $ec_cnt) break;
                $meaning = $mean[$wid];
                $choices = [];
                $true_ans = [];
                $au = range(0, 7); shuffle($au);
                $randcnt = mt_rand(2, 7);
                if (!isset($meaning[0])) continue;
                for ($i = 0; $i < $randcnt && isset($meaning[$i]); $i++) {
                    $choices[$au[$i]] = $meaning[$i];
                    $true_ans[] = $au[$i];
                }
                $true_ans_cnt = $i;
                for (; $i < 8; $i++) {
                    $mid = $wid;
                    while ($mid == $wid || count($mean[$mid]) < 1) $mid = mt_rand(0, $cnts - 1);
                    $pid = mt_rand(0, count($mean[$mid]) - 1);
                    $choices[$au[$i]] = $mean[$mid][$pid];
                } ksort($choices);
                $prob[] = array(
                    'cate' => 'e_to_c',
                    'problem' => $item['word'],
                    'choices' => $choices,
                    'true_ans_cnt' => $true_ans_cnt
                );
                $ans_arr[] = $true_ans;
                $nowwordid[] = $item['id'];
            }
			
			shuffle($wrd);
            $mean = [];
            foreach ($wrd as $wid => $item) {
                $mean[$wid] = get_meaning($item['id']);
            }

            // 中译英题目。
			$choice_cnt = 0;
            foreach ($wrd as $wid => $item) {
                $choice_cnt++;
                if ($limited != 0 && $choice_cnt > $ce_cnt) break;
                $meaning = $mean[$wid];
                shuffle($meaning);
                if (!isset($meaning[0])) continue;
                $question = $meaning[0];
                if (isset($meaning[1])) $question .= '; ' . $meaning[1];
                if (isset($meaning[2])) $question .= '; ' . $meaning[2];
                $question = str_replace("人名", '...', $question);
                $question = str_replace(strtolower($item['word']), '', strtolower($question));
                $choices = rangeC(4, $wid, $cnts);
                $true_ans = mt_rand(0, 4);
                foreach ($choices as $k => $v) {
                    $choices[$k] = $wrd[$v]['word'];
                }
                array_splice($choices, $true_ans, 0, [$item['word']]);
                $prob[] = array(
                    'cate' => 'c_to_e',
                    'problem' => $question,
                    'choices' => $choices
                );
                $ans_arr[] = $true_ans;
                $nowwordid[] = $item['id'];
            }
			
			shuffle($wrd);
            $mean_en = [];
            foreach ($wrd as $wid => $item) {
                $mean_en[$wid] = get_meaning_en($item['id']);
            }
            
            // 英译英题目。
			$choice_cnt = 0;
            foreach ($wrd as $wid => $item) {
                if (!isset($mean_en[$wid][0])) continue;
                $choice_cnt++;
                if ($limited != 0 && $choice_cnt > $ee_cnt) break;
                $question = $mean_en[$wid][0];
                $choices = rangeC(4, $wid, $cnts);
                $true_ans = mt_rand(0, 4);
                foreach ($choices as $k => $v) {
                    $choices[$k] = $wrd[$v]['word'];
                }
                array_splice($choices, $true_ans, 0, [$item['word']]);
                $prob[] = array(
                    'cate' => 'e_to_e',
                    'problem' => $question,
                    'choices' => $choices
                );
                $ans_arr[] = $true_ans;
                $nowwordid[] = $item['id'];
            }

			shuffle($wrd);
            $mean = [];
            foreach ($wrd as $wid => $item) {
                $mean[$wid] = get_meaning($item['id']);
            }

            // 拼写题目
			$choice_cnt = 0;
            foreach ($wrd as $wid => $item) {
                $choice_cnt++;
                if ($limited != 0 && $choice_cnt > $sp_cnt) break;
                $meaning = $mean[$wid];
                if (!isset($meaning[0])) continue;
                shuffle($meaning);
                $question = $meaning[0];
                if (isset($meaning[1])) $question .= '; ' . $meaning[1];
                if (isset($meaning[2])) $question .= '; ' . $meaning[2];
                $_b = str_split($item['word']);
                sort($_b);
                $prob[] = array(
                    'cate' => 'spell',
                    'problem' => $question,
                    'choices' => $_b
                );
                $ans_arr[] = $item['word'];
                $nowwordid[] = $item['id'];
            }
			
			shuffle($wrd);
            $mean = [];
            foreach ($wrd as $wid => $item) {
                $mean[$wid] = get_meaning($item['id']);
            }
            
            // 单选题
            $choice_cnt = 0;
            foreach ($wrd as $wid => $item) {
                $choice_cnt++;
                if ($choice_cnt > 15 || ($limited != 0 && $choice_cnt > $sel_cnt)) break;
                $stc = sentences($item['id']);
                $en = str_replace($stc['needle'], '______', $stc['en']);
                if (strlen($en) < 1) continue;
                $ch = $stc['ch'];
                $choices = rangeC(4, $wid, $cnts);
                $true_ans = mt_rand(0, 4);
                foreach ($choices as $k => $v) {
                    $choices[$k] = $wrd[$v]['word'];
                }
                array_splice($choices, $true_ans, 0, [$item['word']]);
                $prob[] = array(
                    'cate' => 'choice',
                    'problem' => $en,
                    'choices' => $choices,
                    'chn' => $ch
                );
                $ans_arr[] = $true_ans;
                $nowwordid[] = $item['id'];
            }
        }
        $trueans = json_encode($ans_arr);
        $NWID = json_encode($nowwordid);
        $sql = 'insert into `problems` (`uid`, `use_list`, `word_list`, `true_ans`, `time_start`) values ('.$dbh->_T($uid).', '.$dbh->_T($list_id).', '.$dbh->_T($NWID).', '.$dbh->_T($trueans).', '.$dbh->_T(time()).')';
        // echo $sql; exit;
        $dbh->query($sql);
        $sql = 'select max(`id`) as maxs from `problems`'; $quiz_id = $dbh->query($sql)[0]['maxs'];

        $res = array(
            'code' => 0,
            'message' => 'success',
            'result' => $prob
        );
        $res['quiz_id'] = $quiz_id;
        $json = json_encode($res, 384);
        file_put_contents("../userquiz_json/quiz_$quiz_id.json", $json);
        $_SESSION['quiz_id'] = $quiz_id;
    }
}
echo json_encode($res, 384);