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
                if(result != 'false'){
                    $("#game-window").html(result);
                }
            },
            error: function (request, status, error) {
                //placeholder
            }});
    });

};