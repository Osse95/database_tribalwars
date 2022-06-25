<?php
require_once "DB.php";

class World extends DB
{
    private SimpleXMLElement $worldConfig;
    private SimpleXMLElement $troopConfig;
    private SimpleXMLElement $buildingConfig;



    function __construct($world = "Allgemein")
    {
        parent::__construct($world);
        $worldConfig = $this->query("SELECT * FROM `worldconfig`");
        $this->worldConfig = new SimpleXMLElement($worldConfig[0]["worldconfig"]);
        $this->troopConfig = new SimpleXMLElement($worldConfig[0]["troupconfig"]);
        $this->buildingConfig = new SimpleXMLElement($worldConfig[0]["buildingconfig"]);
    }

    function isWatchtowerAvailable(): bool
    {
        if ($this->worldConfig->game->watchtower == "1") {
            return true;
        }else{
            return false;
        }
    }

    function isChurchAvailable(): bool
    {
        if ($this->worldConfig->game->church == "1") {
            return true;
        }else{
            return false;
        }
    }

    function isArcherAvailable(): bool
    {
        if ($this->worldConfig->game->archer == "1") {
            return true;
        }else{
            return false;
        }
    }

    function isKnightAvailable(): bool
    {
        if ($this->worldConfig->game->knight > "0") {
            return true;
        }else{
            return false;
        }
    }

    function isMilitiaAvailable(): bool
    {
        if ($this->worldConfig->game->militia > "0") {
            return true;
        }else{
            return false;
        }
    }
}
