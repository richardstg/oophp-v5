<?php
include __DIR__ . "/header.php";
?>

<?php if ($playOrder === "computer") : ?>
<p style="font-weight: bold;">Datorn har gjort sina kast och fick <?= $computerRoundPoints ?> poäng för rundan.</p>
<?php endif; ?>
<div class="total-points">
    <h3 style="border-bottom: none">Din totalpoäng: <?= $playerTotalPoints ?></h3>
    <h3 style="border-bottom: none">Datorns totalpoäng: <?= $computerTotalPoints ?></h3>
</div>
<br>
<h3 style="border-bottom: none">Dina poäng för rundan: <?= $playerRoundPoints ?></h3>
<form action="player-play" method="post">
    <input type="submit" name="rollDices" value="Kasta tärningen">
</form>
<form action="player-stop" method="post">
    <input type="submit" name="stopRound" value="Stanna">
</form>
<div class="game-field">
<?php if ($playerRollResult) : ?>
    <p>Du kastade: <?= implode(', ', $playerRollResult) ?></p>
<?php endif; ?>
<p>Histogram:</p>
<p><?= $histogram->getAsText() ?></p>
</div>

<?php
include __DIR__ . "/footer.php";
?>