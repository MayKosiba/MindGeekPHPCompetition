/**
 * On window load add button onclick functions
 */
window.onload = () => {
    let singleplayer_Btn = document.getElementById('btn_single');
    singleplayer_Btn.onclick = () => {
        $.ajax({url: "classes/ajax.php",
            type: "post",
            dataType: 'html',
            data: {gametype: "single", functionCall: "startGame"}
        })
        .done(function(result){
            $("#game-window").html(result);
        })
        .fail(function (response) {
            //placeholder
        });
    }
    let multiplayer_Btn = document.getElementById('btn_multi');
    multiplayer_Btn.onclick = () => {
        $.ajax({url: "classes/ajax.php",
            type: "post",
            dataType: 'html',
            data: {gametype: "multi", functionCall: "startGame"}
        })
        .done(function(result) {
            $("#game-window").html(result);
        })
        .fail(function (response) {
            //placeholder
        });
    }
}