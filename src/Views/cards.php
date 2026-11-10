<?php

use App\Models\Cards;
/** @var App\Models\Cards[] $cards */
?>
<h1>Cards</h1>
<ul>
<?php foreach ($cards as $card): ?>
    <li><a href="/cards/<?= $card->getCardId() ?>"><?= htmlspecialchars($card->getAlbumId() )?></a></li>
<?php endforeach; ?>
</ul>