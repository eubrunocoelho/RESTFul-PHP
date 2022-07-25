<?php

namespace lib;

use PDO;
use PDOException;

class MySQL
{
    public object $DB;
    private array $database = [];
    
    public function __construct()
    {
        $this->database = require './configs/database.php';
        $this->DB = $this->setDB();
    }

    private function setDB()
    {
        try {
            return new PDO(
                $this->database['conn']['driver'] . ':host=' . $this->database['conn']['host'] . ';dbname=' . $this->database['conn']['database'] . ';',
                $this->database['conn']['username'],
                $this->database['conn']['password']
            );
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }

    public function getDB()
    {
        return $this->DB;
    }
}
