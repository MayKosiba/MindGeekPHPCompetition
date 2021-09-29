<?php
require 'tictactoe.php';
session_start();
$functionCall = $_POST['functionCall'];

if($functionCall == 'startGame'){
    try {
        $game = new tictactoe($_POST['gametype']);
        echo $game->renderGameScreen();
    } catch (Exception $e) {
        die($e->getMessage());
    }
} elseif (isset($_SESSION['game'])){
    $game = unserialize($_SESSION['game']);
} else {
    die('must start a new game first');
}

if($functionCall == 'playerMoves'){
    try {
        $player = $game->playerMoves($_POST['spot']);
        if(!$player['win']){
            if($game->isCpuTurn()){
                $cpu = $game->playerMoves($game->getCPUMove());
            }
        }
        if(isset($cpu)) {
            echo json_encode(array($player, $cpu));
        } else {
            echo json_encode(array($player));
        }
    } catch (Exception $e) {
        echo json_encode($e->getMessage());
    }
}
$_SESSION['game'] = serialize($game);