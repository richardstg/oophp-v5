<?php
require __DIR__ . '/src/autoload.php';
require __DIR__ . '/src/config.php';

/**
 * A processing page that does a redirect.
 */

if (isset($_POST['makeGuess'])
    && isset($_POST['numberGuess'])
    && $_POST['numberGuess'] !== "") {
    $_SESSION['guessFeedback'] = $_SESSION['game']->makeGuess((int) $_POST['numberGuess']);

    if ($_SESSION['game']->tries() === 0
        || (int) $_POST['numberGuess'] === $_SESSION['game']->number()) {
        $_SESSION['gameOver'] = true;
    }
} else if (isset($_POST['resetGame'])) {
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
} elseif (isset($_POST['cheat'])) {
    $_SESSION['cheat'] = true;
}

// Redirect to a result page.
$url = "index.php";
header("Location: $url");
