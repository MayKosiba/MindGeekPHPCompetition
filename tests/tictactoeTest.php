<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
require '../classes/tictactoe.php';

class tictactoeTest extends TestCase{

    public function testCreateGame(): tictactoe {
        $game = new tictactoe('multi');
        $this->assertSame('multi', $game->getGameType());

        return $game;
    }

    /**
     * @depends testCreateGame
     */
    public function testPlayerMove(tictactoe $game): tictactoe {

        $this->assertIsArray($game->playerMoves(2));
        return $game;
    }

    /**
     * @depends testCreateGame
     */
    public function testMoveOutofBounds(tictactoe $game): void {
        $this->expectException(InvalidArgumentException::class);
        $game->playerMoves(9);
    }
}