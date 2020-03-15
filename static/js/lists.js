function loadlist() {
    $.post("/api/wordlist", null,
        function (data) {
            if (data.code === 0) {
                var con = '';
                $.each(data.result, function (i, v) {
                    con += '<div class="col-sm-12">';
                    con += "<h3>" + i + "</h3>";
                    $.each(v, function(ind, val) {
                        con += '<div class="col-sm-3">';
                        con += '<a href="javascript:void(' + ind + ')" class="ta" style="border-radius:4px" ' +
                            'onclick="starttest(' + val.id + ')"><div class="selection">' +
                            '<b style="font-size: 140%">' + val.lname + '</b><br>Cate: ' + val.lcate + '<br>Create Time:' + val.create_time +
                            '<br>Creator: ' + val.creator + '<br>Clicks: ' + val.cnts + '</div></a>';
                        con += '</div>';
                    });
                    con += '</div>';
                });
            } else {
                alert(data.message);
            }
            $("#lists").html(con);
        }, "json");
}

$(document).ready(loadlist());

function starttest(d) {
	$("#opers").hide(200);
	var con = "<div class=\"col-sm-4\"><a style=\"overflow-y:hidden\" href=\"javascript:void(0)\" class=\"button button-caution button-rounded button-jumbo\" onclick=\"_locate('/study/" + d + "')\">学　习</a></div>";
	con += "<div class=\"col-sm-4\"><a style=\"overflow-y:hidden\" href=\"javascript:void(0)\" class=\"button button-caution button-rounded button-jumbo\" onclick=\"_locate('/quiz/" + d + "')\">大测试</a></div>";
	con += "<div class=\"col-sm-4\"><a style=\"overflow-y:hidden\" href=\"javascript:void(0)\" class=\"button button-caution button-rounded button-jumbo\" onclick=\"_locate('/small_quiz/" + d + "')\">小测试</a></div>";
	$("#opers").html(con);
	$("#opers").show(200);
    $('.mainform').animate({scrollTop: '0px'}, 300);
}