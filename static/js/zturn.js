var nowmdl = 1;
var pbar = 100;
var locked = false;

function swapslide() {
    if (!dres) {
    	// alert('服务器繁忙，刷新中。');
       // window.location.reload();
        return;
    }
    --pbar;
    if (pbar <= 0) {
        $("#mdl1").hide(500, function () {
            locked = true;
            $("#toph1").html(dres[nowmdl].news_title);
            $("#topp1").html(dres[nowmdl].contents);
            $("#i1").attr('src', dres[nowmdl].pics);
            $("#i1").attr('onclick', "_locate('/recommend/" + dres[nowmdl].news_id + "')");
            nowmdl = (nowmdl + 1) % dres.length;
            $("#mdl1").show(500);
            pbar = 100;
            locked = false;
        });
    }
    $("#pbar").css("width", pbar + "%");
}

$(document).ready(function() {
	setInterval("swapslide()", 100);
});