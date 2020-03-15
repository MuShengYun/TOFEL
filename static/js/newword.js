rsz = function() {
    if ($(document).width() < 930) {
        $(".shown_PC").hide(100);
        $(".shown_SM").show(100);
        $(".cuser").css("width", Math.floor($(document).width() - 201) + "px");
    } else if ($(document).width() < 1117) {
        $(".shown_PC").show(100);
        $(".shown_SM").hide(100);
        $(".containerAA").css("min-width", Math.floor($(document).width() * 0.888) + "px");
        $(".cuser").css("width", Math.floor($(document).width() - 201) + "px");
        // alert("width changed");
    } else {
        $(".shown_PC").show(100);
        $(".shown_SM").hide(100);
        $(".containerAA").css("min-width", "992px");
        $(".cuser").css("width", "");
    }
};

$(document).ready(rsz); $(window).resize(rsz);

$(document).ready(function () {
    $.post("/api/recommend_word", null, function(data) {
        if (data.code !== 0) { alert(data.message); return; }
        $.each(data.result.recommend_word, function (i, v) {
            $("#sent_" + i).html(v.sentence.eng);
            $("#word_" + i).html(v.word + "  " + v.explain);
            $("#trans_" + i).html(v.sentence.chn);
        });
        $.each(data.result.similar_user, function (i, v) {
            $("#nick_" + i).html(v.word);
            $("#personal_" + i).html(
                "<p>Meanings：" + v.expl + "</p>" +
                "<p>最高错 " + v.cnt + " 次，平均用时 " + v.use_time + " s</p>"
            );
        });
    }, 'json');
});