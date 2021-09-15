<?php

require '../vendor/mustache/mustache/src/Mustache/Autoloader.php';
require '../lang/strings.php';


class manager {
    private tictactoe $game;
    private Mustache_Engine $window;
    /**
     * @throws Exception
     */
    public function __construct($gametype){
        $this->game = new tictactoe($gametype);
        Mustache_Autoloader::register();
        $this->window = new Mustache_Engine(array(
            'loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__) . '/../templates')
        ));
     }

     public function loadGameScreen(): string {
         try {
             return $this->window->render('tiles');
         } catch (Exception $e){
             return $e->getMessage();
         }
     }

}