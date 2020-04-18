<?php
/**
 * Create routes using $app programming style.
 */


/**
 * Render start page - receive data from user about game details.
 */
$app->router->get("dice/init", function () use ($app) {
    $_SESSION["game"] = null;
    $title = "Tärningsspelet 100";

    $app->page->add("dice/init_game");

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Init the game and redirect to the pre-game roll, to determine who starts.
 */
$app->router->post("dice/init", function () use ($app) {
    $game = new \Rist\Dice\DiceGame($_POST["numberDices"]);
    $_SESSION["game"] = $game;

    return $app->response->redirect("dice/pre-game");
});

/**
 * Initiate Pre-game roll, to determine who starts.
 */
$app->router->get("dice/pre-game", function () use ($app) {
    $title = "Tärningsspelet 100";

    $app->page->add("dice/pre_game_start");

    return $app->page->render([
        "title" => $title,
    ]);
});


/**
 * Pre-game roll excecuted, then redirect to results.
 */
$app->router->post("dice/pre-game", function () use ($app) {
    $_SESSION["game"]->preGameRoll();

    return $app->response->redirect("dice/pre-game-results");
});


/**
 * Results from Pre-game roll.
 */
$app->router->get("dice/pre-game-results", function () use ($app) {
    $data = [
        "playOrder" => $_SESSION["game"]->playOrder,
        "playerPreGameScore" => $_SESSION["game"]->playerPreGameScore,
        "computerPreGameScore" => $_SESSION["game"]->computerPreGameScore
    ];
    $title = "Tärningsspelet 100";

    $app->page->add("dice/pre_game_end", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * New round
 */
$app->router->post("dice/new-round", function () use ($app) {
    $_SESSION["playerRollResult"] = [];
    $_SESSION["game"]->resetRoundPoints();
    //$_SESSION["game"]->computerPlay();

    if ($_SESSION["game"]->playOrder === "computer") {
        $_SESSION["game"]->computerPlay();
        if ($_SESSION["game"]->determineWinner() === "computer") {
            return $app->response->redirect("dice/game-over");
        }
    }

    return $app->response->redirect("dice/player-play");
});

/**
 * Create the game view to get input from player
 */
$app->router->get("dice/player-play", function () use ($app) {
    $data = [
        "playOrder" => $_SESSION["game"]->playOrder,
        "playerRoundPoints" => $_SESSION["game"]->playerRoundPoints,
        "computerRoundPoints" => $_SESSION["game"]->computerRoundPoints,
        "playerTotalPoints" => $_SESSION["game"]->protocol["player"],
        "computerTotalPoints" => $_SESSION["game"]->protocol["computer"],
        "playerRollResult" => $_SESSION["playerRollResult"]
    ];
    $title = "Tärningsspelet 100";

    $app->page->add("dice/play_game", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Player makes a play
 */
$app->router->post("dice/player-play", function () use ($app) {
    $_SESSION["playerRollResult"] = $_SESSION["game"]->playerPlay();
    // Check if the roll resulted in a win
    if ($_SESSION["game"]->determineWinner() === "player") {
        return $app->response->redirect("dice/game-over");
    } else if ($_SESSION["game"]->validRoll($_SESSION["playerRollResult"])) {
        return $app->response->redirect("dice/player-play");
    }
    // If invalid roll (1 among numbers) redirect to round results
    return $app->response->redirect("dice/round-results");
});

/**
 * Player decides to stop
 */
$app->router->post("dice/player-stop", function () use ($app) {
    $_SESSION["game"]->playerStopRolling();

    if ($_SESSION["game"]->playOrder === "player") {
        $_SESSION["game"]->computerPlay();

        if ($_SESSION["game"]->determineWinner() === "computer") {
            return $app->response->redirect("dice/game-over");
        }
    }

    return $app->response->redirect("dice/round-results");
});

/**
 * Round results
 */
$app->router->get("dice/round-results", function () use ($app) {
    $data = [
        "playOrder" => $_SESSION["game"]->playOrder,
        "playerRoundPoints" => $_SESSION["game"]->playerRoundPoints,
        "computerRoundPoints" => $_SESSION["game"]->computerRoundPoints,
        "playerTotalPoints" => $_SESSION["game"]->protocol["player"],
        "computerTotalPoints" => $_SESSION["game"]->protocol["computer"],
        "playerRollResult" => $_SESSION["playerRollResult"],
        "validRoll" => $_SESSION["game"]->validRoll($_SESSION["playerRollResult"])
    ];
    $title = "Resultat för spelrundan";

    $app->page->add("dice/round_results", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Game over
 */
$app->router->get("dice/game-over", function () use ($app) {
    $data = [
        "winner" => $_SESSION["game"]->determineWinner(),
        "playOrder" => $_SESSION["game"]->playOrder,
        "playerRoundPoints" => $_SESSION["game"]->playerRoundPoints,
        "computerRoundPoints" => $_SESSION["game"]->computerRoundPoints,
        "playerTotalPoints" => $_SESSION["game"]->protocol["player"],
        "computerTotalPoints" => $_SESSION["game"]->protocol["computer"],
        "playerRollResult" => $_SESSION["playerRollResult"]
    ];
    $title = "Tärningsspelet 100";

    $app->page->add("dice/game_over", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});
