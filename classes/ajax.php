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
        $return = $game->playerMoves($_POST['spot']);
        echo json_encode($return);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
$_SESSION['game'] = serialize($game);