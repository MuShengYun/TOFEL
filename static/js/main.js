function _locate(url) {
    window.location.href = url;
}

function logout()  {
	$.post('/api/user_logout', null, function(dt) {
		alert(dt.message);
		_locate('/');
	}, "json");
}

re_sz = function() {
	// 有的傻逼浏览器搞不好
	if ($(document).width() < 500) {
        if ($(document).height() > $(document).width()) {
            $("body").css('background-size', 'auto ' + $(document).height() + "px");
            $("body").css('-webkit-background-size', 'auto ' + $(document).height() + "px");
            $("body").css('-o-background-size', 'auto ' + $(document).height() + "px");
            $("body").css('-moz-background-size', 'auto ' + $(document).height() + "px");
        } else {
            $("body").css('background-size', $(document).width() + "px auto");
            $("body").css('-webkit-background-size', $(document).width() + "px auto");
            $("body").css('-o-background-size', $(document).width() + "px auto");
            $("body").css('-moz-background-size', $(document).width() + "px auto");
        }
    }
};
$(document).ready(re_sz); $(window).resize(re_sz);

