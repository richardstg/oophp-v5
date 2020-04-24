<?php
namespace Rist\Dice;

// include __DIR__ . '/Dice.php';

/**
 * Showing off a standard class with methods and properties.
 */
class DiceHand
{
    /**
     * @var DiceHistogram       $dices          Array consisting of dices.
     * @var Histogram           $diceHand       Histogram object.
     * @var int                 $values         Array consisting of last roll of the dices.
     * @var int                 $numDices       Number of dices.
     */
    public $dices;
    private $values;
    private $numDices;
    public $histogram;

    /**
     * Constructor to create a DiceHand.
     *
     * @param int $numDices Number of dices to create, defaults to five.
     */
    public function __construct(int $numDices = 5)
    {
        $this->dices  = [];
        $this->values = [];
        $this->numDices = $numDices;
        $this->histogram = new Histogram();

        for ($i=0; $i < $numDices; $i++) {
            //array_push($this->dices, new Dice());
            array_push($this->dices, new DiceHistogram());
            array_push($this->values, null);
        }
    }

    /**
     * Roll the dices.
     *
     * @return void.
     */
    public function rollDices()
    {
        for ($i=0; $i < $this->numDices; $i++) {
            $this->values[$i] = $this->dices[$i]->rollDice();
            $this->histogram->injectData($this->dices[$i]);
        }
    }

    /**
     * Get values of dices from last roll.
     *
     * @return array with values of the last roll.
     */
    public function values()
    {
        return $this->values;
    }

    // /**
    //  * Get the sum of all dices.
    //  *
    //  * @return int as the sum of all dices.
    //  */
    // public function sum()
    // {
    //     return array_sum($this->values);
    // }

    // /**
    //  * Get the average of all dices.
    //  *
    //  * @return float as the average of all dices.
    //  */
    // public function average()
    // {
    //     return $this->sum() / $this->numDices;
    // }
}
