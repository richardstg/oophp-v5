<?php

namespace Rist\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DiceHand.
 */
class HistogramClassTest extends TestCase
{
    /**
     * Test getSerie method
     */
    public function testgetSerie()
    {
        $dice = new DiceHistogram();
        $histogram = new Histogram();
        $histogram->injectData($dice);
        $this->assertEquals(sizeof($histogram->getSerie()), 0);

        $i = 1;

        while ($i < 10) {
            $dice->rollDice();
            $histogram->injectData($dice);
            $this->assertEquals(sizeof($histogram->getSerie()), $i);
            $i += 1;
        }
    }

    /**
     * Test printWithMinAndMax method
     */
    public function testprintWithMinAndMaxValid()
    {
        $histogram = new Histogram();
        $dice = new DiceHistogram();
        $histogram->injectData($dice);

        $expected = "1: *\n";
        $this->expectOutputString($expected);
        $histogram->printWithMinAndMax(0, 1);
    }

    /**
     * Test printWithMinAndMax method
     */
    public function testprintWithMinAndMaxInvalid()
    {
        $histogram = new Histogram();
        $dice = new DiceHistogram();
        $histogram->injectData($dice);

        $expected = "1: \n";
        $this->expectOutputString($expected);
        $histogram->printWithMinAndMax(0, 100);
    }

    /**
     * Test printWithMin method
     */
    public function testprintWithMinValid()
    {
        $histogram = new Histogram();
        $dice = new DiceHistogram();
        $histogram->injectData($dice);

        $expected = "1: *\n";
        $this->expectOutputString($expected);
        $histogram->printWithMin(0, 1);
    }

    /**
     * Test printWithMin method
     */
    public function testprintWithMinInvalid()
    {
        $histogram = new Histogram();
        $dice = new DiceHistogram();
        $histogram->injectData($dice);

        $expected = "1: \n";
        $this->expectOutputString($expected);
        $histogram->printWithMin(0, -1);
    }

    /**
     * Test printWithMax method
     */
    public function testprintWithMaxValid()
    {
        $histogram = new Histogram();
        $dice = new DiceHistogram();
        $histogram->injectData($dice);

        $expected = "1: *\n";
        $this->expectOutputString($expected);
        $histogram->printWithMax(0, 1);
    }

    /**
     * Test printWithMax method
     */
    public function testprintWithMaxinvalid()
    {
        $histogram = new Histogram();
        $dice = new DiceHistogram();
        $histogram->injectData($dice);

        $expected = "1: \n";
        $this->expectOutputString($expected);
        $histogram->printWithMax(0, 7);
    }

    /**
     * Test getAsText method
     */
    public function testgetAsText()
    {
        $histogram = new Histogram();
        $dice = new DiceHistogram();
        $dice->rollDice();
        $histogram->injectData($dice);
        $expected = "1: " . str_repeat("*", $histogram->getSerie()[0]) . "\n";
        $this->expectOutputString($expected);
        $histogram->getAsText();
    }
}
