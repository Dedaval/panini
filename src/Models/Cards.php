<?php
namespace App\Models;
use PDO;

class Cards extends ModelFactory
{
    private PDO $pdoConnection;

    private $card_id;
    private $album_id;
    private $name;
    private $number;

    public function __construct($card_id, $album_id, $name , $number)
    {
        self::$tableName = 'cards';
        self::$tableColumn = ['card_id', 'album_id', 'name', 'number'];

        $this->card_id = $card_id;
        $this->album_id = $album_id;
        $this->name = $name;
        $this->number = $number;

        parent::__construct();
    }

    
}