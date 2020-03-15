<?php
header('Content-type: application/json');

include_once 'requests.php';
include_once 'check_referer.php';
include_once '../SQLC.php';

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

function get_example_sent($word) {
	$url = 'http://m.youdao.com/singledict?q='.$word.'&dict=media_sents_part&le=eng&more=false';
	$res1 = get_example_sent_one($url, $word);
	$url = 'http://m.youdao.com/singledict?q='.$word.'&dict=blng_sents_part&le=eng&more=false';
	$res2 = get_example_sent_one($url, $word);
	// $url = 'http://m.youdao.com/singledict?q='.$word.'&dict=auth_sents_part&le=eng&more=false';
	// $res3 = get_example_sent_one($url, $word);
	return array_merge($res1, $res2);
}

function get_example_sent_one($url, $word) {
	
	$return = getContents($url);
	$regex4 = "/<div class=\"col2\".*?>.*?<\/div>/ism";  
	if(preg_match_all($regex4, $return, $matches)){  
	   $res = [];
	   foreach ($matches[0] as $r) {
	       $con = strget($r, '<p>', '</p>');
		   $eng = strip_tags($con);
		   $needle = strget($con, '<b>', '</b>');
		   $chn = strip_tags(strget($r, '<p class="grey">', '</p>'));
		   $chn .= '('.strip_tags(strget($r, '<span class="secondary">', '</span>')).')';
		   $res[] = array(
				'eng' => $eng, 
				'chn' => $chn,
               'needle' => $needle
		   );
	   }
	   return $res;
	}else{  
	   return [];  
	}
}

function get_diff($w) {
    $dbh2 = new SQLC("coca");
    $sql = 'SELECT `id`, `word` FROM `words_freq` where word = '.$dbh2->_T($w);
    $rs = $dbh2->query($sql);
    if (isset($rs[0])) {
        return intval($rs[0]['id']);
    }
    return -1;
}

$dbh = new SQLC();
$query = trim($_REQUEST['word']);
$sql = 'SELECT * FROM `wordlist` where `word` = '.$dbh->_T($query).' or `id` = '.$dbh->_T($query);
$rs = $dbh->query($sql);
if (isset($rs[0])) {
	$res = json_decode($rs[0]['json'], 1);
	$res['word_id'] = intval($rs[0]['id']);
	$res['message'] = $rs[0]['word'];
	$res['response']['level'] = $rs[0]['word_level'];
	$res['response']['difficulty'] = $rs[0]['word_difficulty'];
    $sql = 'SELECT * FROM `words_meaning_en` where `word_id` = '.$dbh->_T($res['word_id']);
    $rs0 = $dbh->query($sql);
    $res['response']['explains_en'] = [];
    if (isset($rs0[0])) {
        foreach ($rs0 as $r) {
            $res['response']['explains_en'][] = $r['mean'];
        }
    } else {
        $res['response']['explains_en'] = ['因为获取英文释义需要连接外网，故我们无法第一时间给出英文释义，如需测试英译英，请等待20分钟。'];
    }
} elseif ($_SESSION['auth'] >= 10) {
	$api1 = get_from_youdao($query);
	// print_r($api1);
	if (!isset($api1['basic'])) {
		$res = array(
			'code' => 1000,
			'message' => '单词不存在……（'
		);
	} else {
        $save0 = $api1['basic']['explains'];
        $save1 = [];
        foreach ($save0 as $r) {
            $word_cate = strget($r, '', '.');
            $word_exp = str_replace(';', '；', trim(strget($r, '.')));
			if (strstr($word_exp, '人名')) continue;
            $word_exp = explode('；', $word_exp);
            foreach ($word_exp as $T) {
                $save1[] = $word_cate.'. '.$T;
            }
        }
		$res = array(
			'code' => 0,
			'message' => $query,
			'response' => array(
				'phonetic' => isset($api1['basic']['phonetic'])?$api1['basic']['phonetic']:"",
				'explains' => $api1['basic']['explains'],
				'forms' => isset($api1['basic']['wfs']) ? $api1['basic']['wfs'] : []
			),
			'sentence' => []
		);
		$res['sentence'] = $save2 = get_example_sent($query);
		$json = json_encode($res, JSON_UNESCAPED_UNICODE);
		$sql = 'insert into `words` values (null, '.$dbh->_T($query).', '.$dbh->_T($json).')';
		$dbh->query($sql);
		$sql = 'select MAX(id) from words';
		$now_id = $dbh->query($sql)[0]['MAX(id)'];
		if (is_array($save1)) {
			$sql = 'insert into `words_meaning` values '; $comma = false;
			foreach ($save1 as $r) {
				if ($comma == false) $comma = true; else $sql .= ', ';
				$sql .= '(null, '.$dbh->_T($now_id).', '.$dbh->_T($r).')';
			}$dbh->query($sql);
		}
		if (is_array($save2) && count($save2) > 0) {
			$sql = 'insert into `words_sentence` values '; $comma = false;
			foreach ($save2 as $r) {
				if ($comma == false) $comma = true; else $sql .= ', ';
				$sql .= '(null, '.$dbh->_T($now_id).', '.$dbh->_T($r['eng']).', '.$dbh->_T($r['chn']).', '.$dbh->_T($r['needle']).')';
			}$dbh->query($sql);
		}
        $res['word_id'] = intval($now_id);
		$sql = 'insert into `words_extra` values('.$dbh->_T($now_id).', 0, '.$dbh->_T(get_diff($query)).')';
		$dbh->query($sql);
	}

	// https://dict.youdao.com/dictvoice?audio=test&type=2
} else {
    $res = array(
        'code' => 1000,
        'message' => '单词暂未收录，无权查看……（'
    );
}
echo json_encode($res, 384);

