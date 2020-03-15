<?php
$title = '';
$user_id = intval($_REQUEST['user_id']);
include 'front.header.php';
?>

<script>
var my_uid = <?=$uid?>;
var user_id = <?=$user_id?>;
</script>
<script src="/static/js/userpage.js"></script>

<div class="mainform ur">
    <div class="media">
		<div class="media-left media-top">
		    <img id="avatar" src="//q2.qlogo.cn/headimg_dl?bs=11205841&dst_uin=11205841&dst_uin=11205841&;dst_uin=11205841&spec=100&url_enc=0&referer=bu_interface&term_type=PC" class="media-object" style="width:180px">
		</div>
		<div class="media-body">
		  <h2 class="media-heading" id="nickname">昵称</h2>
		  <p id="school">学校：</p>
		  <p id="regtime">注册时间：</p>
		  <p id="logtime">最后登录：</p>
		  <p id="x">平均做题时间： <span id="avgt">99999</span> s    最快做题时间： <span id="mint">99999</span> s</p>
		</div>
    </div>
</div>