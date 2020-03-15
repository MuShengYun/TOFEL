<?php
$title = 'DictionAry';
include 'front.header.php';
?>
    <style>
        .wordcard {
            color: #8a6d3b;
            background-color: white;
            border-color: #faebcc;
            padding: 15px;
            margin-bottom: 20px;
            border: 2px solid transparent;
            border-radius: 4px;
        }
    </style>
    <script src="/static/js/dict.js"></script>
    <div class="mainform ur">
        <div class="col-xs-3" id="prpr">
            <div class="input-group">
                <input id="inputword" type="text" class="form-control" style="font-size:25px; border-radius: 3px; padding:20px;margin: 5px"
                       onkeydown="if(event.keyCode==13) getmeaning($('#inputword').val());">
            </div>
            <caption>历史记录：</caption>
            <p for="historywords"></p><textarea id="historywords" style="margin:0; padding:0;border:none;"></textarea>
        </div>
        <div class="col-xs-9">
            <div class="wordcard">
                <h2 id="wordname">???</h2>
                <h3>有道：</h3>
                <p id="youdao"></p>
                <h3>柯林斯：</h3>
                <p id="colins"></p>
                <h3>Webster（内含机翻）：</h3>
                <p id="webster"></p>
            </div>
        </div>
    </div>
</body>
</html>