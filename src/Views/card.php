<?php

use App\Models\Cards;
/** @var App\Models\Cards $card */
?>
<h1><?= htmlspecialchars($card->getName()) ?></h1>
<ul>
<p>Number: <?= htmlspecialchars($card->getNumber()) ?></p>
</ul>