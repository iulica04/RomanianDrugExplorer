setInterval(function() {
    var jwt = getCookie("jwt");
    console.log(jwt);

    if(jwt == null) {
        logout();
        
    }
}, 10000); // 10000 milisecunde = 10 secunde
