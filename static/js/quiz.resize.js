// 用于支持手机端的quiz

rsz = function() {
    if ($(document).width() < 990) {
        $(".shown_PC").hide(100);
        $(".shown_SM").show(100);
    } else {
        $(".shown_PC").show(100);
        $(".shown_SM").hide(100);
    }
};

$(document).ready(rsz); $(window).resize(rsz);