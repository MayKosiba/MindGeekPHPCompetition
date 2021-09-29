<?php

require '../vendor/mustache/mustache/src/Mustache/Autoloader.php';

class tictactoe
{

    /**
     *  0-8 matrix representing the tic tac toe game
     * @var array $gameMatrix
     */
    private array $gameMatrix = array(
            0 => null,
            1 => null,
            2 => null,
            3 => null,
            4 => null,
            5 => null,
            6 => null,
            7 => null,
            8 => null
        );

    /**
     * Which players turn it currently is:
     * x for player 1,
     * o for player 2 or CPU
     * @var string $playersTurn
     */
    private string $playersTurn;

    /**
     * determines if single or multiplayer
     * 'single' or 'multi' for local player
     * 'online for internet play
     * @var string $gameType
     */
    private string $gameType;

    /**
     * number of turns that passed
     * @var int $nturns
     */
    private int $nturns = 0;

    /**
     * if current turn is CPU, only for singleplayer games
     * @var bool $cpuTurn
     */
    private bool $cpuTurn;

    /**
     * @var string|null $winner
     */
    private ?string $winner = null;

    /** array with all available winning combinations
     * @var array|int[][]
     */
    private array $winningPlays = array(
        array(0,3,6),
        array(0,1,2),
        array(2,5,8),
        array(3,4,5),
        array(0,4,8),
        array(6,7,8),
        array(1,4,7),
        array(2,4,6)
    );

    /**
     * @param String $game must be 'single' or 'multi' for local player and 'online' for internet play
     * @throws Exception Invalid Game Type
     */
    function __construct(string $game){
        if($this->isValidType($game)) {
            $this->gameType = $game;
        } else {
            throw new Exception('Invalid Game Type');
        }
        $player = rand(0,1);
        if($player == 1){
            $this->playersTurn = 'x';
        } else {
            $this->playersTurn = 'o';
        }
        if($game == 'single' && $this->playersTurn == 'o'){
            $this->cpuTurn = true;
            $this->playerMoves($this->getCPUMove());
        } else {
            $this->cpuTurn = false;
        }
    }

    /** returns a html rendered game screen with all the needed data to start playing a game
     * @return string
     */
    public function renderGameScreen(): string {
        try {
            $context = array();
            $matrix = $this->gameMatrix;
            $context['cpuTurn'] = $this->cpuTurn;
            $context['turn'] = strtoupper($this->playersTurn);
            $context['gameType'] = $this->gameType;
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

    /**
     * @return string
     */
    public function getPlayersTurn(): string {
        return $this->playersTurn;
    }

    /**
     * @return array
     */
    public function getGameMatrix(): array {
        return $this->gameMatrix;
    }

    /**
     * @return string
     */
    public function getGameType(): string {
        return $this->gameType;
    }

    /**
     * @return bool
     */
    public function isCpuTurn(): bool
    {
        return $this->cpuTurn;
    }

    /**
     * make player move
     * @param int $spot must be from 0-8 to assign a player to that spot
     * @return false|int[]|mixed false if no win condition, array with 3 elements for win condition
     * @throws Exception input must be int between 0 and 8
     */
    public function playerMoves(int $spot){
        if(!is_null($this->winner))
            return $this->checkWinner();

        if(!is_int($spot) || ($spot < 0 || $spot > 8))
            throw new Exception('input must be int between 0 and 8');

        if($this->gameMatrix[$spot] != null)
            return false;

        $this->gameMatrix[$spot] = $this->playersTurn;
        $win = $this->checkWinner();

        $player = 'player';
        if($this->isCpuTurn())
            $player = 'cpu';

        $gameStats = array(
            'win' => $win,
            'playerMove' => $spot,
            'player' => $player
        );

        if($win === false){
            $this->nextPlayer();
        } else{
            if($win == array(0,0,0)){
                $this->winner = 'tie';
            }
            $this->winner = $this->playersTurn;
        }
        $this->nturns++;

        return $gameStats;
    }

    /**
     * switches to the next players turn
     */
    private function nextPlayer(){
        if($this->playersTurn == 'x'){
            if($this->gameType == 'single')
                $this->cpuTurn = true;
            $this->playersTurn = 'o';
        } else {
            if($this->gameType == 'single')
                $this->cpuTurn = false;
            $this->playersTurn = 'x';
        }
    }

    /**
     * picks spot for cpu
     * @return false|int|mixed
     */
    public function getCPUMove(){
        //picks the best available play.
        foreach ($this->winningPlays as $play){
            if(!($this->gameMatrix[$play[0]] == 'x' || $this->gameMatrix[$play[1]] == 'x' || $this->gameMatrix[$play[2]] == 'x')){
                foreach ($play as $square){
                    if(is_null($this->gameMatrix[$square])){
                        return $square;
                    }
                }
            }
        }
        //if no winning plays are available play defense until game ties.
        foreach ($this->winningPlays as $play){
            foreach ($play as $square){
                if(is_null($this->gameMatrix[$square])){
                    return $square;
                }
            }
        }
        return false;
    }

    /** Checks if there is a winner yet.
     * @return false|int[]|mixed false is no winner, 1x3 array if win or tie
     */
    private function checkWinner(){
        $check = $this->playersTurn;
        $playerSpots = array_keys($this->gameMatrix, $check);
        foreach ($this->winningPlays as $win){
            if($win == array_intersect($win,$playerSpots)){
                return $win;
            }
        }
        if($this->nturns >= 8){
            return array(0,0,0);
        }
        return false;
    }

    /** Makes sure the game type is valid when initiating a game instance.
     * @param $gametype 'single', 'multi' or 'online'
     * @return bool
     */
    private function isValidType($gametype): bool {
        return $gametype == 'single' || $gametype == 'multi' || $gametype == 'online';
    }
}