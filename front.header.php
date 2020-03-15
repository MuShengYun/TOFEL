<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $username = $_SESSION['username'];
    $uid = $_SESSION['user_id'];
} else {
    $username = 'Not Login';
    $uid = 0;
}
$menu_button = [
        ['/status', '状态'],
        ['/ranklist', '排行榜'],
        ['/mistake', '错题']
];
?>
<!DOCTYPE html>
<html style="width: 100%;overflow-x: hidden;overflow-y: hidden" ng-app="myApp">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?=$title ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta content="black-translucent" name="apple-mobile-web-app-status-bar-style">
    <link rel="apple-touch-icon" sizes="114x114" href="/static/icon.jpg">
    <link rel="icon" sizes="114x114" href="/static/icon.jpg">
    <meta name="mobile-web-app-capable" content="yes">
    <link href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="/static/css/main.css" rel="stylesheet">
    <link href="/static/css/buttons.css" rel="stylesheet">
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="/static/js/main.js"></script>
</head>
<?php
if (!isset($_SESSION['background-pic']))
	echo '<body>';
else 
	echo '<body style="background: url(\''.base64_decode($_SESSION['background-pic']).'\') fixed center;">';
?>
<nav class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
        <a class="navbar-brand" href="/" id="navtitle">悄悄贝单词</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
            <li><a href="#" onclick="_locate('/list')">List</a></li>
            <li><a href="#" onclick="_locate('/status')">Status</a></li>
            <li><a href="#" onclick="_locate('/article')">Article</a></li>
            <li><a href="#" onclick="_locate('/newword')">Word</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Tools<strong class="caret"></strong></a>
                <ul class="dropdown-menu">
                    <li><a href="#" onclick="_locate('/tpo')">TPO Dictation</a></li>
                </ul>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=$username?><strong class="caret"></strong></a>
                <ul class="dropdown-menu">
                    <li><a href="#" onclick="_locate('/user/<?=$uid?>')">UID: <?=$uid?></a></li>
                    <li><a href="#" onclick="_locate('/settings')">账号设置</a></li>
                    <li><a href="#" onclick="_locate('/addwordlist')">创建单词列表</a></li>
                    <li class="divider"></li>
                    <li><a href="#+" onclick="logout()">登出</a></li>
                </ul>
            </li>
<!--            <li><a href="#">？？</a></li>-->
        </ul>
    </div>
</nav>