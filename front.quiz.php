<?php
$title = 'Quiz';
include 'front.header.php';
if (!isset($_SESSION['auth'])) {
    header("Location: /");
}
?>
<style>
    #nowprobid {text-shadow: 0px 0px 2px #e00;}
    #probcate {text-shadow: 0px 0px 2px #00f;}
    #nowtime {text-shadow: 0px 0px 2px #f0f;}
    .btm {
        z-index: 9999; position: fixed ! important; right: 10px; bottom: 10px; border-radius: 16px; background-color: white;
        width: 32px; height: 32px; color: black; box-shadow: 4px 4px 10px 0px black; cursor: pointer; line-height: 32px; text-align: center;
    }
</style>
<script>var lid = <?=intval($_REQUEST['lid'])?>; 
<?php 
	if (isset($_REQUEST['limited']) && $_REQUEST['limited'] == 'true') {
		echo 'var limited = true;';
	} else {
		echo 'var limited = false;';
	}
	if (isset($_REQUEST['custom']) && $_REQUEST['custom'] == 'true') {
		echo 'var is_custom = true;';
		if (isset($_REQUEST['wordlist'])) {
			$jd = explode(",", urldecode(base64_decode($_REQUEST['wordlist'])));
			if (count($jd) > 1) {
				echo 'var wrdlist = "'.addslashes(json_encode($jd)).'";';
			} else {
				echo 'var wrdlist = "no";';
			}
		}
	} else {
		echo 'var is_custom = false;';
	}
?>
</script>
<script src="/static/js/quiz.js"></script>
<script src="/static/js/quiz.resize.js"></script>
<div class="btm shown_SM" onclick="$('#identifier').modal()">
    ?
</div>
<div class="mainform ur">
    <div class="col-md-12">
        <p> Problem <b id="nowprobid">1</b> / <span id="totalprobid">50</span>　　
            Category: <span id="probcate">???</span>　　<span id="nowtime">00:00</span></p>
    </div>
    <div class="col-md-7" id="resulto">
        <div style="height: 180px; text-align: center; overflow-y: scroll">
            <h2 id="quizTitle">QuizTitle</h2>
        </div>
        <div id="choicelist" class="col-md-12">
            <div class="col-sm-6">
                <a href="javascript:void(0);" class="button button-royal button-pill button-large" style="font-size:110%;width:100%;">Choice 1</a>
            </div>
            <div class="col-sm-6">
                <a href="javascript:void(0);" class="button button-caution button-pill button-large" style="font-size:110%;width:100%;">Choice 2</a>
            </div>
            <div class="col-sm-6">
                <a href="javascript:void(0);" class="button button-highlight button-pill button-large" style="font-size:110%;width:100%;">Choice 3</a>
            </div>
            <div class="col-sm-6">
                <a href="javascript:void(0);" class="button button-primary button-pill button-large" style="font-size:110%;width:100%;">Choice 4</a>
            </div>
        </div>

    </div>
    <div class="col-md-5 shown_PC">
    	<div class="col-md-12">
            <h3><span id="comments">PERFECT</span>　　<span id="combos">0</span> Combo</h3>
        </div>
        <p>
            <span id="words" style="font-size:220%">word</span>
            <span id="word2" style="font-size:150%">/音标/</span>
        </p><p id="word_audio"></p>
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
<div class="modal fade" id="identifier" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    单词释义
                </h4>
            </div>
            <div class="modal-body">
                <p>
                    <span id="words_m" style="font-size:220%">word</span>
                    <span id="word2_m" style="font-size:150%">/音标/</span>
                </p>
                <p id="diff_m"></p>
                <p style="font-size:140%">>>> 解释</p>
                <div id="meanings_m" style="font-size:110%">
                    单词释义。
                </div>
                <div id="meanings_en_m" style="font-size:110%">
                    英文释义（如果有）。
                </div>
                <p style="font-size:140%">>>> 例句</p>
                <div id="sentences_m" style="font-size:110%">
                    单词例句。
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>