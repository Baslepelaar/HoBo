/**
 * Copyright (c) 2017 Netixy Development
 */
function version() {
    console.log("Current version 1.1")
}
function playersOnline(id, ip){
    $.getJSON('https://mcapi.ca/query/' + ip + '/players',
        function(status){
            if(status.status==true){
                $('#' + id).html(status.players.online + " / " + status.players.max);
            }else{
                $('#' + id).html("Server Offline");
            }
    });
}