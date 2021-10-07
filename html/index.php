<?php
require 'vendor/mustache/mustache/src/Mustache/Autoloader.php';
require 'lang/strings.php';
Mustache_Autoloader::register();
$window = new Mustache_Engine(array(
    'loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__) . '/templates')
));
$context = array(
    'title'=> 'Tic Tac Toe'
);
echo $window->render($DIR['screen'], $context);
