<?php
$title = 'Register';
include 'front.header.php';
?>
<script src="/static/js/register.js"></script>

<div class="mainform ur">
    <p>
        <span>用户名：</span>
        <input type="text" id="uname" />
    </p>
    <p>
        <span>密码：</span>
        <input type="text" id="upass" />
    </p>
    <p>
        <span>邀请码：</span>
        <input type="text" id="invc" />
		<span>* 填写你在东南大学的学号</span>
    </p>
    <p>
        <span>昵称：</span>
        <input type="text" id="unick" />
    </p>
    <p>
        <span>QQ：</span>
        <input type="text" id="qqq" />
    </p>
    <p>
        <span>学校：</span>
        <input type="text" id="school" />
    </p>
    <p><a id="reg" href="#" class="button button-royal button-pill button-large" onclick="reg()">注册</a></p>
</div>