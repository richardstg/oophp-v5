<?php
require __DIR__ . '/src/autoload.php';
require __DIR__ . '/src/config.php';

if (!isset($_SESSION['game'])) {
    $_SESSION['game'] = new Guess();
    $_SESSION['game']->random();
}

$_SESSION['cheat'] = $_SESSION['cheat'] ?? false;
$_SESSION['guessFeedback'] = $_SESSION['guessFeedback'] ?? null;
$_SESSION['gameOver'] = $_SESSION['gameOver'] ?? false;

?>


<html>
    <head>
    <script src="https://kit.fontawesome.com/297fe7f3c7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="index.css" media="screen">
    </head>
    <body>
        <header>
            <h1><i class="fas fa-bolt"></i>Guess the number<i class="fas fa-bolt"></i></h1>
        </header>
        <main>
        <?php if (!$_SESSION['gameOver']) : ?>
            <h3>Guess a number between 1 and 100, you have <?= $_SESSION['game']->tries() ?> tries left.</h3>
            <form action="post_process.php" method="post">
                <i class="fas fa-angle-double-right"></i>
                <input type="number" id="numberGuess" name="numberGuess" placeholder="Enter number...">
                <i class="fas fa-angle-double-left"></i>
                <br><br>
                <input type="submit" name="makeGuess" value="Make a guess">
                <input type="submit" name="resetGame" value="Reset game">
                <input type="submit" name="cheat" value="Cheat">
            </form>
            <?= $_SESSION['guessFeedback'] ? "<p>{$_SESSION['guessFeedback']}</p>" : "" ?>
            <?= $_SESSION['cheat'] ? "<p><i>Hint: {$_SESSION['game']->number()}</i></p>" : "" ?>
        <?php else : ?>
            <form action="post_process.php" method="post">
                <input type="submit" name="resetGame" value="Reset game">
            </form>
            <?= $_SESSION['guessFeedback'] ? "<p>{$_SESSION['guessFeedback']}</p>" : "" ?>
        <?php endif; ?>
        </main>
    </body>
</html>
