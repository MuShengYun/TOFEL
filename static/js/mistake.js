function timestampToTime(timestamp) {
    var date = new Date(timestamp * 1000); //时间戳为10位需*1000，时间戳为13位的话不需乘1000
    Y = date.getFullYear() + '-';
    M = (date.getMonth() + 1 < 10 ? '0' + (date.getMonth() + 1) : date.getMonth() + 1) + '-';
    D = change(date.getDate()) + ' ';
    h = change(date.getHours()) + ':';
    m = change(date.getMinutes()) + ':';
    s = change(date.getSeconds());
    return Y + M + D + h + m + s;
}
function change(t) {
    if (t < 10) {
        return "0" + t;
    } else {
        return t;
    }
}

function loads() {
    loads(0);
}

function __d__(input){var output="", _keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";var chr1,chr2,chr3,enc1,enc2,enc3,enc4;var i=0;while(i<input.length){chr1=input.charCodeAt(i++);chr2=input.charCodeAt(i++);chr3=input.charCodeAt(i++);enc1=chr1>>2;enc2=((chr1&3)<<4)|(chr2>>4);enc3=((chr2&15)<<2)|(chr3>>6);enc4=chr3&63;if(isNaN(chr2)){enc3=enc4=64}else if(isNaN(chr3)){enc4=64}output=output+_keyStr.charAt(enc1)+_keyStr.charAt(enc2)+_keyStr.charAt(enc3)+_keyStr.charAt(enc4)}return output}

var errorlist = "";

function _gotest() {
    var _con = confirm("将测试下方列表（我的错词列表）中的所有单词，是否进行测试？");
    if (_con == true) {
        _locate("/custom_quiz/" + __d__(errorlist));
    }
}

function loads(idid) {
    var t_cate = null, clist = null;
    if ($("#examlist").val() !== 'no') clist = $("#examlist").val();
    if ($("#probcates").val() !== 'no') t_cate = $("#probcates").val();
    $.post('/api/mistakes', {"t_cate": t_cate, "list": clist}, function(data) {

        if (idid < 0) {
            var _con = '<option value ="no" selected="selected">测试时间</option>\n';
            $.each(data.quizs, function (ind, val) {
                _con += '<option value="' + val.id + '">'+ val.list_name + "("
                    + timestampToTime(val.time_start) +')</option>';
            });
            $("#examlist").html(_con);
        }


        var con = '<table class="table table-condensed table-hover">' +
            '<thead><tr><td>排名</td><td>单词</td><td>释义</td><td>错误数</td><td>平均用时</td></tr></thead><tbody>';
        var last_i = 1, last = -2;
		errorlist = "";
        $.each(data.my_mis, function(ind, val) {
            if (val.cnt != last) { last_i = ind + 1; last = val.cnt; }
			if (ind > 0) errorlist += ',';
			errorlist += val.wordid;
            con += '<tr>' +
                '<td>' + last_i + '</td>' +
                '<td>' + val.word + '</td>' +
                '<td>' + val.meanings + '</td>' +
                '<td>' + val.cnt + '</td>' +
				'<td'; 
			if (val.a > 8) con += ' style="text-shadow: 0 0 5px red;"';
			if (val.a < 2) con += ' style="text-shadow: 0 0 5px #89ff00;"';
			con += '>' + Math.floor(val.a * 100) / 100 + '</td>' +
                '</tr>';
        });
        con += '</tbody></table>';
        $("#myMis").html(con);

        con = '<table class="table table-condensed table-hover" style="height:90%;overflow-y:scroll">' +
            '<thead><tr><td>排名</td><td>单词</td><td>错误人数</td><td>错误人次</td><td>平均用时</td></tr></thead><tbody>';
        last_i = 1; last = -2;
        $.each(data.all_mis, function(ind, val) {
            if (val.cnt != last) { last_i = ind + 1; last = val.cnt; }
            con += '<tr>' +
                '<td>' + last_i + '</td>' +
                '<td>' + val.word + '</td>' +
                '<td>' + val.mx + '</td>' +
                '<td>' + val.cnt + '</td>' +
				'<td'; 
			if (val.a > 8) con += ' style="text-shadow: 0 0 5px red;"';
			if (val.a < 2) con += ' style="text-shadow: 0 0 5px #89ff00;"';
			con += '>' + Math.floor(val.a * 100) / 100 + '</td>' +
                '</tr>';
        });
        con += '</tbody></table>';
        $("#allMis").html(con);
    }, 'json');
}

$(document).ready( function () {

    loads(-1);
});