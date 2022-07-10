<?php

require_once "DB.php";
require_once "Player.php";
require_once "Tribe.php";

class Village extends DB
{
    public bool $exists = false;
    public array $villageArray = [];

    public function __construct($world, $village, $coords = "")
    {
        parent::__construct($world);
        $stmt = $this->conn->prepare("SELECT * FROM `dorfdaten` WHERE dorfid = ? OR dorfcoords = ?");
        $stmt->execute([$village, $coords]);
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

    function getOwner(){
        $Player = new Player($this->world,$this->villageArray["playerID"]);
        if($Player->exists){
            return $Player->playerArray["name"];
        }else{
            return "Barbaren";
        }
    }

    function getTribe(){
        $Tribe = new Tribe($this->world,$this->villageArray["tribeID"]);
        if($Tribe->exists){
            return $Tribe->tribeArray["name"];
        }else{
            return "Stammeslos";
        }
    }

}