/**
 * Once HTML Dom loads attach onclick functions to buttons.
 * @type {number}
 */
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
        if(gameOver.innerText == 'true') return;
        if(document.getElementById('block_' + spot).innerHTML != '\n        ') return;
        $.ajax({url: "classes/ajax.php",
            type: "post",
            dataType: 'html',
            data: {spot: spot, functionCall: "playerMoves"},
            success: function(result){
                let data = JSON.parse(result);
                console.log(data);
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
                    let gameOver = document.getElementById('game-over');
                    let replayBtn = document.getElementById('btn_replay');
                    gameOver.innerText = 'true';
                    replayBtn.hidden = false;
                    if(data[0] == 0 && data[1] == 0 && data[2] == 0){
                        title.innerText = "Tie!";
                        $('.block').css('background','rgb(29, 155, 240)');
                    } else {
                        data.forEach(function (item) {
                            let square = document.getElementById('block_' + item);
                            square.style.background = 'rgb(29, 155, 240)';
                            title.innerText = "Player " + player.innerText + " Wins!";
                        });
                    }
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