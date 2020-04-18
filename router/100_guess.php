<?php
/**
 * Create routes using $app programming style.
 */


/**
 * Init the game and redirect to play the game.
 */
$app->router->get("guess/init", function () use ($app) {
    // Init the session for the game start.
    $_SESSION['game'] = new \Rist\Guess\Guess();
    $_SESSION['game']->random();

    return $app->response->redirect("guess/play");
});


/**
 * Render the game view with data from the game, displaying game status.
 */
$app->router->get("guess/play", function () use ($app) {
    // Get variables and values from the game stored in the session
    // and save them in the data object.
    $data = [
        "game" => $_SESSION['game'],
        "tries" => $_SESSION['game']->tries(),
        "number" => $_SESSION['game']->number(),
        "cheat" => $_SESSION['cheat'] ?? false,
        "guessFeedback" => $_SESSION['guessFeedback'] ?? null,
        "gameOver" => $_SESSION['gameOver'] ?? false
    ];
    $title = "Play the game";

    $app->page->add("guess/play", $data);
    //$app->page->add("guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Handle posted form (make a guess, reset or cheat).
 */
$app->router->post("guess/play", function () use ($app) {
    // Get and use the data from the posted form
    if (isset($_POST['makeGuess']) && isset($_POST['numberGuess']) && $_POST['numberGuess'] !== "") {
        $_SESSION['guessFeedback'] = $_SESSION['game']->makeGuess((int) $_POST['numberGuess']);

        if ($_SESSION['game']->tries() === 0 || (int) $_POST['numberGuess'] === $_SESSION['game']->number()) {
            $_SESSION['gameOver'] = true;
        }
    } else if (isset($_POST['resetGame'])) {
        return $app->response->redirect("guess/reset");
    } elseif (isset($_POST['cheat'])) {
        $_SESSION['cheat'] = true;
    }

    return $app->response->redirect("guess/play");
});


/**
 * Destroy the session and reset the game.
 */
$app->router->get("guess/reset", function () use ($app) {
    // Unset all of the session variables.
    $_SESSION = [];

    // If it's desired to kill the session, also delete the session cookie.
    // Note: This will destroy the session, and not just the session data!
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    // Finally, destroy the session.
    session_destroy();

    return $app->response->redirect("guess/init");
});
