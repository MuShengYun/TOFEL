<?php
$title = 'Add_Word_List';
include 'front.header.php';
if ($_SESSION['auth'] < 10) {
    echo '<script>alert("对不起，你没有权限，请先多多背单词，提高用户等级~");</script>';
    header("Location: /main");
}
?>
<script src="/static/js/wordlist.js"></script>

<div class="mainform ur">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12 column">
                <div class="tabbable" id="tabs-106758">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#panel-470135" data-toggle="tab">Information</a></li>
                        <li><a href="#panel-218563" data-toggle="tab">WordLists</a></li>
                        <li><a href="#panel-191919" data-toggle="tab">Help</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="panel-470135">
                            <div class="form-group">
                                <label for="lname" class="col-sm-2 control-label">List Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="lname"
                                           placeholder="Add List Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="lcate" class="col-sm-2 control-label">List Category</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="lcate"
                                           placeholder="Add List Category">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="panel-218563">
                            <p>You just need input the words under here. </p>
                            <div class="col-sm-6">
                                <p style="">
                                    <input id="inputword" type="text" style="border:1px;background:none;font-size:210%" onkeydown="if(event.keyCode==13) getword($('#inputword').val());" />
                                    <a href="#" class="button button-highlight button-pill button-large" onclick="getword($('#inputword').val())">Add</a>
                                </p>
                                <div id="wordlist">
                                    <table class="table table-striped">
                                        <tbody id="lists" class="hidden-md hidden-sm hidden-xs">
                                        <tr>
                                            <td>1</td>
                                            <td>word</td>
                                            <td>Del</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-sm-6" style="overflow-y:scroll">
                                <p>
                                    <span id="words" style="font-size:220%">word</span>
                                    <span id="word2" style="font-size:150%">/音标/</span>
                                </p>
								<p id="word_audio"></p>
                                <p style="font-size:140%">>>> 解释</p>
                                <div id="meanings" style="font-size:110%">
                                    单词释义。
                                </div>
                                <p style="font-size:140%">>>> 例句</p>
                                <div id="sentences" style="font-size:110%">
                                    单词例句。
                                </div>

                            </div>
                            <a href="#" class="button button-highlight button-pill button-large" onclick="create_wordlist()">确认添加</a>
                        </div>
                        <div class="tab-pane" id="panel-191919">
                            <p>Help</p>
                            <p>因为获取英文释义需要连接外网，故我们无法第一时间给出英文释义，如需测试英译英，请等待20分钟。</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>