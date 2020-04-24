<?php
include __DIR__ . "/header.php";
?>

<h3 style="border-bottom: none">
    Du fick <?= $playerPreGameScore ?> poäng, medan datorn fick <?= $computerPreGameScore ?>.
</h3>
<p>
    Det innebär att <?= $playOrder === "player" ? "du" : "datorn" ?> kastar först.
</p>
<form action="new-round" method="post">
    <input type="submit" name="startGame" value="Starta spelet">
</form>

<?php
include __DIR__ . "/footer.php";
?>
