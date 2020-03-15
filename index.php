<?php
session_start();
if (isset($_SESSION['auth'])) {
    header("Location: /main");
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    ?>
    <script src="/static/js/jquery-1.7.2.min.js" type="text/javascript"></script>
    <script src="/static/js/login.js" type="text/javascript"></script>
    <script>userLogin('<?=addslashes($_POST['logname'])?>', '<?=addslashes(md5(md5($_POST['logpass']).'Yohane'))?>');</script>
    <?php
} else {
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta content="black-translucent" name="apple-mobile-web-app-status-bar-style">
    <link rel="apple-touch-icon" sizes="114x114" href="/static/icon.jpg">
    <link rel="icon" sizes="114x114" href="/static/icon.jpg">
    <meta name="mobile-web-app-capable" content="yes">
<title>Unnamed</title>
<link rel="stylesheet" href="/static/css/login.css">
<link rel="icon" href="/static/icon.jpg" />
</head>
<body>

<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>

<div class="xwbox">
	<h3>Login</h3>
	<form action="#" id="log1n" name="f" method="post">
		<div class="input_outer">
			<span class="u_user"></span>
			<input name="logname" class="text" onFocus=" if(this.value=='User') this.value=''" onBlur="if(this.value=='') this.value='User'" value="User" style="color: #FFFFFF !important" type="text">
		</div>
		<div class="input_outer">
			<span class="us_uer"></span>
			<label class="l-login login_password" style="color: rgb(255, 255, 255);display: block;">Password</label>
			<input name="logpass" class="text" style="color: #FFFFFF !important; position:absolute; z-index:100;" onFocus="$('.login_password').hide()" onBlur="if(this.value=='') $('.login_password').show()" value="" type="password">
		</div>
		<div class="mb2"><a class="act-but submit" href="#" onclick="document.getElementById('log1n').submit()" style="color: #FFFFFF">登录</a></div>
		<!--<input name="savesid" value="0" id="check-box" class="checkbox" type="checkbox"><span>记住用户名</span>-->
	</form>
	<div class="sas">
		<p style="margin:15px 0px 15px 0px"><a href="/register">注册</a></p>
		<p style="margin:15px 0px 15px 0px"><a style="color:#FF6100" href="http://qm.qq.com/cgi-bin/qm/qr?k=YWmZRNqLdjpQ-ayCRHZsPOEXH06k9pYY">欢迎加入我们的英语学习交流群！</a></p>
	</div>
	
</div>

</body>
</html>

<?php
}