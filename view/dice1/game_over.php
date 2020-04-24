<?php
include __DIR__ . "/header.php";
?>

<?php if ($winner === "player") : ?>
    <h3 style="border-bottom: none">Du kastade <?= implode(', ', $playerRollResult) ?> och vann!</h3>
<?php else : ?>
    <?php if ($playOrder === "computer") : ?>
        <h3 style="border-bottom: none">Datorn kastade och fick <?= $computerRoundPoints ?> poäng för rundan.</h3>
    <?php endif; ?>
    <p>Du förlorade tyvärr den här gången... :(</p>
    <br>
<?php endif; ?>
<p>Dina totalpoäng: <?= $playerTotalPoints ?></p>
<p>Datorns totalpoäng: <?= $computerTotalPoints ?></p>
<br>
<p>Dina poäng för senaste rundan: <?= $playerRoundPoints ?></p>
<p>Datorns poäng för senaste rundan: <?= $computerRoundPoints ?></p>
<div class="game-field">
<form action="init" method="post">
    <input type="submit" name="newGame" value="Nytt spel">
    <!-- <input type="number" name="numberDices" placeholder="Antal tärningar"> -->
</form>
</div>

<?php
include __DIR__ . "/footer.php";
?>