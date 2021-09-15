<?php

require 'tictactoe.php';
require 'manager.php';

$gametype = $_POST['gametype'];

if(tictactoe::isValidType($gametype)) {
    $_SESSION['gameManger'] = new manager($gametype);
} else {
    die('Invalid Game');
}

echo $_SESSION['gameManger']->loadGameScreen();
