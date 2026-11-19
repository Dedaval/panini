<?php

declare(strict_types=1);

namespace App\Models;

use App\Services\Database;
use BadMethodCallException;
use InvalidArgumentException;
use PDO;

abstract class ModelFactory
{
    protected static string $tableName;
    protected static array $tableColumn;

    protected array $data = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    protected static function tableKey(): string
    {
        return static::$tableColumn[0];
    }

    public static function createFromRow(array $row): static
    {
        return new static($row);
    }

    public static function createFromRows(array $rows): array
    {
        return array_map(fn(array $row) => static::createFromRow($row), $rows);
    }

    public function getId(): mixed
    {
        return $this->data[static::tableKey()];
    }

    // getAlbumId() -> album_id, getName() -> name, etc.
    public function __call(string $method, array $args): mixed
    {
        if (!str_starts_with($method, 'get')) {
            throw new BadMethodCallException("Méthode $method inconnue");
        }

        $column = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', substr($method, 3)));

        if (!array_key_exists($column, $this->data)) {
            throw new BadMethodCallException("Colonne '$column' inexistante");
        }

        return $this->data[$column];
    }

    public static function create(array $data): int
    {
        static::checkColumns($data);

        $pdo = Database::getConnection();
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_map(fn($c) => ":$c", array_keys($data)));

        $sql = "INSERT INTO " . static::$tableName . " ($columns) VALUES ($placeholders)";
        $pdo->prepare($sql)->execute($data);

        return (int) $pdo->lastInsertId();
    }

    public static function update(int $id, array $data): void
    {
        static::checkColumns($data);

        $setParts = array_map(fn($c) => "$c = :$c", array_keys($data));
        $sql = "UPDATE " . static::$tableName
            . " SET " . implode(', ', $setParts)
            . " WHERE " . static::tableKey() . " = :__id";

        $params = $data + ['__id' => $id];
        Database::getConnection()->prepare($sql)->execute($params);
    }

    public static function remove(int $id): void
    {
        $sql = "DELETE FROM " . static::$tableName . " WHERE " . static::tableKey() . " = :id";
        Database::getConnection()->prepare($sql)->execute(['id' => $id]);
    }

    public static function findById(int $id): ?static
    {
        $sql = "SELECT * FROM " . static::$tableName . " WHERE " . static::tableKey() . " = :id";
        $statement = Database::getConnection()->prepare($sql);
        $statement->execute(['id' => $id]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        return $row ? static::createFromRow($row) : null;
    }

    public static function findAll(): array
    {
        $sql = "SELECT * FROM " . static::$tableName . " ORDER BY " . static::tableKey();
        $rows = Database::getConnection()->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        return static::createFromRows($rows);
    }

    private static function checkColumns(array $data): void
    {
        $invalid = array_diff(array_keys($data), static::$tableColumn);
        if (!empty($invalid)) {
            throw new InvalidArgumentException("Colonnes invalides : " . implode(', ', $invalid));
        }
    }
}