<?php

class tictactoe
{

    /**
     *  0-8 matrix representing the tic tac toe game
     * @var array $gameMatrix
     */
    private array $gameMatrix;

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
    private int $nturns;

    private array $winningPlays = array(
        array(0,1,2),
        array(3,4,5),
        array(6,7,8),
        array(0,3,6),
        array(1,4,7),
        array(2,5,8),
        array(0,4,8),
        array(2,4,6)
    );
    /**
     * string $game must be 'single' or 'multi' for local player and 'online' for internet play
     * @throws Exception
     */
    function __construct(string $game){
        $this->setGameType($game);
        $this->gameMatrix = array(
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
        $player = rand(0,1);
        if($player == 1){
            $this->playersTurn = 'x';
        } else {
            $this->playersTurn = 'o';
        }
        $this->nturns = 0;
    }

    /**
     * @return string
     */
    public function getPlayersTurn(): string {
        return $this->playersTurn;
    }

    /**
     * @param int $playersTurn
     */
    public function setPlayersTurn(int $playersTurn): void {
        if($playersTurn == 0 || $playersTurn == 1) {
            $this->playersTurn = $playersTurn;
        } else {
            throw new Exception('Player value must be 0 or 1');
        }
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
     * @param string $gameType
     */
    public function setGameType(string $gameType): void {
        if($gameType == 'single' || $gameType == 'multi' || $gameType == 'online'){
            $this->gameType = $gameType;
        } else {
            throw new Exception('Invalid gameType');
        }
    }

    /**
     * make player move,
     * $spot must be from 0-8 to assign a player to that spot
     * @param int $spot
     */
    public function playerMoves(int $spot): bool{
        if($this->gameMatrix[$spot] != null){
           return false;
        }
        $this->gameMatrix[$spot] = $this->playersTurn;
        $this->nextPlayer();
        if($this->playersTurn == 'o' && $this->gameType == 'single'){
            $this->cpuMoves();
        }
        return true;
    }

    /**
     * switches to the next players turn
     */
    public function nextPlayer(){
        if($this->playersTurn == 'x'){
            $this->playersTurn = 'o';
        } else {
            $this->playersTurn = 'x';
        }
    }

    private function cpuMoves(){
        foreach ($this->winningPlays as $play){
            $spot = array_search(null, $play);
            if($spot){
                break;
            }
        }
        $this->playerMoves($spot);
    }

    public function checkWinner(){
        $check = $this->playersTurn;
        $playerSpots = array_keys($this->gameMatrix, $check);
        foreach ($this->winningPlays as $win){
            if($win == array_intersect($win,$playerSpots)){
                return $win;
            }
        }
        return false;
    }


    public static function isValidType($gametype): bool {
        return $gametype == 'single' || $gametype == 'multi' || $gametype == 'online';
    }
}