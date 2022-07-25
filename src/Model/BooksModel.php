<?php

namespace Model;

use lib\MySQL;

class BooksModel
{
    private object $MySQL;

    public const TABLE = 'books';

    public function __construct()
    {
        $this->MySQL = new MySQL();
    }

    public function getAll()
    {
        $query = 'SELECT * FROM ' . self::TABLE;
        $stmt = $this->MySQL->getDB()->query($query);
        $registers = $stmt->fetchAll($this->MySQL->DB::FETCH_ASSOC);

        return $registers;
    }

    public function getOneByKey($ID)
    {
        $query = 'SELECT * FROM ' . self::TABLE . ' WHERE ID = :ID';
        $stmt = $this->MySQL->getDB()->prepare($query);
        $stmt->bindParam(':ID', $ID);
        $stmt->execute();

        if ($stmt->rowCount() === 1)
            return $stmt->fetch($this->MySQL->DB::FETCH_ASSOC);

        return [];
    }

    public function insertBook($name, $authors, $pages)
    {
        $query = 'INSERT INTO ' . self::TABLE . ' (name, authors, pages) VALUES (:name, :authors, :pages)';
        $this->MySQL->getDB()->beginTransaction();
        $stmt = $this->MySQL->getDB()->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':authors', $authors);
        $stmt->bindParam(':pages', $pages);
        $stmt->execute();

        return $stmt->rowCount();
    }

    public function updateBook($ID, $name, $authors, $pages)
    {
        $query = 'UPDATE ' . self::TABLE .' SET name = :name, authors = :authors, pages = :pages WHERE ID = :ID';
        $this->MySQL->getDB()->beginTransaction();
        $stmt = $this->MySQL->getDB()->prepare($query);
        $stmt->bindParam(':ID', $ID);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':authors', $authors);
        $stmt->bindParam(':pages', $pages);
        $stmt->execute();

        return $stmt->rowCount();
    }

    public function delete($ID)
    {
        $query = 'DELETE FROM ' . self::TABLE . ' WHERE ID = :ID';
        $this->MySQL->getDB()->beginTransaction();
        $stmt = $this->MySQL->getDB()->prepare($query);
        $stmt->bindParam(':ID', $ID);
        $stmt->execute();
        
        return $stmt->rowCount();
    }

    public function getMySQL()
    {
        return $this->MySQL;
    }
}
