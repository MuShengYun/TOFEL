var dres, retry = 10;

rsz = function() {
    var wd = $(document).width();
    if (wd < 1100) {
        $(".topictit").css("margin-top", ((wd - 1100) / 30) + "px");
        $(".topiccon").hide(0);
        if (wd < 550) {
            $(".topictit").css("font-size", "1px");
        } else {
            $(".topictit").css("font-size", (wd / 18 - 31) + "px");
        }
    } else {
        $(".topictit").css("margin-top", "0%");
        $(".topiccon").show(0);
        $(".topictit").css("font-size", "30px");
    }
};
$(document).ready(rsz); $(window).resize(rsz);

function loads() {
    
	$.post('/api/main_getnews', null, function(data) {
        dres = data.result;
        // swapslide();
        ti1 = dres[0].news_title;
        con1 = dres[0].contents;
		// ti2 = dres[1].news_title;
		// con2 = dres[1].contents;
		document.getElementById('toph1').innerHTML=ti1;
        document.getElementById('topp1').innerHTML=con1;
		// document.getElementById('toph2').innerHTML=ti2;
        // document.getElementById('topp2').innerHTML=con2;
		// pic1 = dres[0].pics;
		// pic2 = dres[1].pics;
		$("#i1").attr('src', dres[0].pics);
        $("#i1").attr('src', dres[0].pics);
		// $("#i2").attr('src', dres[1].pics);
    }, 'json');
	
	
}


function changeTXT_Title(id) {
    if(id=="btn1") {
        $('#toph1').html(ti1);
        $('#topp1').html(con1);
    } else if (id=="btn2") {
        $('#toph1').html(title2);
        $('#topp1').html(str2);
    }
}