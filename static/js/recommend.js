function html2Escape(sHtml) {
    return sHtml.replace(/[<>&"]/g, function (c) {
        return {'<': '&lt;', '>': '&gt;', '&': '&amp;', '"': '&quot;'}[c];
    });
}



$(document).ready(function() {
    $.post('/api/recommend_news', {"class" : newscate}, function(dt) {
        if (!dt) {
            alert('服务器繁忙，刷新中。');
            window.location.reload();
            return;
        }
        $("#newsTitle").html(dt.result[0].news_title + "<br><span style='font-size:50%'>" + dt.result[0].time + "</span>");
        var T = "<p class=\"description\" align=\"center\"><img src=\""+html2Escape(dt.result[0].pics)+"\" width=\"300\" height=\"240\"  /></p>";
        $.each(dt.result[0].contents, function (i, v) {
            if (v.length > 0) {
                T += "<p class=\"description\" style='text-indent:25px'>" +
                    html2Escape(v) +
                    "</p>"
            }
        });
        $("#newsCon").html(T);
    }, "json");
});

rsz = function() {
    $(".tit").css("font-size", (0.8 + $(document).width / 1000) + "em");

};

$(document).ready(rsz); $(window).resize(rsz);