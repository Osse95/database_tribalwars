<?php

require_once dirname(__DIR__, 3) . "/backend/classes/DB.php";
require_once dirname(__DIR__, 3) . "/backend/classes/Players.php";

class Leadership extends DB
{
    private string $worldVersion;
    private string $worldName;
    private string $version;

    function __construct($world = "", $worldVersion = "", $version = "")
    {
        parent::__construct();
        $this->worldVersion = $worldVersion;
        $this->worldName = $world;
        $this->version = $version;

    }

    function getMemberNames(): array
    {
        $playersClass = new Players($this->worldName);
        $players = $playersClass->getAllPlayersDataSortByID();
        $return = [];
        $query = $this->query("SELECT DISTINCT playerid FROM `userrollen` WHERE world = '{$this->worldName}' and Version = '{$this->version}'");
        foreach ($query as $playerID) {
            if (isset($players[$playerID["playerid"]])) {
                $return[] = $players[$playerID["playerid"]]["playerName"];
            }
        }
        return $return;
    }

    function getLastInsert(): array
    {
        $playersClass = new Players($this->worldName);
        $players = $playersClass->getAllPlayersDataSortByID();

        $this->connectTo($this->worldVersion);
        $query = $this->query("SELECT * FROM `last_inserts`");
        $return["data"]= [];
        foreach ($query as $lastInsert) {
            $playerName = $players[$lastInsert["playerid"]]["playerName"] ?? "gelöschter Account";
            if ($lastInsert["sos_anfrage"] > 0) {
                $emergency = date("Y.m.d - H:i:s", $lastInsert["sos_anfrage"]);
            } else {
                $emergency = "Noch nie";
            }
            if ($lastInsert["berichte"] > 0) {
                $reports = date("Y.m.d - H:i:s", $lastInsert["berichte"]);
            } else {
                $reports = "Noch nie";
            }
            if ($lastInsert["truppen"] > 0) {
                $troops = date("Y.m.d - H:i:s", $lastInsert["truppen"]);
            } else {
                $troops = "Noch nie";
            }
            if ($lastInsert["buildings"] > 0) {
                $buildings = date("Y.m.d - H:i:s", $lastInsert["buildings"]);
            } else {
                $buildings = "Noch nie";
            }
            if ($lastInsert["ag_limit"] > 0) {
                $snobLimit = date("Y.m.d - H:i:s", $lastInsert["ag_limit"]);
            } else {
                $snobLimit = "Noch nie";
            }
            $return["data"][] = [$playerName, $emergency, $reports, $troops, $buildings, $snobLimit];
        }
        $this->connectTo();
        return $return;

    }

    function getAllTroops(){
        $this->connectTo($this->worldVersion);
    }
}