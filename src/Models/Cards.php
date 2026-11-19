<?php

declare(strict_types=1);

namespace App\Models;

class Cards extends ModelFactory
{
    protected static string $tableName = 'cards';
    protected static array $tableColumn = ['card_id', 'album_id', 'name', 'number'];
}