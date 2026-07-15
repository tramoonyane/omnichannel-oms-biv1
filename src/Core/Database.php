<?php

namespace Src\Core;

use PDO;
use PDOException;

class Database
{
    private $connection;

    public function __construct()
    {
        $host = "localhost";
        $dbname = "omnichannel_oms_biv1";
        $username = "root";
        $password = "";

        try {
            $this->connection = new PDO(
                "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
                $username,
                $password
            );

            $this->connection->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
            
            // FORCE ASSOCIATIVE ARRAYS SYSTEM-WIDE
            $this->connection->setAttribute(
                PDO::ATTR_DEFAULT_FETCH_MODE,
                PDO::FETCH_ASSOC
            );

        } catch (PDOException $e) {
            die("Database Connection Failed: " . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
