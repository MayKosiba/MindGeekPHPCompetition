<?php
/**
 * *************************************************************************
 * *                           TIC TAC TOE                                **
 * *************************************************************************
 * @author      May Kosiba                                                **
 * *************************************************************************
 * ************************************************************************ */
/**
 * This file handles all the ajax calls the client would make *
 */
require 'tictactoe.php';

session_start();

$functionCall = filter_var($_POST['functionCall'],FILTER_SANITIZE_STRING);

/**
 * User wants to start a new game
 */
if($functionCall == 'startGame'){
    $gametype = filter_var($_POST['gametype'], FILTER_SANITIZE_STRING);

    try {
        $game = new tictactoe($_POST['gametype']);
    } catch (Exception $e) {
        die($e->getMessage());
    }

    echo $game->renderGameScreen();
} elseif (isset($_SESSION['game'])){
    $game = unserialize($_SESSION['game']);
} else {
    die('must start a new game first');
}

/**
 * Player makes a move
 */
if($functionCall == 'playerMoves'){
    $spot = filter_var($_POST['spot'], FILTER_SANITIZE_NUMBER_INT);

    try {
        $player = $game->playerMoves($spot);
        if(!$player['win']){
            if($game->isCpuTurn()){
                $cpu = $game->playerMoves($game->getCPUMove());
            }
        }
    } catch (Exception $e) {
        die($e->getMessage());
    }

    if(isset($cpu)) {
        echo json_encode(array($player, $cpu));
    } else {
        echo json_encode(array($player));
    }
}
$_SESSION['game'] = serialize($game);