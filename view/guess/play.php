<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

?>
<div style="text-align: center">
    <script src="https://kit.fontawesome.com/297fe7f3c7.js" crossorigin="anonymous"></script>
    <header>
        <h1 style="border-bottom: none"><i class="fas fa-bolt"></i>Guess the number<i class="fas fa-bolt"></i></h1>
    </header>
    <main>
    <?php if (!$gameOver) : ?>
        <h3 style="border-bottom: none">Guess a number between 1 and 100, you have <?= $tries ?> tries left.</h3>
        <form action="" method="post">
            <i class="fas fa-angle-double-right"></i>
            <input type="number" id="numberGuess" name="numberGuess" placeholder="Enter number...">
            <i class="fas fa-angle-double-left"></i>
            <br><br>
            <input type="submit" name="makeGuess" value="Make a guess">
            <input type="submit" name="resetGame" value="Reset game">
            <input type="submit" name="cheat" value="Cheat">
        </form>
        <?= $guessFeedback ? "<p>{$guessFeedback}</p>" : "" ?>
        <?= $cheat ? "<p><i>Hint: {$number}</i></p>" : "" ?>
    <?php else : ?>
        <form action="" method="post">
            <input type="submit" name="resetGame" value="Reset game">
        </form>
        <?= $guessFeedback ? "<p>{$guessFeedback}</p>" : "" ?>
    <?php endif; ?>
    </main>
</div>
