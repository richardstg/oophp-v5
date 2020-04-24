<?php

namespace Rist\Dice;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class DiceController implements AppInjectableInterface
{
    use AppInjectableTrait;



    /**
     * @var string $db a sample member variable that gets initialised
     */
    // private $db = "not active";



    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    // public function initialize() : void
    // {
    //     // Use to initialise member variables.
    //     $this->db = "active";

    //     // Use $this->app to access the framework services.
    // }



    // /**
    //  * This is the index method action, it handles:
    //  * ANY METHOD mountpoint
    //  * ANY METHOD mountpoint/
    //  * ANY METHOD mountpoint/index
    //  *
    //  * @return string
    //  */
    // public function indexAction() : string
    // {
    //     // Deal with the action and return a response.
    //     return "hej";
    // }


    /**
     * This is the init method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function initAction() : object
    {
        $game = new DiceGame();
        //$_SESSION["game"] = $game;
        $this->app->session->set("game", $game);

        return $this->app->response->redirect("dice1/pre-game");
    }


    /**
     * This is the pre-game get method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function pregameActionGet() : object
    {
        $title = "Tärningsspelet 100";

        $this->app->page->add("dice1/pre_game_start");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the pre-game post method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function pregameActionPost() : object
    {
        //$_SESSION["game"]->preGameRoll();
        $this->app->session->get("game")->preGameRoll();

        return $this->app->response->redirect("dice1/pre-game-results");
    }

    /**
     * This is the pre-game results method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function pregameresultsAction() : object
    {
        $data = [
            "playOrder" => $_SESSION["game"]->playOrder,
            "playerPreGameScore" => $_SESSION["game"]->playerPreGameScore,
            "computerPreGameScore" => $_SESSION["game"]->computerPreGameScore
        ];
        $title = "Tärningsspelet 100";

        $this->app->page->add("dice1/pre_game_end", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the new round post method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function newroundActionPost() : object
    {
        //$_SESSION["playerRollResult"] = [];
        //$_SESSION["game"]->resetRoundPoints();
        $this->app->session->set("playerRollResult", []);
        $this->app->session->get("game")->resetRoundPoints();

        if ($this->app->session->get("game")->playOrder === "computer") {
            $this->app->session->get("game")->computerPlay();
            if ($this->app->session->get("game")->determineWinner() === "computer") {
                return $this->app->response->redirect("dice1/game-over");
            }
        }

        return $this->app->response->redirect("dice1/player-play");
    }

    /**
     * This is the player play method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function playerplayAction() : object
    {
        $data = [
            "playOrder" => $this->app->session->get("game")->playOrder,
            "playerRoundPoints" => $this->app->session->get("game")->playerRoundPoints,
            "computerRoundPoints" => $this->app->session->get("game")->computerRoundPoints,
            "playerTotalPoints" => $this->app->session->get("game")->protocol["player"],
            "computerTotalPoints" => $this->app->session->get("game")->protocol["computer"],
            "playerRollResult" => $this->app->session->get("playerRollResult"),
            "histogram" => $this->app->session->get("game")->diceHand->histogram
        ];
        $title = "Tärningsspelet 100";

        $this->app->page->add("dice1/play_game", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the player play post method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function playerplayActionPost() : object
    {
        //$_SESSION["playerRollResult"] = $_SESSION["game"]->playerPlay();
        $this->app->session->set("playerRollResult", $this->app->session->get("game")->playerPlay());
        // Check if the roll resulted in a win
        if ($this->app->session->get("game")->determineWinner() === "player") {
            return $this->app->response->redirect("dice1/game-over");
        } else if ($this->app->session->get("game")->validRoll($_SESSION["playerRollResult"])) {
            return $this->app->response->redirect("dice1/player-play");
        }
        // If invalid roll (1 among numbers) redirect to round results
        return $this->app->response->redirect("dice1/round-results");
    }

    /**
     * This is the player stop post method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function playerstopActionPost() : object
    {
        //$_SESSION["game"]->playerStopRolling();
        $this->app->session->get("game")->playerStopRolling();

        if ($this->app->session->get("game")->playOrder === "player") {
            $this->app->session->get("game")->computerPlay();

            if ($this->app->session->get("game")->determineWinner() === "computer") {
                return $this->app->response->redirect("dice1/game-over");
            }
        }

        return $this->app->response->redirect("dice1/round-results");
    }


    /**
     * This is the round results method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function roundresultsAction() : object
    {
        $data = [
            "playOrder" => $this->app->session->get("game")->playOrder,
            "playerRoundPoints" => $this->app->session->get("game")->playerRoundPoints,
            "computerRoundPoints" => $this->app->session->get("game")->computerRoundPoints,
            "playerTotalPoints" => $this->app->session->get("game")->protocol["player"],
            "computerTotalPoints" => $this->app->session->get("game")->protocol["computer"],
            "playerRollResult" => $this->app->session->get("playerRollResult"),
            "validRoll" => $this->app->session->get("game")->validRoll($this->app->session->get("playerRollResult"))
        ];
        $title = "Resultat för spelrundan";

        $this->app->page->add("dice1/round_results", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the round results method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function gameoverAction() : object
    {
        $data = [
            "winner" => $this->app->session->get("game")->determineWinner(),
            "playOrder" => $this->app->session->get("game")->playOrder,
            "playerRoundPoints" => $this->app->session->get("game")->playerRoundPoints,
            "computerRoundPoints" => $this->app->session->get("game")->computerRoundPoints,
            "playerTotalPoints" => $this->app->session->get("game")->protocol["player"],
            "computerTotalPoints" => $this->app->session->get("game")->protocol["computer"],
            "playerRollResult" => $this->app->session->get("playerRollResult")
        ];
        $title = "Tärningsspelet 100";

        $this->app->page->add("dice1/game_over", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * Adding an optional catchAll() method will catch all actions sent to the
     * router. You can then reply with an actual response or return void to
     * allow for the router to move on to next handler.
     * A catchAll() handles the following, if a specific action method is not
     * created:
     * ANY METHOD mountpoint/**
     *
     * @param array $args as a variadic parameter.
     *
     * @return mixed
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    // public function catchAll(...$args)
    // {
    //     // Deal with the request and send an actual response, or not.
    //     //return __METHOD__ . ", \$db is {$this->db}, got '" . count($args) . "' arguments: " . implode(", ", $args);
    //     return;
    // }
}
