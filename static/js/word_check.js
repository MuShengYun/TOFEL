var word_id_list;
var word_list;
var word_cnt;
var current_start_id = 0;
var current_id = 0;
var learn_cnt = 10;
var mistake_list = [];
var test_list = [];
var now_true_ans = 0;
var now_eng_ans;
var time_start, time_word;
var _tmp;

function secondToDate(result) {
    var h = Math.floor(result / 3600) < 10 ? '0'+Math.floor(result / 3600) : Math.floor(result / 3600);
    var m = Math.floor((result / 60 % 60)) < 10 ? '0' + Math.floor((result / 60 % 60)) : Math.floor((result / 60 % 60));
    var s = Math.floor((result % 60)) < 10 ? '0' + Math.floor((result % 60)) : Math.floor((result % 60));
    return h + ":" + m + ":" + s;
}

function start() {
    $.post("/api/get_wordlist", {"lid": list_id},
        function (data) {
            word_id_list = data.result.id.slice();
            word_list = data.result.word.slice();
            word_cnt = word_list.length;
        }
    , "json");
}

function Time() {
    var now_time = new Date().getTime();
    var times = secondToDate((now_time - time_start) / 1000);
    $("#nowtime").html(times);
}


$(document).ready(start());

function start_learn() {
    current_start_id = 0;
    show_words();
}

function show_words() {
    var T = "";
    for (var i = current_start_id; i < current_start_id + learn_cnt && i < word_cnt; ++i) {
        T += "<tr onclick='getword(\"" + word_list[i] + "\", true)'>";
        T += "<td>" + (i + 1) + "</td>";
        T += "<td>" + word_list[i] + "</td>";
        T += "<td><a href='javascript:void(0)' onclick='getword(\"" + word_list[i] + "\", true)'>?</a></td>";
        T += "</tr>";
    }
    $("#lists").html(T);
    console.log(T);
    $("#restart").hide(500);
    $("#gotest").show(500);
    $("#quizpanel").hide(500);
}

function show_question(id) {
    // console.log(id);
    time_word = new Date().getTime();
    $("#nowprobid").html(current_id + 1);
    $("#totalprobid").html(test_list.length);
    $.post("/api/word_check", {"id" : id},
        function (data) {
            $("#quizTitle").html(data.message.word);
            for (var i = 0; i < 6; i++) {
                $("#C" + i).html(data.message.options[i]);
                $("#C" + i).attr("onclick", "select_ans(" + i + ")");
                $("#C" + i).css("box-shadow", "0 0 0 0 #000");
            }
            now_eng_ans = data.message.answord.slice();
            now_true_ans = data.message.answer;
        }
    , "json");
}

function end_test() {
    current_start_id += learn_cnt;
    if (current_start_id >= word_cnt) {
        alert("测试完成！");
        $("#restart").show(500);
        $("#gotest").hide(500);
        $("#lists").hide(500);
        $("#quizpanel").hide(500);
    } else {
        $("#gotest").show(500);
        $("#lists").show(500);
        $("#quizpanel").hide(500);
        show_words();
    }
    clearInterval(_tmp);
}

function select_ans(i) {
    if (i == now_true_ans) {
        var now_time = new Date().getTime();
        var times = (now_time - time_word) / 1000;
        if (times > 6) {
            mistake_list.push(test_list[current_id]);
            $("#timeoutinfo").show(100);
        } else {
            $("#timeoutinfo").hide(100);
        }
        $("#C" + i).css("box-shadow", "0 0 12px 4px #8bc220");
        $("#C" + i).removeAttr("onclick");
        getword(now_eng_ans[i], false);
        for (i = 0; i < 6; i++) {
            if (i !== now_true_ans) {
                $("#C" + i).html(now_eng_ans[i]);
            }
            $("#C" + i).removeAttr("onclick");
        }
    } else {
        $("#timeoutinfo").hide(100);
        $("#C" + now_true_ans).css("box-shadow", "0 0 12px 4px #8bc220");
        $("#C" + now_true_ans).removeAttr("onclick");
        $("#C" + i).css("box-shadow", "0 0 12px 4px #ff1022");
        $("#C" + i).removeAttr("onclick");
        for (i = 0; i < 6; i++) {
            if (i !== now_true_ans) {
                $("#C" + i).html(now_eng_ans[i]);
            }
            $("#C" + i).removeAttr("onclick");
        }
        mistake_list.push(test_list[current_id]);
        getword(now_eng_ans[now_true_ans], true);
    }
    current_id++;
    if (current_id >= test_list.length) {
       setTimeout("end_test()", 1500);
    } else {
        setTimeout("show_question(test_list[current_id])", 1500);
    }
}

function go_test() {
    test_list = mistake_list.slice();
    for (var i = current_start_id; i < current_start_id + learn_cnt && i < word_cnt; ++i) {
        test_list.push(word_id_list[i]);
    }
    mistake_list = [];
    $("#gotest").hide(500);
    $("#lists").hide(500);
    $("#quizpanel").show(500);
    current_id = 0;
    show_question(test_list[0]);
    time_start = new Date().getTime();
    _tmp = setInterval("Time()", 1000);
}



function getword(wd, needshow) {
    $.post("/api/getwords", {"word" : wd},
        function (data) {
            if (data.code === 0) {
                $("#words").html(data.message);
                $("#words_m").html(data.message);
                $("#word_audio").html("<audio src=\"https://dict.youdao.com/dictvoice?audio=" + data.message + "&type=2\"  autoplay=\"autoplay\">您的浏览器不支持 audio 标签。</audio>");
                $("#word2").html("  [" + data.response.phonetic + "]");
                $("#word2_m").html("  [" + data.response.phonetic + "]");
                $("#diff").html("单词等级：" + data.response.level + "     单词难度：" + data.response.difficulty);
                $("#diff_m").html("单词等级：" + data.response.level + "     单词难度：" + data.response.difficulty);
                var T = "", i = 0;
                $.each(data.response.explains, function (ind, val) {
                    i++;
                    T += "<b>" + i + ". </b>" + val + "<br>";
                });
                $("#meanings").html(T);
                $("#meanings_m").html(T);
                T = ""; i = 0;
                $.each(data.response.explains_en, function (ind, val) {
                    i++;
                    T += "<b>" + i + ". </b>" + val + "<br>";
                });
                $("#meanings_en").html(T);
                $("#meanings_en_m").html(T);
                T = "";
                i = 0;
                $.each(data.sentence, function (ind, val) {
                    i++;
                    T += "<b>" + i + ". </b>" + val.eng + "<br>" + val.chn + "<br>";
                });
                $("#sentences").html(T);
                $("#sentences_m").html(T);
            } else {
                alert(data.message);
            }
        }, "json");
    if (needshow === true) {
        if ($(document).width() < 990) {
            $('#identifier').modal();
        }
    }
}