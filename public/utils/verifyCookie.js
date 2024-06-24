setInterval(function() {
    var jwt = getCookie("jwt");

    if(jwt == null) {
        logout();
    }
}, 10000); 

