function reg() {
    $("#reg").html("Waiting");
    $.post("/api/register",
        {
            "uname":$("#uname").val(),
            "upass":$("#upass").val(),
            "invite":$("#invc").val(),
            "nick":$("#unick").val(),
            "qq":$("#qqq").val(),
            "school":$("#school").val(),
        },
        function(data) {
            if (data.code === 0) {
                alert(data.message);
                window.location.href="/";
            } else {
                alert(data.message);
                $("#reg").html("注册");
            }
        }, 'json');
}