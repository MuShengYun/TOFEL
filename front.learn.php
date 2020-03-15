<?php
$title = 'Learning';
include 'front.header.php';
if (!isset($_SESSION['auth'])) {
    header("Location: /");
}
?>
<style>
    #nowprobid {text-shadow: 0px 0px 2px #e00;}
    #probcate {text-shadow: 0px 0px 2px #00f;}
    #nowtime {text-shadow: 0px 0px 2px #f0f;}
</style>
<script>var lid = <?=intval($_REQUEST['lid'])?>; 
</script>

<script src="/static/js/learn.js"></script>

<div class="mainform ur">
    <div class="col-md-12">
        <h4>Spell the words you hear,try to learn them!</h4>
        <p> Word <b id="nowprobid">1</b> / <span id="totalprobid">50</span>　　<span id="nowtime">00:00</span></p>
    </div>
    <div class="col-md-6" id="resulto">
		<input hidden id="inputword" type="text" style="border-radius:1px;background:none;font-size:210%" onkeydown="if(event.keyCode==13) _check($('#inputword').val());" />
        <p id="word_audio"></p>
        <p id="restart"><a href="#" id="start_button" class="button button-royal button-pill button-large" onclick="dictation(0)">开始</a></p>
		<p hidden id="replays"><a href="#" id="start_button" class="button button-warning button-pill button-large" onclick="replay()">Replay</a></p>
		<div id="wordlist">
             <table class="table table-striped">
                 <tbody id="lists" class="hidden-sm hidden-xs">
                 
                 </tbody>
             </table>
        </div>
    </div>
    <div class="col-md-6">
        <p>
            <span id="words" style="font-size:220%">word</span>
            <span id="word2" style="font-size:150%">/音标/</span>
        </p>
        <p id="diff"></p>
        <p style="font-size:140%">>>> 解释</p>
        <div id="meanings" style="font-size:110%">
            单词释义。
        </div>
        <div id="meanings_en" style="font-size:110%">
            英文释义（如果有）。
        </div>
        <p style="font-size:140%">>>> 例句</p>
        <div id="sentences" style="font-size:110%">
            单词例句。
        </div>
    </div>
</div>