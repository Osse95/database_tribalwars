<?php

require_once dirname(__DIR__, 2) . "/backend/config.php";
require_once dirname(__DIR__, 2) . "/backend/classes/Mysqldump.php";

class DB
{
    public mysqli $conn;
    protected string $world;

    function __construct($world = "Allgemein")
    {
        global $DB_Config;
        $this->conn = new mysqli($DB_Config["Server"], $world, $DB_Config["Password"], $world);
        $this->world = $world;
    }

    function query($query): bool|array
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

    function connectTo($DB="Allgemein")
    {
        global $DB_Config;
        $this->conn = new mysqli($DB_Config["Server"], $DB, $DB_Config["Password"], $DB);
    }

    function createBackUp($world): bool
    {
        global $DB_Config;
        $dbHost = $DB_Config["Server"];
        $dbName = $this->world;
        $dbUser = $this->world;
        $dbPassword = $DB_Config["Password"];
        $dumpFile = dirname(__DIR__, 2) . "/userBackups/" . $dbName . date("Y-m-d_H-i-s") . '.sql.gz';
        try {
            $dump = new Ifsnop\Mysqldump\Mysqldump("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);
            $dump->start($dumpFile);
            return true;
        } catch (Exception $e) {
            return false;
        }

    }
}