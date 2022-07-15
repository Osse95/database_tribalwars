<?php

require_once "DB.php";

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
        foreach($query as $village){
            $return[$village["dorfid"]] = array("villageID"=>$village["dorfid"],
                "villageName"=>$village["dorfname"],
                "coords"=>$village["dorfcoords"],
                "x"=>$village["dorfx"],
                "y"=>$village["dorfy"],
                "playerID"=>$village["spielerid"],
                "tribeID"=>$village["tribe"],
                "points"=>$village["dorfpunkte"],
                "bonusID"=>$village["bonusid"]);
        }
        return $return;
    }

    function getAllVillagesSortByCoords(): array
    {
        $return = [];
        $query = $this->query("SELECT * FROM `dorfdaten`");
        foreach($query as $village){
            $return[$village["dorfcoords"]] = array("villageID"=>$village["dorfid"],
                "villageName"=>$village["dorfname"],
                "coords"=>$village["dorfcoords"],
                "x"=>$village["dorfx"],
                "y"=>$village["dorfy"],
                "playerID"=>$village["spielerid"],
                "tribeID"=>$village["tribe"],
                "points"=>$village["dorfpunkte"],
                "bonusID"=>$village["bonusid"]);
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
}