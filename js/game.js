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
        let lock = document.getElementById('lock').innerText;
        if(lock == 'true') return;
        let spot = this.id.slice(-1);
        let gameOver = document.getElementById('game-over');
        if(gameOver.innerText == 'true') return;
        $.ajax({url: "classes/ajax.php",
            type: "post",
            dataType: 'html',
            data: {spot: spot, functionCall: "playerMoves"},
            success: function(result){
                let data = JSON.parse(result);
                if(data != false) {
                    data.forEach(e => animate(e));
                }
            },
            error: function (request, status, error) {
                //placeholder
            }
        });
    });

    $('#btn_replay').click(function() {
        let gameType = document.getElementById('game-type').innerText;
        $.ajax({url: "classes/ajax.php",
            type: "post",
            dataType: 'html',
            data: {gametype: gameType, functionCall: "startGame"},
            success: function(result){
                $("#game-window").html(result);
            },
            error: function (request, status, error) {
                //placeholder
            }});
    });

};

function animate(turn){
    if(turn.player == 'cpu'){
        lockScreen();
        let title = document.getElementById('player-title');
        let count = 0;
        let rand = Math.floor(Math.random() * 5) + 2;
        title.innerText = 'CPU is moving';
        let textanimation = setInterval(function(){
            title.innerText += ".";
            if(count > rand){
                clearInterval(textanimation);
                makeTurn(turn);
                lockScreen();
            }
            count++;
        }, 500);
    } else {
        makeTurn(turn);
    }

}

function makeTurn(turn){
    let player = document.getElementById('player-turn');
    let tile = document.getElementById('block_' + turn.playerMove);
    let title = document.getElementById('player-title');
    if (player.innerText == 'O') {
        tile.innerHTML = "<img src=\"../assets/circle.svg\">";
        title.innerText = "Player X moves";
    } else {
        tile.innerHTML = "<img src=\"../assets/x.svg\">";
        title.innerText = "Player O moves";
    }
    if(typeof turn.win == "object"){
        let gameOver = document.getElementById('game-over');
        let replayBtn = document.getElementById('btn_replay');
        gameOver.innerText = 'true';
        replayBtn.hidden = false;
        if(turn.win[0] == 0 && turn.win[1] == 0 && turn.win[2] == 0){
            title.innerText = "Tie!";
            $('.block').css('background','rgb(29, 155, 240)');
        } else {
            turn.win.forEach(function (item) {
                let square = document.getElementById('block_' + item);
                square.style.background = 'rgb(29, 155, 240)';
                if(turn.player == 'player') {
                    title.innerText = "Player " + player.innerText + " Wins!";
                } else {
                    title.innerText = "CPU Wins!";
                }
            });
        }
    }
    player.innerText == 'O' ? player.innerText = 'X' : player.innerText = 'O';
}

/**
 * prevents players from clicking in the middle of a on going turn
 * if lock is enabled when called disable lock instead
 * else lock
 */
function lockScreen(){
    let lock = document.getElementById('lock');
    if(lock.innerText == 'false'){
        lock.innerText = 'true';
        return true;
    } else {
        lock.innerText = 'false';
        return false;
    }
}