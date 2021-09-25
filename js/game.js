var checkExist = setInterval(function() {
    if ($('.play-area').length) {
        attachEventListeners();
        clearInterval(checkExist);
    }
}, 100);

function attachEventListeners() {
    $('.block').click(function (){
        let spot = this.id.slice(-1);

        $.ajax({url: "classes/ajax.php",
            type: "post",
            dataType: 'html',
            data: {spot: spot, functionCall: "playerMoves"},
            success: function(result){
                console.log(result);
                if(result == 'game already has a winner'){
                    return;
                }
                let player = document.getElementById('player-turn');
                let tile = document.getElementById('block_' + spot);
                let title = document.getElementById('player-title');
                if(player.innerText == 'O'){
                    tile.innerHTML = "<img src=\"../assets/circle.svg\">";
                    player.innerText = 'X';
                    title.innerText = "Player X moves";
                } else {
                    tile.innerHTML = "<img src=\"../assets/x.svg\">";
                    player.innerText = 'O';
                    title.innerText = "Player O moves";
                }
            },
            error: function (request, status, error) {
                //placeholder
            }});
    });

};