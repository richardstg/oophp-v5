<?php

namespace Rist\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DiceHand.
 */
class DiceGameComputerPlayClassTest extends TestCase
{
    /**
     * Test computerPlay method
     */
    public function testComputerPlay()
    {
        $diceGame = new DiceGame();
        $diceGame->computerPlay();
        $this->assertTrue($diceGame->protocol["computer"] === $diceGame->computerRoundPoints);
    }

    /**
     * Test computerNumberOfRolls method
     */
    public function testcomputerNumberOfRolls()
    {
        $diceGame = new DiceGame();
        $diceGame->protocol["computer"] = 0;
        $diceGame->protocol["player"] = 0;
        $numberOfRolls = $diceGame->computerNumberOfRolls();
        $this->assertEquals($numberOfRolls, 2);

        $diceGame->protocol["player"] += 10;
        $numberOfRolls = $diceGame->computerNumberOfRolls();
        $this->assertEquals($numberOfRolls, 3);

        $diceGame->protocol["player"] += 10;
        $numberOfRolls = $diceGame->computerNumberOfRolls();
        $this->assertEquals($numberOfRolls, 4);

        $diceGame->protocol["player"] += 10;
        $numberOfRolls = $diceGame->computerNumberOfRolls();
        $this->assertEquals($numberOfRolls, 5);

        $diceGame->protocol["player"] += 10;
        $numberOfRolls = $diceGame->computerNumberOfRolls();
        $this->assertEquals($numberOfRolls, 6);

        $diceGame->protocol["player"] += 10;
        $numberOfRolls = $diceGame->computerNumberOfRolls();
        $this->assertEquals($numberOfRolls, 7);

        $diceGame->protocol["player"] += 10;
        $numberOfRolls = $diceGame->computerNumberOfRolls();
        $this->assertEquals($numberOfRolls, 9);

        $diceGame->protocol["player"] += 10;
        $numberOfRolls = $diceGame->computerNumberOfRolls();
        $this->assertEquals($numberOfRolls, 13);

        $diceGame->protocol["player"] += 10;
        $numberOfRolls = $diceGame->computerNumberOfRolls();
        $this->assertEquals($numberOfRolls, 18);

        $diceGame->protocol["player"] += 10;
        $numberOfRolls = $diceGame->computerNumberOfRolls();
        $this->assertEquals($numberOfRolls, 18);
    }
}
