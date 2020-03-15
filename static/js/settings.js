function bg_chg(bg) {
	$.post('/api/set_background', {"bgpic" : bg}, function(data) {
		if (data.code == 0) alert("设置成功"); else alert(data.message);
	}, "json");
}

function quiz_chg() {
    var ec = $('#ec').val();
    var ce = $('#ce').val();
    var ee = $('#ee').val();
    var sp = $('#sp').val();
    var sel = $('#sel').val();
    $.post('/api/set_quiz_param', {"e_to_c" : ec, 'c_to_e' : ce, 'e_to_e' : ee, "spell" : sp, "sel" : sel}, function(data) {
        if (data.code == 0) alert("设置成功"); else alert(data.message);
    }, "json");
}