<?php
session_start();

function exceptHandle($errno, $errmsg, $filename, $linenum, $vars) {
    global $sql;
    $errortype = array (
        E_ERROR              => 'Error',
        E_WARNING            => 'Warning',
        E_PARSE              => 'Parsing Error',
        E_NOTICE             => 'Notice',
        E_CORE_ERROR         => 'Core Error',
        E_CORE_WARNING       => 'Core Warning',
        E_COMPILE_ERROR      => 'Compile Error',
        E_COMPILE_WARNING    => 'Compile Warning',
        E_USER_ERROR         => 'User Error',
        E_USER_WARNING       => 'User Warning',
        E_USER_NOTICE        => 'User Notice',
        E_STRICT             => 'Runtime Notice',
        E_RECOVERABLE_ERROR  => 'Catchable Fatal Error'
    );
    $fname = explode('\\', $filename);
    $fname = end($fname);
    $res = array(
        'code' => 20000,
        'message' => '【服务器提出了一个问题】'
            ."\n错误种类：".$errortype[$errno]
            ."\n错误信息：".$errmsg
            ."\n错误文件：".$fname
            ."\n错误行数：".$linenum
            // ."\nsql：".$sql
    );
    die(json_encode($res, 384));
    return;
}
set_error_handler("exceptHandle");
set_exception_handler("exceptHandle");

function strget($str,$str1,$str2=null){
    if($str1!=null) $str0=substr($str,strpos($str,$str1)+strlen($str1)); else $str0=$str;
    if($str2!=null) $str0=substr($str0,0,strpos($str0, $str2));
    return trim($str0);
}

function prefix($msg, $S) {
    if (strpos($msg, $S) === 0) return strget($msg, $S);
    return false;
}

function getContents($url,$post='',$cookie='', $returnCookie=0, $retries = 5) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)');
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
    curl_setopt($curl, CURLOPT_REFERER, "http://zixi.pw/yohanebot");
    if ($post) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
    }
    if ($cookie) {
        curl_setopt($curl, CURLOPT_COOKIE, $cookie);
    }
    curl_setopt($curl, CURLOPT_HEADER, $returnCookie);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	aaa: 
	$data = curl_exec($curl);
	$retries--;
    if (curl_errno($curl)) {
		if ($retries <= 0)
			return 'Error('.curl_errno($curl).'): '.curl_error($curl);
		else
			goto aaa;
    }
    curl_close($curl);
    if($returnCookie){
        list($header, $body) = explode("\r\n\r\n", $data, 2);
        preg_match_all("/Set\-Cookie:([^;]*);/", $header, $matches);
        $info['cookie']  = substr($matches[1][0], 1);
        $info['content'] = $body;
        return $info;
    }else{
        return $data;
    }
}

function beautify_html($html){
    $tidy_config = array(
        'clean' => false,
        'indent' => true,
        'indent-spaces' => 4,
        'output-xhtml' => false,
        'show-body-only' => false,
        'wrap' => 0
    );
    if(function_exists('tidy_parse_string')){
        $tidy = tidy_parse_string($html, $tidy_config, 'utf8');
        $tidy -> cleanRepair();
        return $tidy;
    }
    else return $html;
}
