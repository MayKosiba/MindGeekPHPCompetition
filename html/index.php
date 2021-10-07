<?php
/*
 * Renders homepage
 * This webpage uses Mustache templates for rendering HTML
 */

require 'vendor/mustache/mustache/src/Mustache/Autoloader.php';

Mustache_Autoloader::register();

$window = new Mustache_Engine(array(
    'loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__) . '/templates')
));

$context = array(
    'title'=> 'Tic Tac Toe'
);
echo $window->render('screen', $context);
