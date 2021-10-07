window.onload = () => {
    let singleplayer_Btn = document.getElementById('btn_single');
    singleplayer_Btn.onclick = () => {
        $.ajax({url: "classes/ajax.php",
            type: "post",
            dataType: 'html',
            data: {gametype: "single", functionCall: "startGame"},
            success: function(result){
                $("#game-window").html(result);
            },
            error: function (request, status, error) {
                //placeholder
            }});
    }
    let multiplayer_Btn = document.getElementById('btn_multi');
    multiplayer_Btn.onclick = () => {
        $.ajax({url: "classes/ajax.php",
            type: "post",
            dataType: 'html',
            data: {gametype: "multi", functionCall: "startGame"},
            success: function(result){
                $("#game-window").html(result);
            },
            error: function (request, status, error) {
                //placeholder
            }});
    }

}