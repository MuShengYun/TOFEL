function divor(a, b, c) {
    return "<div class=\"blog-item-wrapper\" style='margin: 6px'>\n" +
        "<div class=\"blog-item\">\n" +
        "<div class=\"blog-text\">\n" +
        "<div class=\"blog-title\">\n" +
        "<h4 style=\"padding-left: 2rem;font-size: 2rem\">" + a + "<span style='color:red;font-size:0.9rem'>" + c + "</span></h4>\n" +
        "</div>\n" +
        "<div class=\"blog-desc\">\n" +
        "<p style=\"padding-left: 1rem;font-size: 1.25rem\">" + b + "</p>\n" +
        "</div></div></div></div>";
}

function add_sign(a) {
    if (a > 0) return "+" + a;
    return a;
}

function html2Escape(sHtml) {
    return sHtml.replace(/[<>&"]/g, function (c) {
        return {'<': '&lt;', '>': '&gt;', '&': '&amp;', '"': '&quot;'}[c];
    });
}

function a1ert() {
    alert("红色数字代表难度和首个错词的差距，数字越大代表单词难度越大。");
}

$(document).ready(function () {
    $.post("/api/recommend_article", null, function(data) {
        if (data.code !== 0) { alert(data.message); return; }
        var wrd = '';
        $.each(data.result, function (i, v) {
            $.each(v.info.wrong, function (ii, vv) {
                wrd += divor(vv.word, vv.expl, "");
            });
            $.each(v.info.new, function (ii, vv) {
                wrd += divor(vv.word, vv.expl, "(" + add_sign(vv.dt) + ")");
            });
            $("#ti_" + i).html(v.title);
            var T = "";
            $.each(v.article, function (ii, vv) {
                if (vv.length > 0) {
                    T += "<p style='text-indent:24px'>" +
                        html2Escape(vv) +
                        "</p>"
                }
            });
            $("#co_" + i).html(T);
        });
        $("#needwords").html(wrd);

    }, 'json');
});

rsz = function() {
    if ($(document).width() < 930) {
        $(".text-left").css("padding-left", "2%");
        $(".text-left").css("padding-right", "2%");
    } else {
        $(".text-left").css("padding-left", "7%");
        $(".text-left").css("padding-right", "7%");
    }
};

$(document).ready(rsz); $(window).resize(rsz);