<?php
$title = 'Word List';
include 'front.header.php';
if (!isset($_SESSION['auth'])) {
    header("Location: /");
}
?>

<style>
    .ta {
        color: white;
        margin: 10px;
        height:
    }
    .ta:hover {
        color: white;
        background: rgba(0, 0, 0, 1);
    }
    .ta:active {
        color: yellow;
        background: rgba(0, 0, 0, 1);
    }
    .ta:visited {
        color: yellow;
        background: rgba(0, 0, 0, 1);
    }
    .selection {
        height: 120px;
        font-size: 100%;
        background: rgba(0, 0, 0, 0.6);
        background-size: cover;
        border-radius: 8px;
        margin:0 auto;
        padding: 7px;
    }
</style>
<script>var my_uid = <?=$uid?>;</script>
<script src="/static/js/lists.js"></script>

<div class="mainform ur">
    <h3>Start learning and Testing English Words Here!</h3>
    <h4>If you want to add word lists, please contact us~<br>(如果你想加自己的单词list，可以<a style="color:#FF6100" href="http://qm.qq.com/cgi-bin/qm/qr?k=YWmZRNqLdjpQ-ayCRHZsPOEXH06k9pYY">私我</a>，我给你权限加)</h4>
    <div hidden class="col-md-12" id="opers"></div>
    <div class="col-md-12" id="lists"></div>
</div>