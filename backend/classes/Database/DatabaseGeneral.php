<?php

require_once dirname(__DIR__, 3) . "/backend/classes/DB.php";


class DatabaseGeneral extends DB
{
    private string $worldVersion;
    private string $worldName;

    public function __construct($world = "Allgemein")
    {
        parent::__construct($world);
        preg_match("/(?<world>\w+)\-(?<version>\d+)|(?<worldSecond>\w+)/", $world, $match);
        $this->worldVersion = $match["version"] ?? -1;
        $this->worldName = $match["world"] ?? $match["worldSecond"];

    }

    function getDatabasePlayerIDs(): array
    {
        $return = [];
        $this->connectTo("Allgemein");
        $query = $this->query("SELECT DISTINCT playerid FROM `userrollen` where world = '{$this->worldName}' and level > 0 and Version = '{$this->worldVersion}'");
        foreach ($query as $playerID) {
            $return[$playerID["playerid"]] = $playerID["playerid"];
        }
        return $return;
    }
}