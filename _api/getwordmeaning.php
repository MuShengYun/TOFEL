<?php
header('Content-type: application/json');
include_once 'requests.php';

function get_from_youdao($word) {
    $url = 'http://m.youdao.com/dict?le=eng&q='.$word;
    $return = getContents($url);
    $return = strget($return, "<div id=\"ec_contentWrp\" class=\"content-wrp dict-container opened\">", "</ul>");
    if(preg_match_all("/<li>.*?<\/li>/", $return, $matches)){
        $res = [];
        foreach ($matches[0] as $r) {
            $res[] = strip_tags($r);
        }
        return $res;
    }else{
        return [];
    }
}

function collins ($word) {
    $url = 'http://m.youdao.com/singledict?q='.$word.'&dict=collins&le=eng&more=false';
    $return = getContents($url);
    $regex4 = "/<div class=\"col2\".*?>.*?<\/div>/ism";
    if(preg_match_all($regex4, $return, $matches)){
        $res = [];
        foreach ($matches[0] as $r) {
            $res[] = substr(preg_replace("/\\s\\s+/","<br>", strip_tags($r)), 4);
        }
        return $res;
    }else{
        return [];
    }
}

function webster($word) {
    $url = 'https://www.merriam-webster.com/dictionary/' . trim($word);
    preg_match_all("/<div class=\"sense .*?\".*?>(?>[^<\/div>]+|(?R))*<\/div>/is", getContents($url), $match);
    $res = [];
    foreach ($match[0] as $t) {
        $mean = trim(strip_tags($t/*strget($t, 'class="mw_t_bc">', "\n")*/));
        $con = preg_replace("/\s(?=\s)/", "\\1", $mean);
        $con = preg_replace("/([\s\S]*?):([\s\S]*)/", "<b style='font-size:120%'>\\1</b>: \\2", $con);
        if(strlen($con) > 0) $res[] = $con;
    }
    $res = array_unique($res);
    return $res;
}

$word = isset($_REQUEST["word"])?trim($_REQUEST["word"]):"";
if ($word == "") {
    exit("[]");
}
$res = [];
$youdao = get_from_youdao($word);
$res["youdao"] = $youdao;
$res["collins"] = collins($word);
$res["webster"] = array_values(webster($word));
echo json_encode($res, 384);
?>