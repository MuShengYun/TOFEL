<?php
$title = 'My Mistakes';
include 'front.header.php';
?>
<script src="/static/js/mistake.js"></script>

<div class="mainform ur">
    <div class="col-md-12">
        <div class="btn-group btn-group-justified">
            <?php
            foreach ($menu_button as $r) {
                ?>
                <a href="javascript:void(0)" class="btn btn-primary" onclick='_locate("<?=addslashes($r[0])?>")'><?=addslashes($r[1])?></a>
                <?php
            }
            ?>
        </div>
    </div>
    <div class="col-md-12">
        <div class="col-md-6">
            <select id="examlist" onchange="loads()">
                <option value ="no" selected="selected">测试时间</option>
            </select>
        </div>
        <div class="col-md-6">
            <select id="probcates" onchange="loads()">
                <option value ="no" selected="selected">问题类型</option>
                <option value ="e_to_c">英译中</option>
                <option value ="c_to_e">中译英</option>
                <option value ="e_to_e">英译英</option>
                <option value ="spell">拼写题</option>
                <option value ="choice">单选题</option>
                <option value ="un_choice">非单选题</option>
            </select>
        </div>
    </div>
    <div class="col-md-6" style="height:90%;overflow-y:scroll">
        <h4>我的近 3 日错词排行：<button class="btn btn-default" onclick="_gotest()">去测试</button></h4>
        <div id="myMis" class="table-responsive"></div>
    </div>
    <div class="col-md-6" style="height:90%;overflow-y:scroll">
        <h4>全网错词排行：</h4>
        <div id="allMis" style="height:90%;overflow-y:scroll"></div>
    </div>
</div>