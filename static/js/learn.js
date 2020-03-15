var _word = [], _id = 0, _max_length = 0, _nowword = "", time_start = 0, _wrong_list = [];

function secondToDate(result) {
    var h = Math.floor(result / 3600) < 10 ? '0'+Math.floor(result / 3600) : Math.floor(result / 3600);
    var m = Math.floor((result / 60 % 60)) < 10 ? '0' + Math.floor((result / 60 % 60)) : Math.floor((result / 60 % 60));
    var s = Math.floor((result % 60)) < 10 ? '0' + Math.floor((result % 60)) : Math.floor((result % 60));
    return h + ":" + m + ":" + s;
}

function Time() {
	var now_time = new Date().getTime();
	var times = secondToDate((now_time - time_start) / 1000);
	$("#nowtime").html(times);
}

function start() {
	setInterval("Time()", 1000);
	$.post('/api/get_wordlist', {"lid" : lid}, function(data) {
		_word = data.result.word.slice();
		_id = 0; _max_length = _word.length;
		$("#totalprobid").html(_max_length);
		time_start = new Date().getTime();
	}, 'json');
}
$(document).ready(start());

function dictation(id) {
	$("#nowprobid").html(id);
	if (id < 0 || id >= _max_length) { $("#start_button").html("Restart"); $("#inputword").hide(400); $("#replays").hide(400);$("#restart").show(1000); return; } 
	$("#inputword").show(400);
	$("#replays").show(400);
	$("#restart").hide(1000);
	_id = id;
	_nowword = _word[_id];
	$("#word_audio").html("<audio src=\"https://dict.youdao.com/dictvoice?audio=" + _nowword + "&type=2\"  autoplay=\"autoplay\">您的浏览器不支持 audio 标签。</audio>");
	
}


function _check(wd) {
	if (wd === _nowword) {
		$("#inputword").css("text-shadow", "0 0 8px #00FF00");
		setTimeout("getword(_nowword, 0)", 1000);
	} else {
		$("#inputword").css("text-shadow", "0 0 8px #E91E63");
		setTimeout("getword(_nowword, 1)", 1000);
	}
}

function _refresh() {
	var con = "";
    for (var i = 1; i <= _wrong_list.length; i++) {
        con += "<tr><td>" + i + "</td><td>" + _wrong_list[i - 1] + "</td><td><a href='#' onclick='getword(\""+_wrong_list[i - 1]+"\", 2)'>?</a></td></tr>";
    }
    $("#lists").html(con);
}

function replay() {
	$("#word_audio").html("<audio src=\"https://dict.youdao.com/dictvoice?audio=" + _nowword + "&type=2\"  autoplay=\"autoplay\">您的浏览器不支持 audio 标签。"+(new Date().getTime())+"</audio>");
}


function getword(wd, is_wrong) {
	$("#inputword").css("text-shadow", "0 0 0 #000");
    $.post("/api/getwords", {"word" : wd},
        function (data) {
            if (data.code === 0) {
                $("#diff").html("单词等级：" + data.response.level + "     单词难度：" + data.response.difficulty);
				$("#inputword").val("");
                $("#words").html(data.message);
				$("#word2").html("  [" + data.response.phonetic + "]　　<a id='plus' href='javascript:void(0)'  class=\"button button-caution button-pill button-large\" onclick=\"_wrong_list.push('" + data.message + "'); _refresh();$('#plus').fadeOut(100);\">＋</a>");
				if (is_wrong === 1) {
					_wrong_list.push(data.message);
					_refresh();
					$("#word2").html("  [" + data.response.phonetic + "]");
				} 
                var T = "", i = 0;
                $.each(data.response.explains, function (ind, val) {
                    i++;
                    T += "<b>" + i + ". </b>" + val + "<br>";
                });
                $("#meanings").html(T);
                T = ""; i = 0;
                $.each(data.response.explains_en, function (ind, val) {
                    i++;
                    T += "<b>" + i + ". </b>" + val + "<br>";
                });
                $("#meanings_en").html(T);
                T = "";
                i = 0;
                $.each(data.sentence, function (ind, val) {
                    i++;
                    T += "<b>" + i + ". </b>" + val.eng + "<br>" + val.chn + "<br>";
                });
                $("#sentences").html(T);
				if (is_wrong !== 2) 
					dictation(_id + 1);
				else
					$("#word_audio").html("<audio src=\"https://dict.youdao.com/dictvoice?audio=" + data.message + "&type=2\"  autoplay=\"autoplay\">您的浏览器不支持 audio 标签。"+(new Date().getTime())+"</audio>");
            } else {
                alert(data.message);
            }
        }, "json");
}