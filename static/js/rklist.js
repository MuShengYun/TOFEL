function getQQicon(qq) {
    return "http://q2.qlogo.cn/headimg_dl?bs=" + qq + "&dst_uin=" + qq + "&dst_uin=" + qq + "&;" +
        "dst_uin=" + qq + "&spec=100&url_enc=0&referer=bu_interface&term_type=PC";
}

function load_rank() {
    $.post('/api/ranklist', null, function(data) {
        var get_mine = false;
        var con = "", last_i = 0, show_i = 0, pts = 0;
        $.each(data.week_rank, function(ind, val) {
            last_i++;
            if (pts !== val.pt) { show_i = last_i; pts = val.pt; }
            if (val.uid == my_uid) {
                con += "<tr style='background-color: #fec04e; font-weight:600; text-shadow: 0 0 3px #f00'>";
                get_mine = true;
            } else {
                con += "<tr>";
            }
            con += "<td>" + show_i + "</td>";
            con += "<td>" +
                "<a href='#' onclick='_locate(\"/user/" + val.uid + "\")'><img src='" + getQQicon(val.qq) + "' height='32px' width='32px' /></a></td><td>" + val.nick + "</td>";
            con += "<td>" + val.cnt + "</td>";
            con += "<td>" + Math.floor(val.avg * 100) / 100 + "</td>";
            con += "<td>" + val.pt + "</td></tr>";
        });
        if (get_mine === false) {
            con += "<tr style='font-weight:600; text-shadow: 0 0 3px #f00'>";
            con += "<td>" + data.my_week_rank + "</td>";
            con += "<td>" +
                "<a href='#' onclick='_locate(\"/user/" + my_uid + "\")'><img src='" + getQQicon(data.my_week_pt.qq) + "' height='32px' width='32px' /></a></td><td>" + data.my_week_pt.nick + "</td>";
            con += "<td>" + data.my_week_pt.cnt + "</td>";
            con += "<td>" + Math.floor(data.my_week_pt.avg * 100) / 100 + "</td>";
            con += "<td>" + data.my_week_pt.pt + "</td></tr>";
        }

        $("#week-rank").html(con);


        get_mine = false;
        con = "", last_i = 0, show_i = 0, pts = 0;
        $.each(data.all_rank, function(ind, val) {
            last_i++;
            if (pts !== val.pt) { show_i = last_i; pts = val.pt; }
            if (val.uid == my_uid) {
                con += "<tr style='background-color: #fec04e; font-weight:600; text-shadow: 0 0 3px #f00'>";
                get_mine = true;
            } else {
                con += "<tr>";
            }
            con += "<td>" + show_i + "</td>";
            con += "<td>" +
                "<a href='#' onclick='_locate(\"/user/" + val.uid + "\")'><img src='" + getQQicon(val.qq) + "' height='32px' width='32px' /></a></td><td>" + val.nick + "</td>";
            con += "<td>" + val.cnt + "</td>";
            con += "<td>" + Math.floor(val.avg * 100) / 100 + "</td>";
            con += "<td>" + val.pt + "</td> <td>" + val.wordcnt + "</td> <td>" + val.allcnt + "</td> </tr>";
        });
        if (get_mine === false) {
            con += "<tr style='font-weight:600; text-shadow: 0 0 3px #f00'>";
            con += "<td>" + data.my_rank + "</td>";
            con += "<td>" +
                "<a href='#' onclick='_locate(\"/user/" + my_uid + "\")'><img src='" + getQQicon(data.my_pt.qq) + "' height='32px' width='32px' /></a></td><td>" + data.my_pt.nick + "</td>";
            con += "<td>" + data.my_pt.cnt + "</td>";
            con += "<td>" + Math.floor(data.my_pt.avg * 100) / 100 + "</td>";
            con += "<td>" + data.my_pt.pt + "</td><td>" + data.my_pt.wordcnt + "</td> <td>" + data.my_pt.allcnt + "</td> </tr>";
        }

        $("#all-rank").html(con);
    }, 'json');
}

$(document).ready(load_rank());