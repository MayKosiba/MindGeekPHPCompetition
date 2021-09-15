<?php
require 'vendor/mustache/mustache/src/Mustache/Autoloader.php';
require 'lang/strings.php';
require 'classes/tictactoe.php';
session_start();

Mustache_Autoloader::register();
$window = new Mustache_Engine(array(
    'loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__) . '/templates')
));

$game = new Mustache_Engine(array(
    'loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__) . '/templates')
));


$context = array(
    'window'=> $game->render($DIR['menu']),
    'title'=> 'Title placeholder'
);

echo $window->render($DIR['screen'], $context); // "Hello, World!"
