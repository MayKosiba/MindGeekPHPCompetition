<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
require '../classes/tictactoe.php';

class tictactoeTest extends TestCase{

    public function testCreateGame(): tictactoe {
        $game = new tictactoe('multi');
        $this->assertSame('multi', $game->getGameType()); //make sure constructor works

        return $game;
    }

    /**
     * @depends testCreateGame
     */
    public function testPlayerMove(tictactoe $game): tictactoe {
        $this->assertIsArray($game->playerMoves(2)); //test player move
        return $game;
    }

    /**
     * @depends testCreateGame
     */
    public function testMoveOutofBounds(tictactoe $game): void {
        $this->expectException(InvalidArgumentException::class);
        $game->playerMoves(9); // 9 is outside of bounds 0-8
    }

    public function testWinner(): void {
        $game = new tictactoe('multi');
        $this->assertIsArray($game->playerMoves(0)); //player 1 moves
        $this->assertIsArray($game->playerMoves(8)); //player 2 moves
        $this->assertIsArray($game->playerMoves(2)); //player 1 moves
        $this->assertIsArray($game->playerMoves(4)); //player 2 moves
        $this->assertIsArray($game->playerMoves(1)); //player 1 moves
        $this->assertFalse($game->playerMoves(5)); //returns false cause player 1 already won
        $this->assertSame(array(0,1,2),$game->checkWinner()); //winner should occupy tiles 0, 1, 2
    }
}