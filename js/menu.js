window.onload = () => {
    let singleplayer_Btn = document.getElementById('btn_single');
    singleplayer_Btn.onclick = () => {
        $.ajax({url: "classes/ajax.php",
            type: "post",
            dataType: 'html',
            data: {gametype: "single", functionCall: "loadSinglePlayer"},
            success: function(result){
                $("#game-window").html(result);
            },
            error: function (request, status, error) {
                //placeholder
            }});
    }
}