<?php
$title = 'RankList';
include 'front.header.php';
if (!isset($_SESSION['auth'])) {
    header("Location: /");
}
?>
<script>var my_uid = <?=$uid?>;</script>
<script src="/static/js/rklist.js"></script>

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
    <div class="col-md-6" style="height:90%;overflow-y:scroll">
        <h3>周榜：</h3>
        <div class="table-responsive">
            <table class="table table-condesened table-hover">
                <thead>
                <tr>
                    <th>排名</th>
                    <th>昵称</th>
                    <th></th>
                    <th>做卷数</th>
                    <th>平均成绩</th>
                    <th>pt</th>
                </tr>
                </thead>
                <tbody id="week-rank"></tbody>
            </table>
        </div>
    </div>
    <div class="col-md-6" style="height:90%;overflow-y:scroll">
        <h3>总榜：</h3>
        <div class="table-responsive">
            <table class="table table-condesened table-hover">
                <thead>
                <tr>
                    <th>排名</th>
                    <th>昵称</th>
                    <th></th>
                    <th>做卷数</th>
                    <th>平均成绩</th>
                    <th>pt</th>
                    <th>掌握单词</th>
                    <th>做题数</th>
                </tr>
                </thead>
                <tbody id="all-rank"></tbody>
            </table>
        </div>
    </div>
</div>