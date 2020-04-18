<?php
include __DIR__ . "/header.php";
?>
<?php if (!$validRoll) : ?>
<h3 style="border-bottom: none">Du kastade <?= implode(', ', $playerRollResult) ?>, vilket var ogiltigt :(</h3>
<?php else : ?>
<h3 style="border-bottom: none">Du valde att stanna.</h3>
<?php endif; ?>
<?php if ($playOrder === "player") : ?>
<p style="font-weight: bolder">Datorn kastade och fick <?= $computerRoundPoints ?> poäng för rundan.</p>
<?php endif; ?>
<br>
<div class="total-points">
    <h3 style="border-bottom: none">Dina totalpoäng: <?= $playerTotalPoints ?></h3>
    <h3 style="border-bottom: none">Datorns totalpoäng: <?= $computerTotalPoints ?></h3>
</div>
<br>
<div class="total-points">
<p>Dina poäng för rundan: <?= $playerRoundPoints ?></p>
<p>Datorns poäng för rundan: <?= $computerRoundPoints ?></p>
</div>
<form action="new-round" method="post">
    <input type="submit" name="nextRound" value="Nästa runda">
</form>
<div class="game-field">
</div>

<?php
include __DIR__ . "/footer.php";
?>