<?php
namespace Rist\Dice;

/**
 * Dice game.
 */
class DiceGame
{
    /**
     * @var DiceHand    $diceHand       DiceHand object.
     * @var int         $numDices       Number of dices.
     * @var int         $numPlayers     Number of players.
     * @var int         $pointsRound    Points of round.
     * @var array       $protocol       Game stats, points of each player.
     */
    public $diceHand;
    public $numDices;
    public $numPlayers;
    public $playerRoundPoints;
    public $computerRoundPoints;
    public $protocol;
    public $playOrder;
    public $dice;
    public $playerPreGameScore;
    public $computerPreGameScore;

    /**
     * Constructor to create a DiceGame.
     *
     * @param int $numDices Number of dices to create, defaults to five.
     */
    public function __construct(int $numDices = 5)
    {
        $this->diceHand  = new DiceHand($numDices);
        $this->dice = new Dice();
        $this->numDices = $numDices;
        $this->playOrder = null;
        $this->protocol = ["player" => 0,"computer" => 0];
        $this->playerPreGameScore = 0;
        $this->computerPreGameScore = 0;
        $this->playerRoundPoints = 0;
        $this->computerRoundPoints = 0;
    }

    /**
     * Pre-game roll.
     *
     * @return string.
     */
    public function preGameRoll()
    {
        $playerScore = $this->dice->rollDice();
        $computerScore = $this->dice->rollDice();

        while ($playerScore === $computerScore) {
            $playerScore = $this->dice->rollDice();
            $computerScore = $this->dice->rollDice();
        }

        $this->playerPreGameScore = $playerScore;
        $this->computerPreGameScore = $computerScore;

        $this->playOrder = $playerScore > $computerScore ? "player" : "computer";

        return $this->playOrder;
    }

     /**
     * Player play.
     *
     * @return void.
     */
    public function playerPlay()
    {
        $this->diceHand->rollDices();
        // Check if the roll was valid
        if ($this->validRoll($this->diceHand->values())) {
            $this->playerRoundPoints += array_sum($this->diceHand->values());
            // Check if the roll resulted in a total of over 100 points, if so
            // add the points of the round to the total
            if ($this->protocol["player"] + $this->playerRoundPoints >= 100) {
                $this->playerStopRolling();
            }
            return $this->diceHand->values();
        }

        $this->playerRoundPoints = 0;

        return $this->diceHand->values();
    }

    /**
     * Determine if roll was valid, that means no number 1 among values.
     *
     * @return boolean.
     */
    public function validRoll($values)
    {
        return !in_array(1, $values);
    }

    /**
     * Computer play.
     *
     * @return void.
     */
    public function computerPlay()
    {
        $i = 0;

        while ($i <= 1) {
            $this->diceHand->rollDices();

            if (!in_array(1, $this->diceHand->values())) {
                $this->computerRoundPoints += array_sum($this->diceHand->values());

                if ($this->protocol["computer"] + $this->computerRoundPoints >= 100) {
                    break;
                }
                $i++;
                continue;
            } else {
                $this->computerRoundPoints = 0;
                break;
            }
        }
        $this->protocol["computer"] += $this->computerRoundPoints;
    }

    /**
     * Player stop round.
     *
     * @return void.
     */
    public function playerStopRolling()
    {
        $this->protocol["player"] += $this->playerRoundPoints;
    }

    /**
     * Determine if there is a winner.
     *
     * @return void.
     */
    public function determineWinner()
    {
        if ($this->protocol["computer"] >= 100) {
            return "computer";
        } elseif ($this->protocol["player"] >= 100) {
            return "player";
        }

        return null;
    }

    /**
     * Reset round points in order to start a new round.
     *
     * @return void.
     */
    public function resetRoundPoints()
    {
        $this->playerRoundPoints = 0;
        $this->computerRoundPoints = 0;
    }
}
