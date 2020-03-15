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
    .btm {
        z-index: 9999; position: fixed ! important; right: 10px; bottom: 10px; border-radius: 16px; background-color: white;
        width: 32px; height: 32px; color: black; box-shadow: 4px 4px 10px 0px black; cursor: pointer; line-height: 32px; text-align: center;
    }
</style>
<script>var list_id = <?=intval($_REQUEST['lid'])?>;
</script>

<script src="/static/js/word_check.js"></script>
<script src="/static/js/quiz.resize.js"></script>

<div class="btm shown_SM" onclick="$('#identifier').modal()">
    ?
</div>

<div class="mainform ur">
    <div class="col-md-12">
        <h4>Let Us Learn New Words!</h4><h5 hidden id="timeoutinfo">选择时间超过6s，计入错词行列！</h5>
        <p> Word <b id="nowprobid">1</b> / <span id="totalprobid">50</span>　　<span id="nowtime">00:00</span></p>
    </div>
    <div class="col-md-6" id="resulto">
		<p id="restart"><a href="javascript:void(0);" id="start_button" class="button button-royal button-pill button-large" onclick="start_learn()">开始</a></p>
		<p hidden id="gotest"><a href="javascript:void(0);" id="test_button" class="button button-royal button-pill button-large" onclick="go_test()">测试</a></p>
		<div id="wordlist">
             <table class="table table-striped">
                 <tbody id="lists" class="">

                 </tbody>
             </table>
        </div>
        <p id="word_audio"></p>
        <div hidden id="quizpanel">
            <div style="height: 110px; text-align: center; overflow-y: scroll">
                <h2 id="quizTitle">word</h2>
            </div>
            <div id="choicelist" class="col-md-12">
                <div class="col-sm-12">
                    <a id="C0" href="javascript:void(0);" class="button button-caution button-pill button-large" style="margin: 1px; font-size:110%;width:100%;overflow: hidden">
                        Choice 1
                    </a>
                </div>
                <div class="col-sm-12">
                    <a id="C1" href="javascript:void(0);" class="button button-caution button-pill button-large" style="margin: 1px; font-size:110%;width:100%;overflow: hidden">
                        Choice 2
                    </a>
                </div>
                <div class="col-sm-12">
                    <a id="C2" href="javascript:void(0);" class="button button-caution button-pill button-large" style="margin: 1px; font-size:110%;width:100%;overflow: hidden">
                        Choice 3
                    </a>
                </div>
                <div class="col-sm-12">
                    <a id="C3" href="javascript:void(0);" class="button button-caution button-pill button-large" style="margin: 1px; font-size:110%;width:100%;overflow: hidden">
                        Choice 4
                    </a>
                </div>
                <div class="col-sm-12">
                    <a id="C4" href="javascript:void(0);" class="button button-caution button-pill button-large" style="margin: 1px; font-size:110%;width:100%;overflow: hidden">
                        Choice 5
                    </a>
                </div>
                <div class="col-sm-12">
                    <a id="C5" href="javascript:void(0);" class="button button-caution button-pill button-large" style="margin: 1px; font-size:110%;width:100%;overflow: hidden">
                        Choice 6
                    </a>
                </div>

            </div>
        </div>
    </div>
    <div class="col-md-6 shown_PC">
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
