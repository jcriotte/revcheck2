<?php

namespace App\Model;

class FilmManager extends AbstractManager
{
    public const TABLE = 'film';

    /**
     * Insert new film in database
     */
    public function insert(array $film): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . "
        (title, description, year, categoryId)
        VALUES (:title, :description, :year, :categoryId)");
        $statement->bindValue('title', $film['title'], \PDO::PARAM_STR);
        $statement->bindValue('description', $film['description'], \PDO::PARAM_STR);
        $statement->bindValue('year', $film['year'], \PDO::PARAM_STR);
        $statement->bindValue('categoryId', $film['categoryId'], \PDO::PARAM_INT);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    /**
     * Update film in database
     */
    public function update(array $film): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `title` = :title WHERE id=:id");
        $statement->bindValue('id', $film['id'], \PDO::PARAM_INT);
        $statement->bindValue('title', $film['title'], \PDO::PARAM_STR);
        $statement->bindValue('description', $film['description'], \PDO::PARAM_STR);
        $statement->bindValue('year', $film['year'], \PDO::PARAM_STR);
        $statement->bindValue('categoryId', $film['categoryId'], \PDO::PARAM_INT);

        return $statement->execute();
    }
}
