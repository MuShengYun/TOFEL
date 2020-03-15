function userLogin(uname, upass) {
    $.post("/api/user_login", { "uname": uname, "upass": upass },
        function(data){
            if(data.code != 0) alert("(" + data.code + ")" + data.message);
            if (data.code == 0) {
                window.location.href = "/main";
            } else {
				window.location.href = "/";
			}
        },"json");
}
