<?php
$title = 'Status';
include 'front.header.php';
?>
<div class="mainform">
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
    Status Form. 点击上方菜单栏选择。
</div>
