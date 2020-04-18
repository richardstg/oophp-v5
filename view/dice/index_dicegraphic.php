<?php

//namespace Anax\View;
namespace Rist\Dice;

$dice = new DiceGraphic();
$rolls = 6;
$res = [];
$class = [];
for ($i = 0; $i < $rolls; $i++) {
    $res[] = $dice->throwDice();
    $class[] = $dice->graphic();
}

?><!doctype html>
<meta charset="utf-8">
<h1>Rolling <?= $rolls ?> graphic dices</h1>

<p class="dice-utf8">
<?php foreach ($class as $value) : ?>
    <i class="<?= $value ?> dice-sprite"></i>
<?php endforeach; ?>
</p>
