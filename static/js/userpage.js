// 20190402
$(document).ready(
function onloads() {
	$.post("/api/get_user_info", {"user_id": user_id}, function(data) {
		$("#avatar").attr("src", "//q2.qlogo.cn/headimg_dl?bs=" + data.qq + "&dst_uin=" + data.qq + "&dst_uin=" + data.qq + "&;dst_uin=" + data.qq + "&spec=100&url_enc=0&referer=bu_interface&term_type=PC");
		$("#nickname").html(data.uname);
		$(document).attr("title", data.uname);
		$("#school").html("学校：" + data.school);
		$("#regtime").html("注册时间：" + data.reg_time);
		$("#logtime").html("最后登录：" + data.last_login);
		$("#avgt").html(data.avg_time);
		$("#mint").html(data.min_time);
	} , "json");
}
);