<?php

use App\Models\Cards;
/** @var App\Models\Cards[] $cards */
?>
<h1>Cards</h1>
<ul>
<?php foreach ($cards as $card): ?>
    <li><a href="/cards/<?= $card->getId() ?>"><?= htmlspecialchars($card->getName() )?></a></li>
<?php endforeach; ?>
</ul>