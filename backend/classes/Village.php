<?php

require_once "DB.php";
require_once "Player.php";
require_once "Tribe.php";
require_once "Players.php";

class Village extends DB
{
    public bool $exists = false;
    public array $villageArray = [];

    public function __construct($world, $village)
    {
        parent::__construct($world);
        preg_match("/(?<coords>\d{3}\|\d{3})/",$village,$coords);
        $village = $coords["coords"]??$village;
        $stmt = $this->conn->prepare("SELECT * FROM `dorfdaten` WHERE dorfid = ? OR dorfcoords = ?");
        $stmt->execute([$village, $village]);
        foreach ($stmt->get_result() as $row) {
            $this->exists = true;
            $this->villageArray = array(
                "ID" => $row["dorfid"],
                "name" => $row["dorfname"],
                "coords" => $row["dorfcoords"],
                "coordX" => $row["dorfx"],
                "coordY" => $row["dorfy"],
                "playerID" => $row["spielerid"],
                "tribeID" => $row["tribe"],
                "points" => $row["dorfpunkte"],
                "bonusID" => $row["bonusid"]
            );
        }
    }

    function getLastConquer(): string
    {
        $villageID = $this->villageArray["ID"];
        $conquer = $this->query("SELECT timestamp FROM `conquer` WHERE villageid = '$villageID' AND new_owner != old_owner ORDER BY timestamp DESC LIMIT 1");
        if (count($conquer) == 0) {
            return "-";
        } else {
            return date("d.m.Y h:i", $conquer[0]["timestamp"]);
        }
    }

    function getQuantityConquers(): int
    {
        $villageID = $this->villageArray["ID"];
        $conquer = $this->query("SELECT COUNT(*) AS quantity FROM `conquer` WHERE villageid = '$villageID' AND new_owner != old_owner");
        return intval($conquer[0]["quantity"]);
    }

    function getOwner()
    {
        $Player = new Player($this->world, $this->villageArray["playerID"]);
        if ($Player->exists) {
            return $Player->playerArray["name"];
        } else {
            return "Barbaren";
        }
    }

    function getTribe()
    {
        $Tribe = new Tribe($this->world, $this->villageArray["tribeID"]);
        if ($Tribe->exists) {
            return $Tribe->tribeArray["name"];
        } else {
            return "Stammeslos";
        }
    }

    function getConquers(): array
    {
        $return = [];
        $Players = new Players($this->world);
        $playerNames = $Players->getAllHistoryPlayerNamesSortByID();
        $villageID = $this->villageArray["ID"];
        $query = $this->query("SELECT timestamp,new_owner,old_owner,points FROM `conquer` WHERE villageid = '$villageID' AND new_owner != old_owner ORDER BY timestamp DESC");
        foreach ($query as $conquer) {
            $newOwner = $playerNames[$conquer["new_owner"]]["playerName"] ?? "gelöschter Spieler";
            $oldOwner = $playerNames[$conquer["old_owner"]]["playerName"] ?? "gelöschter Spieler";
            $points = $conquer["points"];
            $date = date("H:i d.m.Y", $conquer["timestamp"]);
            $return[] = array(
                "newOwner" => $newOwner,
                "oldOwner" => $oldOwner,
                "points" => $points,
                "date" => $date
            );
        }
        return $return;
    }

    function getPointsHistoryAjax(): array
    {
        $return["data"] = [];
        $Players = new Players($this->world);
        $playerNames = $Players->getAllHistoryPlayerNamesSortByID();

        $villageID = $this->villageArray["ID"];
        $query = $this->query("SELECT dorfpunkte,time,spielerid FROM `dorfdatenhistory2` WHERE dorfid = '$villageID' ORDER BY time ASC");
        $oldPoints = 0;
        foreach ($query as $change) {
            $date = date("d.m.Y H:i:s", $change["time"]);
            $ownerName = $playerNames[$change["spielerid"]]["playerName"] ?? "gelöschter Spieler";
            $ownerUrl = "/playerInfo?ID={$change["spielerid"]}";
            $ownerUrl = "<a class='previewPlayerinfo' href='$ownerUrl' target='_blank'> $ownerName </a>";
            $points = $change["dorfpunkte"];
            $pointsChange = $points-$oldPoints;
            if($pointsChange == 0) continue;
            $oldPoints = $points;
            $expansion = "<span class='showExpansion'>Ausbaumöglichkeiten";
            $return["data"][] = [$date, $ownerUrl, $points, $pointsChange, $expansion];
        }
        return $return;
    }

}