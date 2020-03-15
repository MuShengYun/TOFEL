<?php
header('Content-type: application/json');

include_once 'requests.php';
include_once 'check_referer.php';
include_once '../SQLC.php';



$uname = trim($_REQUEST['uname']);
if (strlen($uname) > 15) {
    $res= array(
        'code' => 4000,
        'message' => 'Too long username.'
    );
    die(json_encode($res, 384));
}
$upass = md5(md5(trim($_REQUEST['upass']))."Yohane");
$uauth = 0;
$inv_code = (strlen($_REQUEST['invite']) > 0) ? trim($_REQUEST['invite']) :mt_rand(100000, 999999);
$unick = trim($_REQUEST['nick']);
$user_qq = trim($_REQUEST['qq']);
$user_school = trim($_REQUEST['school']);

$dbh = new SQLC();

// check_invite_code();
/*$url = 'http://seuxw.cc/api/curri.php?stunum='.$inv_code;
$rs = json_decode(getContents($url), 1);
if (!isset($rs['info'])) {
    $res= array(
        'code' => 3000,
        'message' => 'Wrong invite code.'
    );
    die(json_encode($res, 384));
}*/
$sql = 'SELECT * FROM `users` WHERE `invite_code` = '.$dbh->_T($inv_code).' or `uname` = '.$dbh->_T($uname).'
 or `reg_ip` = '.$dbh->_T($IP);
$rs = $dbh->query($sql);
if (isset($rs[0])) {
    $res = array(
        'code' => 1000,
        'message' => 'You have already registered or the user name was used.'
    );
    die(json_encode($res, 384));
}
//

$sql = 'insert into `users` values (null, '.$dbh->_T($uname).', '.$dbh->_T($upass).', 
'.$dbh->_T($uauth).', '.$dbh->_T($inv_code).', '.$dbh->_T($IP).', '.$dbh->_T(time()).')';
$dbh->query($sql);
$sql = 'SELECT max(uid) as `rs` FROM `users`';
$uid = $dbh->query($sql)[0]['rs'];
$sql = 'replace into `user_info` values('.$dbh->_T($uid).', '.$dbh->_T($unick).', '.$dbh->_T($user_qq).', '.$dbh->_T($user_school).')';
$dbh->query($sql);

$res = array(
    'code' => 0,
    'message' => '注册成功.'
);
exit(json_encode($res, 384));