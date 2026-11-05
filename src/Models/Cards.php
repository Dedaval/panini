<?php
namespace App\Models;
use App\Services\Database;
use PDO;
class Cards
{
    private PDO $pdoConnection;

    private $card_id;
    private $album_id;
    private $name;
    private $number;

    public function __construct($card_id, $album_id, $name , $number)
    {
        $this->card_id = $card_id;
        $this->album_id = $album_id;
        $this->name = $name;
        $this->number = $number;
    }
    public function getCardId()
    {
        return $this->card_id;
    }
    public function getAlbumId()
    {
        return $this->album_id;
    }

    public function getName()
    {
        return $this->name;
    }
    public function getNumber()
    {
        return $this->number;
    }
    public static function findAll(): array
    {
        $pdo = Database::getConnection();
        $statement = $pdo->query('SELECT * FROM cards ORDER BY card_id');
        $rows = $statement->fetchAll();
        $equipes = [];
        foreach ($rows as $row) {
            $equipes[] = new self($row['card_id'], $row['album_id'], $row['name'], $row['number'],);
        }
        return $equipes;
    }
}