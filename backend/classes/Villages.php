<?php

require_once "DB.php";
require_once "Players.php";

class Villages extends DB
{
    function __construct($world)
    {
        parent::__construct($world);
    }

    function getAllVillagesSortByID(): array
    {
        $return = [];
        $query = $this->query("SELECT * FROM `dorfdaten`");
        foreach ($query as $village) {
            $return[$village["dorfid"]] = array("villageID" => $village["dorfid"],
                "villageName" => $village["dorfname"],
                "coords" => $village["dorfcoords"],
                "x" => $village["dorfx"],
                "y" => $village["dorfy"],
                "playerID" => $village["spielerid"],
                "tribeID" => $village["tribe"],
                "points" => $village["dorfpunkte"],
                "bonusID" => $village["bonusid"]);
        }
        return $return;
    }

    function getAllVillagesSortByCoords(): array
    {
        $return = [];
        $query = $this->query("SELECT * FROM `dorfdaten`");
        foreach ($query as $village) {
            $return[$village["dorfcoords"]] = array("villageID" => $village["dorfid"],
                "villageName" => $village["dorfname"],
                "coords" => $village["dorfcoords"],
                "x" => $village["dorfx"],
                "y" => $village["dorfy"],
                "playerID" => $village["spielerid"],
                "tribeID" => $village["tribe"],
                "points" => $village["dorfpunkte"],
                "bonusID" => $village["bonusid"]);
        }
        return $return;
    }

    function getAllVillageCoordsSortByID(): array
    {
        $return = [];
        $query = $this->query("SELECT dorfcoords,dorfid FROM `dorfdaten`;");
        foreach ($query as $village) {
            $return[$village["dorfid"]] = $village["dorfcoords"];
        }
        return $return;
    }

    function getLastConquersSortByID(): array
    {
        $return = [];
        $query = $this->query("SELECT LAST_INSERT_ID(timestamp) as time,villageid FROM  `conquer`;");
        foreach ($query as $conquer) {
            $return[$conquer["villageid"]] = $conquer["time"];
        }
        return $return;
    }

    function getAllVillagesFromPlayerAjax($playerID = 0): array
    {

        $playerNames = new Players($this->world);
        $playerNames = $playerNames->getAllPlayerNamesSortByID();

        $lastConquers = $this->getLastConquersSortByID();

        $return = [];
        $query = $this->query("SELECT * FROM `dorfdaten` where spielerid = '$playerID'");
        foreach ($query as $village) {
            $playerUrl = "/playerInfo?ID={$village["spielerid"]}";
            $playerName = $playerNames[$village["spielerid"]] ?? "Barbar";
            $playerUrl = "<a class='previewPlayerinfo' href='$playerUrl' target='_blank'> $playerName </a>";

            $villageURL = "/villageInfo?ID={$village["dorfid"]}";
            $villageName = $village["dorfname"];
            $villageURL = "<a class='previewVillageinfo' = href='$villageURL' target='_blank'> $villageName </a>";

            $bonusType = self::getBonusType($village["bonusid"]);

            if(isset($lastConquers[$village["dorfid"]])){
                $lastConquer = date("d.m.Y H:i:s",$lastConquers[$village["dorfid"]]);
            }else{
                $lastConquer = "noch nie";
            }

            $return[] = [$villageURL, $playerUrl, $village["dorfpunkte"], $bonusType, $lastConquer];
        }
        return $return;
    }

    function getAllVillagesFromTribeAjax($tribeID = 0): array
    {
        $playerNames = new Players($this->world);
        $playerNames = $playerNames->getAllPlayerNamesSortByID();

        $lastConquers = $this->getLastConquersSortByID();

        $return = [];
        $query = $this->query("SELECT * FROM `dorfdaten` where tribe = '$tribeID'");
        foreach ($query as $village) {
            $playerUrl = "/playerInfo?ID={$village["spielerid"]}";
            $playerName = $playerNames[$village["spielerid"]] ?? "Barbar";
            $playerUrl = "<a class='previewPlayerinfo' href='$playerUrl' target='_blank'> $playerName </a>";

            $villageURL = "/villageInfo?ID={$village["dorfid"]}";
            $villageName = $village["dorfname"];
            $villageURL = "<a class='previewVillageinfo' = href='$villageURL' target='_blank'> $villageName </a>";

            $bonusType = self::getBonusType($village["bonusid"]);

            if(isset($lastConquers[$village["dorfid"]])){
                $lastConquer = date("d.m.Y H:i:s",$lastConquers[$village["dorfid"]]);
            }else{
                $lastConquer = "noch nie";
            }

            $return[] = [$villageURL, $playerUrl, $village["dorfpunkte"], $bonusType, $lastConquer];
        }
        return $return;
    }

    public static function getBonusType($type): string
    {
        $type = intval($type);
        return match ($type) {
            1 => "100% mehr Holz",
            2 => "100% mehr Lehm",
            3 => "100% mehr Eisen",
            4 => "10% Bevölkerung",
            5 => "Schnellere Kasernenrekrutierung",
            6 => "Schnellere Stallrekrutierung",
            7 => "Schnellere Werkstattrekrutierung",
            8 => "30% mehr Rohstoffe",
            9 => "Speicherdorf",
            10 - 21 => "Belagerungsdorf",
            default => ""
        };
    }
}