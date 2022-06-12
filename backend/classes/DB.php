<?php

require_once dirname(__DIR__, 2) . "/backend/config.php";

class DB
{
    public mysqli $conn;
    protected string $world;

    function __construct($world="Allgemein")
    {
        global $DB_Config;
        $this->conn = new mysqli($DB_Config["Server"], $world, $DB_Config["Password"], $world);
        $this->world = $world;
    }

    function query($query)
    {
        $connection = $this->conn;
        $connection = $connection->query($query);
        if ($connection === true) {
            return true;
        } elseif ($connection === false) {
            return false;
        } else {
            $rows = [];
            while ($row = $connection->fetch_assoc()) {
                $rows[] = $row;
            }
            return $rows;
        }
    }
    function connectTo($DB){
        global $DB_Config;
        $this->conn = new mysqli($DB_Config["Server"], $DB, $DB_Config["Password"], $DB);
    }
}