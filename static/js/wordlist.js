var wlist = [];
var wrds = [];

$(document).ready(function() {
    printWordList();
});

function getword(wd) {
    $("#words").html(wd);
	$("#word_audio").html("<audio src=\"https://dict.youdao.com/dictvoice?audio=" + wd + "&type=2\"  autoplay=\"autoplay\">您的浏览器不支持 audio 标签。</audio>");
    $.post("/api/getwords", {"word" : wd},
        function (data) {
            if (data.code === 0) {
                $("#word2").html("  [" + data.response.phonetic + "]");
                var T = "", i = 0;
                $.each(data.response.explains, function (ind, val) {
                    i++;
                    T += "<b>" + i + ". </b>" + val + "<br>";
                });
                $("#meanings").html(T);
                T = "";
                i = 0;
                $.each(data.sentence, function (ind, val) {
                    i++;
                    T += "<b>" + i + ". </b>" + val.eng + "<br>" + val.chn + "<br>";
                });
                $("#sentences").html(T);
                addWordList(data.word_id, wd);
            } else {
                alert(data.message);
            }
			$('#inputword').val("");
        }, "json");
}

function addWordList(id, wd) {
    wlist.push(id);
    wrds.push(wd);
    printWordList();
}

function delWordList(id) {
    wlist.splice(id, 1);
    wrds.splice(id, 1);
    printWordList();
}

function printWordList() {
    var con = "";
    for (var i = 1; i <= wlist.length; i++) {
        con += "<tr><td>" + i + "</td><td>" + wrds[i - 1] + "</td><td><a href='#' onclick='delWordList(" + (i - 1) + ")'>Del</a></td></tr>";
    }
    $("#lists").html(con);
}

function create_wordlist() {
    $.post("/api/create_wordlist", {"lname" : $("#lname").val(), "lcate" : $("#lcate").val(), "words" : JSON.stringify(wlist)},
        function(data) {
            if (data.code === 0) {
                alert("添加成功");
            } else {
                alert(data.message);
            }
        }
    , "json");
}