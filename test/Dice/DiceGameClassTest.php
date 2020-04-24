<?php

namespace Rist\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DiceHand.
 */
class DiceGameClassTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $diceGame = new DiceGame();
        $this->assertInstanceOf("\Rist\Dice\DiceGame", $diceGame);

        $res = $diceGame->numDices;
        $exp = 1;
        $this->assertEquals($exp, $res);
    }

    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectWithArguments()
    {
        $diceGame = new DiceGame(3);
        $this->assertInstanceOf("\Rist\Dice\DiceGame", $diceGame);

        $res = $diceGame->numDices;
        $exp = 3;
        $this->assertEquals($exp, $res);
    }

    /**
     * Test preGameRoll method
     */
    public function testPreGameRoll()
    {
        $diceGame = new DiceGame();
        $res = $diceGame->preGameRoll();

        $playerPreGameScore = $diceGame->playerPreGameScore;
        $computerPreGameScore = $diceGame->computerPreGameScore;

        $exp = $playerPreGameScore > $computerPreGameScore ? "player" : "computer";

        $this->assertEquals($exp, $res);
    }

    /**
     * Test playerPlay method
     */
    public function testPlayerPlay()
    {
        $diceGame = new DiceGame(3);
        $res = sizeof($diceGame->playerPlay());
        $exp = 3;

        $this->assertEquals($exp, $res);
    }

    /**
     * Test validRoll method
     */
    public function testInvalidRoll()
    {
        $diceGame = new DiceGame();
        $res = $diceGame->validRoll([1, 2]);

        $this->assertFalse($res);
    }

    /**
     * Test validRoll method
     */
    public function testValidRoll()
    {
        $diceGame = new DiceGame();
        $res = $diceGame->validRoll([2, 2]);

        $this->assertTrue($res);
    }

    // /**
    //  * Test computerPlay method
    //  */
    // public function testComputerPlay()
    // {
    //     $diceGame = new DiceGame();
    //     $diceGame->computerPlay();
    //     $this->assertTrue($diceGame->protocol["computer"] === $diceGame->computerRoundPoints);
    // }

    /**
     * Test playerStopRolling method
     */
    public function testPlayerStopRolling()
    {
        $diceGame = new DiceGame();
        $diceGame->playerRoundPoints = 1;
        $diceGame->playerStopRolling();
        $this->assertTrue($diceGame->protocol["player"] === 1);
    }

    /**
     * Test determineWinner method - computer win
     */
    public function testDetermineWinner()
    {
        $diceGame = new DiceGame();
        $diceGame->protocol["computer"] = 101;
        $exp = "computer";
        $res = $diceGame->determineWinner();
        $this->assertEquals($exp, $res);

        $diceGame->protocol["computer"] = 0;
        $diceGame->protocol["player"] = 0;

        $diceGame->protocol["player"] = 101;
        $exp = "player";
        $res = $diceGame->determineWinner();
        $this->assertEquals($exp, $res);

        $diceGame->protocol["computer"] = 0;
        $diceGame->protocol["player"] = 0;

        $diceGame->protocol["player"] = 10;
        $diceGame->protocol["computer"] = 10;
        $exp = null;
        $res = $diceGame->determineWinner();
        $this->assertEquals($exp, $res);
    }

    /**
     * Test resetRoundPoints method
     */
    public function testResetRoundPoints()
    {
        $diceGame = new DiceGame();
        $diceGame->playerRoundPoints = 101;
        $diceGame->resetRoundPoints();
        $exp = 0;
        $res = $diceGame->playerRoundPoints;
        $this->assertEquals($exp, $res);
    }
}
