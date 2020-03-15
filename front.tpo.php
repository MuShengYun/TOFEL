<?php
$title = 'TPO 听写(实验性)';
include 'front.header.php';
?>
<script>
    function rsz() {
        $("#superlearn").css("height", ($(document).height() - 150) + "px");
        $("#superlearn").css("width", ($("#slearn").width() - 5) + "px");
        $(".inp").css("height", (($(document).height() - 150) / 2) + "px");
        $(".inp").css("width", ($("#dictation").width() - 5) + "px");
    }
    function cmp() {
        $.post("/api/word_chg", {"f" : $("#f1").val(), "l" : $("#l1").val()}, function (dt) {
            if (dt.code !== 0) { alert(dt.message); return; }
            $("#v3").html(dt.message);
            $('#area1').hide(200);$('#area2').show(200);
        }, 'json');
    }
    $(document).resize(rsz);
    $(document).ready(rsz);
    $("#superlearn").load(function() {
        $("#superlearn").contents().find('body').html($("#superlearn").contents().find('body').html().replace("target=\"_blank\"", ''));
        // alert("Loading");
    });
</script>
<link href="/static/css/tpo.css" rel="stylesheet">
<div class="mainform ur">

    <div class="col-xs-9" id="dictation">
        <div id="area1">
            <textarea id="f1" class="inp" style="font-size: 150%;resize: none;border:0">听写内容，右边的一句一行。</textarea>
            <textarea id="l1" class="inp" style="font-size: 150%;resize: none;border:0">复制右边全文内容到这里</textarea>
            <div id="v1"><button style="btn btn-default" onclick="cmp()">提交</button> </div>
        </div>
        <div hidden id="area2">
            <div id="v2">
                <button style="btn btn-default" onclick="$('#area1').show(200);$('#area2').hide(200);">返回</button>
                <span>懒得造轮子了。https://github.com/chrisboulton/php-diff/releases</span>
            </div>
            <div id="v3"></div>
        </div>
    </div>
    <div class="col-xs-3" id="slearn">
        <h4>superLearn界面：<input type="text" id="url" onkeydown="if(event.keyCode===13) $('#superlearn').attr('src', $('#url').val());"/></h4>
        <iframe id="superlearn" src="https://www.superlearn.com/practice/base/listen/alltpo.shtml" frameborder="0" height="100%"></iframe>
    </div>
</div>