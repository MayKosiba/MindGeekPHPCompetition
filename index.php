<?php
require 'vendor/mustache/mustache/src/Mustache/Autoloader.php';
require 'lang/strings.php';
Mustache_Autoloader::register();
$m = new Mustache_Engine(array(
    'loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__) . '/templates')
));
echo $m->render($DIR['gameScreen']); // "Hello, World!"