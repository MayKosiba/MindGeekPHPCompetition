<?php
require 'manager.php';
session_start();
$functionCall = $_POST['functionCall'];

if(isset($_SESSION['gameManger'])){
    $manager = unserialize($_SESSION['gameManger']);
} else {
    die('must start a new game first');
}

if($functionCall == 'startGame') {
    $manager = new manager($_POST['gametype']);
    echo $manager->renderGameScreen();
}

if($functionCall == 'playerMoves'){
    if($manager->playerMoves($_POST['spot'])){
        echo $manager->renderGameScreen();
    } else {
        echo 'false';
    }
}

$_SESSION['gameManger'] = serialize($manager);