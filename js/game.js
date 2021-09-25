var checkExist = setInterval(function() {
    if ($('.play-area').length) {
        attachEventListeners();
        clearInterval(checkExist);
    }
}, 100);

function attachEventListeners() {
    $('.block').click(function (){
        let spot = this.id.slice(-1);
        let gameOver = document.getElementById('game-over');
        if(gameOver.innerText == 'true'){
            return
        }
        $.ajax({url: "classes/ajax.php",
            type: "post",
            dataType: 'html',
            data: {spot: spot, functionCall: "playerMoves"},
            success: function(result){
                let data = JSON.parse(result);
                let player = document.getElementById('player-turn');
                let tile = document.getElementById('block_' + spot);
                let title = document.getElementById('player-title');
                if (player.innerText == 'O') {
                    tile.innerHTML = "<img src=\"../assets/circle.svg\">";
                    title.innerText = "Player X moves";
                } else {
                    tile.innerHTML = "<img src=\"../assets/x.svg\">";
                    title.innerText = "Player O moves";
                }
                if(typeof data == "object"){
                    data.forEach(function(item){
                       let square = document.getElementById('block_'+item);
                       square.style.background = 'rgb(29, 155, 240)';
                       title.innerText = "Player " + player.innerText + " Wins!";
                        let gameOver = document.getElementById('game-over');
                        gameOver.innerText = 'true';
                        let replayBtn = document.getElementById('btn_replay');
                        replayBtn.hidden = false;
                    });
                }
                player.innerText == 'O' ? player.innerText = 'X' : player.innerText = 'O';
            },
            error: function (request, status, error) {
                //placeholder
            }});
    });

    $('#btn_replay').click(function() {
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
    });

};