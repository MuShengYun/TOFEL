<?php
$title = 'Welcome';
include 'front.header.php';
?>
<script>var my_uid = <?=$uid?>;</script>
<script src="/static/js/settings.js"></script>



<div class="mainform ur">
	<p>
	修改背景图：
		<div class="form-group">
			<label class="sr-only" for="bgurl">背景图片URL</label>
			<input type="text" class="form-control" id="bgurl" 
				   placeholder="背景图片URL">
		</div>
		<button type="submit" class="btn btn-default" onclick="bg_chg($('#bgurl').val())">提交</button>
	</p>
        <fieldset>
            <legend contenteditable="true">设置题量</legend>
            <label contenteditable="true">英译中：</label>
            <input id="ec" placeholder="5" type="text" />
            <label contenteditable="true">中译英：</label>
            <input id="ce" placeholder="5" type="text" />
            <label contenteditable="true">英译英：</label>
            <input id="ee" placeholder="5" type="text" />
            <br><label contenteditable="true">拼写：</label>
            <input id="sp" placeholder="5" type="text" />
            <label contenteditable="true">单选：</label>
            <input id="sel" placeholder="5" type="text" />
            <button class="btn btn-default" onclick="quiz_chg()">提交</button>
        </fieldset>
</div>