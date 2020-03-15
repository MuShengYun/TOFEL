function matchReg(str){
    let reg=/<\/?.+?\/?>/g;
    return str.replace(reg,'');
}

$(window).resize(function() {
    $("#historywords").css("width", $("#prpr").width() + "px")
    .css("height", ($(window).height() - 200) + "px");
});

var histories = 0;
function getmeaning(w) {
    if (!w) return;
    $("#inputword").val("");
    $("#wordname").html(w);
    $("#youdao").html("Waiting...");
    $("#colins").html("Waiting...");
    $("#webster").html("Waiting...");
    $.post("/api/getwordmeaning", {"word" : w},
        function (data) {
            if (data.youdao) {
                var YD = "";
                $.each(data.youdao, function(ind, val) {
                    YD += "<p><b style='font-size: 120%'>#" + (ind + 1) + "  </b>" + val + "</p>";
                });
                $("#youdao").html(YD);
            }
            if (data.collins) {
                var CLS = "";
                $.each(data.collins, function(ind, val) {
                    // console.log(val);
                    CLS += "<p><b style='font-size: 120%'>#" + (ind + 1) + "  </b>" + val + "</p>";
                });
                $("#colins").html(CLS);
            }
            if (data.webster) {
                var WB = "";
                $.each(data.webster, function(ind, val) {
                    if (ind < 5) {
                        WB += "<p>" + val.replace("\n", "<br>") + "</p>";
                        WB += "<p id='CHN" + ind + "'></p>";
                        setTimeout("trans1ate(" + ind + ", \"" + matchReg(val) + "\")", 20);
                    } else {
                        WB += "<p onclick='trans1ate(" + ind + ", \"" + matchReg(val) + "\")'>" + val.replace("\n", "<br>") + "</p>";
                        WB += "<p id='CHN" + ind + "'></p>";
                    }
                });
                $("#webster").html(WB);
            }
            $("#historywords").val($("#historywords").val() + w+"\t\n");
            histories++;
        }, "json")
        .error(function (XMLHttpRequest, textStatus, errorThrown) {
            $("#youdao").html(textStatus);
            $("#colins").html(textStatus);
            $("#webster").html(textStatus);
        });
}

function trans1ate(id, query) {
    $.post("/api/trans1ate", {"query" : query},
        function (data) {
            $("#CHN" + id).html(data[0]).css("color", "purple");
        }
        , "json")
        .error(function (XMLHttpRequest, textStatus, errorThrown) {
            $("#CHN" + id).html(textStatus);
    });
}
