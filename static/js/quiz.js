var startTime = new Date().getTime();
var probStartTime = new Date().getTime();
var nowquizid = 0;
var score = 0, maxscore = 0;
var nowprobid = 0;
var trueAnswer = 0, accepted = 0;
var qz, cnt_P = 0, cnt_GR = 0, cnt_G = 0, cnt_M = 0, cnt_combo = 0, max_combo = 0;
var _tmps, _tmp, wrong_list = [], _intv;
var _selected, qzl = 10000, _spell = "", _spellen;

$(document).ready(function() {
    if (lid < 1 && is_custom != true) lid = 1;
	var lmt = (limited == true) ? 1 : 0;
	if (is_custom == true && wrdlist == "no") {
	    alert("自定义单词库不存在");
	    window.history.back();
    }
	var wlst = (is_custom == false) ? null : wrdlist; 
    $.post("/api/create_problem", {"lid": lid, "limited" : lmt, "wids" : wlst}, function (data) {
        if (data.code != 0) {
            alert(data.message);
            window.location.href = "/";
        }
        qz = data.result.slice();
        qzl = qz.length;
        $("#totalprobid").html(qz.length);
        nowquizid = data.quiz_id;
    }, "json");

    _intv = setInterval("loadTime()", 100);
    _tmps = setInterval("temp()", 100);
});

function temp() {
    load_problem(0);
    clearInterval(_tmps); _tmps = null;
}

function secondToDate(result) {
    var h = Math.floor(result / 3600) < 10 ? '0'+Math.floor(result / 3600) : Math.floor(result / 3600);
    var m = Math.floor((result / 60 % 60)) < 10 ? '0' + Math.floor((result / 60 % 60)) : Math.floor((result / 60 % 60));
    var s = Math.floor((result % 60)) < 10 ? '0' + Math.floor((result % 60)) : Math.floor((result % 60));
    return h + ":" + m + ":" + s;
}

function loadTime() {
    var now = new Date().getTime();
    var usetime = (now - startTime) / 1000;
    $("#navtitle").html(secondToDate(usetime));
    var usetime2 = (now - probStartTime) / 1000;
    $("#nowtime").html(secondToDate(usetime2));
}

function load_spell(id) {
    $("#spelling").html("");
    _selected = []; _spell = ''; _spellen = 0;
    var CON = '<div class="col-sm-12">' +
        '<a href="javascript:void(0);" class="button button-caution button-pill button-large" ' +
        'style="font-size:110%;width:100%;" onclick="load_spell(' + id + ')">Reset</a>' +
        '</div>';
    $.each(qz[id].choices, function (key, val) {
        CON += '<div class="col-xs-6 col-sm-3" style="margin:5px 0px 5px 0px">\n' +
            '<a id="choice_' + key + '" href="javascript:void(0);" class="button button-royal button-rounded button-large" ' +
            'style="font-size:110%;width:100%;overflow-y:hidden; -webkit-scrollbar-display: none" onclick="spell(\'' + val + '\', \'' + key + '\')">' + val + '</a>\n' +
            '</div>';
        $("#choice_" + key).css("box-shadow", "0 0 0 0 #000");
        _selected.push(0); _spellen++;
    });
    $("#choicelist").html(CON);
    return CON;
}

function load_problem(id) {
    var perc = Math.floor(score / maxscore * 10000) / 100;
    $("title").html("Quiz [ " + perc + "% ]");
    if (id >= qzl) { submit(); return 0; }
    nowprobid = id; _selected = [];
    $("#quizTitle").html(qz[id].problem + "<p id='spelling'></p>");
    $("#nowprobid").html(id + 1);
    switch (qz[id].cate) {
        case 'e_to_c': $("#probcate").html("English to Chinese: Click all the right definitions!"); break;
        case 'spell': $("#probcate").html("Chinese to English :Spell the word according to Chinese!"); break;
        default: $("#probcate").html(qz[id].cate); break;
    }
    probStartTime = new Date().getTime();
    var CON = '';
    if (qz[id].cate !== 'spell') {
        CON = '';
        $.each(qz[id].choices, function (key, val) {
            CON += '<div class="col-sm-6" style="margin:5px 0px 5px 0px;">\n' +
                '<a id="choice_' + key + '" href="javascript:void(0);" class="button button-royal button-pill button-large" ' +
                'style="font-size:110%;width:100%;overflow-y:scroll; -webkit-scrollbar-display: none" onclick="sel(' + key + ');">' + val + '</a>\n' +
                '</div>';
                // alert(val);
            $("#choice_" + key).css("box-shadow", "0 0 0 0 #000");
            _selected.push(0);
        });
    } else {
        CON = load_spell(id);
    }
    if (qz[id].true_ans_cnt)
        trueAnswer = qz[id].true_ans_cnt;
    else
        trueAnswer = 1;
    accepted = 0;
    $("#choicelist").html(CON);
    $("#choicelist").show(200);
    clearTimeout(_tmp); _tmp = null;
}

function sel(id) {
    if (_selected[id] == 1) {
        alert("It was selected.");
        return;
    } else
        _selected[id] = 1;
    var timeUse = (new Date().getTime() - probStartTime) / 1000;
    $("#choice_" + id).removeAttr("onclick");
    $.post("/api/quiz_select", {"lid": nowquizid, "tid": nowprobid, "tcate": qz[nowprobid].cate, "ans": id, "usetime":timeUse}, function (data) {
        if (data.code === 0) {
            $("#choice_" + id).css("box-shadow", "0 0 12px 4px #8bc220");
            accepted++;
        } else if (data.code === 1) {
            $("#comments").html("MISS");
            $("#comments").css("text-shadow", "0px 0px 2px #eee");
            $("#choice_" + id).css("box-shadow", "0 0 12px 4px #ff1022");
            if (Array.isArray(data.true_answer)) {
                $.each(data.true_answer, function (ind, val) {
                    $("#choice_" + val).css("box-shadow", "0 0 12px 4px #8bc220");
                    $("#choice_" + val).removeAttr("onclick");
                });
            } else {
                $("#choice_" + data.true_answer).css("box-shadow", "0 0 12px 4px #8bc220");
                $("#choice_" + data.true_answer).removeAttr("onclick");
            }
            trueAnswer = 0; accepted = 0;
            cnt_M++; maxscore += 500;
            cnt_combo = 0;
            $("#combos").html(cnt_combo);
            getword(data.word_id);
            _tmp = setTimeout("load_problem(nowprobid + 1)", 2000);
        } else {
            alert(data.message); return;
        }
        if (accepted >= trueAnswer && accepted > 0) {
            cnt_combo++;
            if (cnt_combo > max_combo) max_combo = cnt_combo;
            $("#choicelist").hide(500);
            switch (qz[nowprobid].cate) {
                case 'spell': secP = 5; secG = 10; break;
                case 'choice': secP = 20; secG = 40; break;
                case 'e_to_e': secP = 10; secG = 20; break;
                default: secP = 2; secG = 4.5; break;
            }
            if (timeUse < secP * trueAnswer) {
                cnt_P++; score += 500; maxscore += 500;
                $("#comments").html("PERFECT");
                $("#comments").css("text-shadow", "0px 0px 2px #e59501");
                $("#combos").html(cnt_combo);
            } else if (timeUse < secG * trueAnswer) {
                cnt_GR++; score += 400; maxscore += 500;
                $("#comments").html("GREAT");
                $("#comments").css("text-shadow", "0px 0px 2px #e91e63");
                $("#combos").html(cnt_combo);
            } else {
                cnt_G++; score += 250; maxscore += 500;
                $("#comments").html("GOOD");
                $("#comments").css("text-shadow", "0px 0px 2px #4caf50");
                $("#combos").html(cnt_combo);
            }
            getword(data.word_id);
            trueAnswer = 0; accepted = 0;
            _tmp = setTimeout("load_problem(nowprobid + 1)", 2000);
        }
    }, "json");
}

function getword(wd) {
    $.post("/api/getwords", {"word" : wd},
        function (data) {
            if (data.code === 0) {
                $("#words").html(data.message);
                $("#words_m").html(data.message);
				$("#word_audio").html("<audio src=\"https://dict.youdao.com/dictvoice?audio=" + data.message + "&type=2\"  autoplay=\"autoplay\">您的浏览器不支持 audio 标签。</audio>");
                if (cnt_combo == 0) {wrong_list.push(data.message);}
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
}

function spell(lt, dt) {
    $("#choice_" + dt).css("box-shadow", "0 0 12px 4px #000000");
    $("#choice_" + dt).removeAttr("onclick");
    var timeUse = (new Date().getTime() - probStartTime) / 1000;
    _spell += lt; $("#spelling").html(_spell);
    _spellen--;
    if (_spellen <= 0) {
        $.post("/api/quiz_select",
            {"lid": nowquizid, "tid": nowprobid, "tcate": "spell", "ans": _spell, "usetime": timeUse},
            function (data) {
                if (data.code === 0) {
                    $("#spelling").css("text-shadow", "0px 0px 2px #0f0");
                    cnt_combo++;
                    if (timeUse < 6) {
                        cnt_P++; score += 500; maxscore += 500;
                        $("#comments").html("PERFECT");
                        $("#comments").css("text-shadow", "0px 0px 2px #e59501");
                        $("#combos").html(cnt_combo);
                    } else if (timeUse < 12) {
                        cnt_GR++; score += 400; maxscore += 500;
                        $("#comments").html("GREAT");
                        $("#comments").css("text-shadow", "0px 0px 2px #e91e63");
                        $("#combos").html(cnt_combo);
                    } else {
                        cnt_G++; score += 250; maxscore += 500;
                        $("#comments").html("GOOD");
                        $("#comments").css("text-shadow", "0px 0px 2px #4caf50");
                        $("#combos").html(cnt_combo);
                    }
                    trueAnswer = 0; accepted = 0;
                    $("#combos").html(cnt_combo);
                    getword(data.word_id);
                    _tmp = setTimeout("load_problem(nowprobid + 1)", 2000);
                } else if (data.code === 1) {
                    $("#spelling").css("text-shadow", "0px 0px 2px #f00");
                    $("#comments").html("MISS");
                    $("#comments").css("text-shadow", "0px 0px 2px #eee");
                    trueAnswer = 0; accepted = 0;
                    cnt_M++; maxscore += 500;
                    cnt_combo = 0;
                    $("#combos").html(cnt_combo);
                    getword(data.word_id);
                    _tmp = setTimeout("load_problem(nowprobid + 1)", 2000);
                } else {
                    alert(data.message); return;
                }
            }, 'json');
    }
}

function submit() {
    $.post("/api/quiz_submit",
        {"qid" : nowquizid, "cnt1" : cnt_P, "cnt2" : cnt_GR, "cnt3" : cnt_G, "cnt4" : cnt_M, "cnt5" : max_combo, "score":(score / maxscore * 100.0)},
        function (data) {
            if (data.code === 0) {
                var con = "<table class='table table-striped' style='font-size: 150%'>" +
                    "<tr><td>PERFECT</td><td>" + cnt_P + "</td>" +
                    "<td rowspan='4'>SCORE: " + (score / maxscore * 100.0) + "%<br>COMBO: " + max_combo + "</td></tr>" +
                    "<tr><td>GREAT</td><td>" + cnt_GR + "</td></tr>" +
                    "<tr><td>GOOD</td><td>" + cnt_G + "</td></tr>" +
                    "<tr><td>MISS</td><td>" + cnt_M + "</td></tr>" +
                    "<tr><td colspan='3'>错误的单词列表：<br><span style='font-size:100%'>";
                $.each(wrong_list, function (ind, val) {
                    con += "<a href='#' onclick='getword(\"" + val + "\")'>" + val + "</a>";
                    if (ind % 3 === 2) con += "<br>"; else con += "　　　";
                });
                con += "</span></td></tr>" +
                    "</table>";
                $("#resulto").html(con);
                clearInterval(_intv);
            } else {
                alert(data.message);
            }
        }
        , "json");

}