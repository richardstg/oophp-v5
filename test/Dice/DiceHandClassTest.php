<?php

namespace Rist\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DiceHand.
 */
class DiceHandClassTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $diceHand = new DiceHand();
        $this->assertInstanceOf("\Rist\Dice\DiceHand", $diceHand);

        $res = sizeof($diceHand->dices);
        $exp = 5;
        $this->assertEquals($exp, $res);
    }

    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectWithArguments()
    {
        $diceHand = new DiceHand(3);
        $this->assertInstanceOf("\Rist\Dice\DiceHand", $diceHand);

        $res = sizeof($diceHand->dices);
        $exp = 3;
        $this->assertEquals($exp, $res);
    }

    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testRollDices()
    {
        $diceHand = new DiceHand();
        $diceHand->rollDices();

        foreach ($diceHand->values() as $value) {
            $this->assertTrue($value <= 6 && $value >= 1);
        }
    }
}
