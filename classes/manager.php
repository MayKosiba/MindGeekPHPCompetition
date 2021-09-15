<?php

require '../vendor/mustache/mustache/src/Mustache/Autoloader.php';
require 'tictactoe.php';

class manager {
    private tictactoe $game;
    /**
     * @throws Exception
     */
    public function __construct($gametype){
        if(tictactoe::isValidType($gametype)) {
            $this->game = new tictactoe($gametype);
        } else {
            throw new Exception('Invalid gametype');
        }
     }

     public function renderGameScreen(): string {
         try {
             $context = array();
             $matrix = $this->game->getGameMatrix();
             $turn = $this->game->getPlayersTurn();
             if($turn == 'x'){
                 $context['turn'] = 'X';
                 $context['cpuTurn'] = false;
             } elseif ($turn == 'o' && $this->game->getGameType() == 'single'){
                 $context['cpuTurn'] = true;
             } else {
                 $context['turn'] = 'O';
                 $context['cpuTurn'] = false;
             }

             $i = 0;
             $context['array'] = array();
             foreach ($matrix as $tile){
                 $context['array'][]['spot'] = $i;
                 if($tile == 'x'){
                     $context['array'][$i]['is_x'] = true;
                     $context['array'][$i]['is_o'] = false;
                 } elseif ($tile == 'o'){
                     $context['array'][$i]['is_o'] = true;
                     $context['array'][$i]['is_x'] = false;
                 } else {
                     $context['array'][$i]['is_x'] = false;
                     $context['array'][$i]['is_o'] = false;
                 }
                 $i++;
             }
             Mustache_Autoloader::register();
             $window = new Mustache_Engine(array(
                 'loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__) . '/../templates')
             ));
             return $window->render('tiles',$context);
         } catch (Exception $e){
             return $e->getMessage();
         }
     }

     public function playerMoves($move): bool {
        $move = intval($move);
        if(!is_int($move) || ($move < 0 || $move > 8)){
            throw new Exception('input must be int between 0 and 8');
        }
        return $this->game->playerMoves($move);
     }
}