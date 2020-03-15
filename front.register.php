<?php
$title = 'Register';
include 'front.header.php';
?>
<script src="/static/js/register.js"></script>

<div class="mainform ur"  align="center" >
    <p >
        <span  >用户名：</span>
        <input type="text"   id="uname" style="width:150px"/>
    </p>
    <p >
        <span >密码： </span>
        <input type="text" id="upass"  style="width:150px;margin-left:15px"/>
    </p>
    <p >
        <span>邀请码：</span>
        <input type="text" id="invc" placeholder="内测期间无需邀请码，随便写。" style="width:150px" />
    </p>
    <p>
        <span> 昵称： </span>
        <input type="text" id="unick" style="width:150px;margin-left:15px"/>
    </p>
    <p>
        <span>QQ：</span>
        <input type="text" id="qqq"  style="width:150px;margin-left:21px"/>
    </p>
    <p>
        <span >学校： </span>
        <input type="text" id="school" style="width:150px;margin-left:15px" />
    </p>
    <p>* 内测期间无需邀请码，如果注册失败只需随意填写。</p>
    <p align="center"><a id="reg" href="#" class="button button-royal button-pill button-large" onclick="reg()">注册</a></p>
</div>