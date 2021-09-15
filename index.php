<?php
require 'vendor/mustache/mustache/src/Mustache/Autoloader.php';
require 'lang/strings.php';
require 'classes/tictactoe.php';
session_start();
unset($_SESSION['gameManager']);
Mustache_Autoloader::register();
$window = new Mustache_Engine(array(
    'loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__) . '/templates')
));
$game = new Mustache_Engine(array(
    'loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__) . '/templates')
));
$context = array(
    'window'=> $game->render($DIR['menu']),
    'title'=> 'Tic Tac Toe'
);

echo $window->render($DIR['screen'], $context);
