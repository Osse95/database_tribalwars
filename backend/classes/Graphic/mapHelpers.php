<?php
require_once dirname(__DIR__) . "/DB.php";
require_once dirname(__DIR__) . "/Inno.php";

class mapHelpers extends DB
{
    private string $worldName;
    private string $worldVersion;
    private int $playerID;

    function __construct($world, $playerID = 0)
    {
        parent::__construct($world);
        $this->worldVersion = $world;
        $this->playerID = intval($playerID);
        preg_match("/(?<world>\w+\d+)/", $world, $match);
        $this->worldName = $match["world"];
    }

    function getVillages(): bool|array
    {
        $return = [];
        $this->connectTo($this->worldName);
        return $this->query("SELECT * FROM `dorfdaten`");
    }

    function getVillagesByDate($date): bool|array
    {
        $return = [];
        $this->connectTo($this->worldName);
        return $this->query("SELECT * FROM `dorfdaten`");
    }

    function getDiploTribes(): array
    {
        $proportion = $this->getTribeProportion();
        $tribeReturn = [];
        $tribeLegend = [];
        $this->connectTo($this->worldVersion);
        $query = $this->query("SELECT * FROM `tribes_map`");
        foreach ($query as $diploVillage) {
            $diplo = $diploVillage["diplo"];
            $colour = match ($diplo) {
                "2" => "red",
                "3" => "purple",
                "4" => "lightblue",
                default => "blue",
            };
            $tribeReturn[$diploVillage["tribeid"]] = $colour;
            $tribeLegend[] = array(
                "text" => $diploVillage["tribetag"],
                "colour" => $colour,
                "x" => $diploVillage["x"],
                "y" => $diploVillage["y"],
                "proportion" => $proportion[$diploVillage["tribeid"]] . " %"
            );
        }
        return [$tribeReturn, $tribeLegend];
    }

    function playerMap(): array
    {
        $diploReturn = [];
        $tribeLegend = [];
        $this->connectTo($this->worldVersion);
        $query = $this->query("SELECT * FROM `tribes_map` where diplo != 2");
        foreach ($query as $diploVillage) {
            $diplo = $diploVillage["diplo"];
            $colour = match ($diplo) {
                "2" => "red",
                "4" => "lightblue",
                default => "blue",
            };
            $diploReturn[$diploVillage["tribeid"]] = $colour;
        }
        $playerReturn[$this->playerID] = "white";
        return [$diploReturn, $playerReturn];
    }

    function topTenTribes(): array
    {
        $proportion = $this->getTribeProportion();
        $tribeReturn = [];
        $tribeLegend = [];
        $this->connectTo($this->worldVersion);
        $query = $this->query("SELECT id,rang,tag,x,y FROM `tribes` where rang <= 10;");
        foreach ($query as $topTenVillage) {
            $rang = $topTenVillage["rang"];
            $colour = match ($rang) {
                "2" => "blue",
                "3" => "yellow",
                "4" => "white",
                "5" => "darkred",
                "6" => "purple",
                "7" => "pink",
                "8" => "darkgrey",
                "9" => "orange",
                "10" => "lightgreen",
                default => "red",
            };
            $tribeReturn[$topTenVillage["id"]] = $colour;
            $tribeLegend[] = array(
                "text" => $topTenVillage["tag"],
                "colour" => $colour,
                "x" => $topTenVillage["x"],
                "y" => $topTenVillage["y"],
                "proportion" => $proportion[$topTenVillage["id"]] . " %"
            );
        }
        return [$tribeReturn, $tribeLegend];
    }

    function getTribeProportion(): array
    {
        $return = [];
        $this->connectTo($this->worldName);
        $query = $this->query("SELECT tribe, ROUND((COUNT(*) / (SELECT COUNT(*) FROM `dorfdaten` WHERE spielerid > 0)) * 100,2) AS 'percentage' 
                                    FROM `dorfdaten`
                                    WHERE spielerid > 0 and tribe > 0
                                    GROUP BY tribe  
                                    ORDER BY `Percentage`");
        foreach ($query as $Proportion) {
            $return[$Proportion["tribe"]] = $Proportion["percentage"];
        }
        return $return;
    }

    function getUserMap(): array
    {
        $playerReturn = [];
        $this->connectTo($this->worldName);
        $playerID = $this->playerID;
        $query = $this->query("SELECT * FROM `spielerdaten` WHERE spielerid = '$playerID'");
        foreach ($query as $player) {
            $playerReturn[$playerID] = "white";
        }

        $buildingsReturn = array(
            "watchtowers" => [],
            "churches" => []
        );
        $this->connectTo($this->worldVersion);
        $query = $this->query("Select wachturm,kirche,erstekirche,dorfcoords FROM `buildings` WHERE playerid = '$playerID'");
        foreach ($query as $buildings) {
            $split = explode("|", substr($buildings["dorfcoords"], 1, -1));
            $x = $split[0];
            $y = $split[1];
            if ($buildings["wachturm"] > 0) {
                $buildingsReturn["watchtowers"][] = array(
                    "range" => Inno::getWatchtowerRange($buildings["wachturm"]),
                    "colour" => "darkyellow",
                    "x" => $x,
                    "y" => $y
                );
            }
            if ($buildings["kirche"] > 0) {
                $buildingsReturn["churches"][] = array(
                    "range" => Inno::getChurchRange($buildings["kirche"]),
                    "colour" => "darkblue",
                    "x" => $x,
                    "y" => $y
                );
            }
            if ($buildings["erstekirche"] > 0) {
                $buildingsReturn["churches"][] = array(
                    "range" => Inno::getChurchRange(2),
                    "colour" => "darkblue",
                    "x" => $x,
                    "y" => $y
                );
            }
        }
        return [$playerReturn, $buildingsReturn];
    }

    function getAttacks(): array
    {
        $this->connectTo($this->worldVersion);

        $tribeReturn = [];
        $query = $this->query("SELECT * FROM `tribes_map` where diplo = 1;");
        foreach ($query as $OwnTribe) {
            $tribeReturn[$OwnTribe["tribeid"]] = "blue";
        }

        $returnAttacks = [];
        $query = $this->query("Select defenderdorfid,predictedLabel FROM `sos`");
        foreach ($query as $attack) {
            $colour = match ($attack["predictedLabel"]) {
                "1" => "white",
                "2" => "red",
                "3", "4" => "darkred",
                default => "black",
            };
            $returnAttacks[$attack["defenderdorfid"]] = $colour;
        }

        return [$tribeReturn, $returnAttacks];
    }

    function getSources(): array
    {
        $this->connectTo($this->worldVersion);

        $tribeReturn = [];
        $query = $this->query("SELECT * FROM `tribes_map` where diplo = 1;");
        foreach ($query as $OwnTribe) {
            $tribeReturn[$OwnTribe["tribeid"]] = "blue";
        }

        $returnAttacks = [];
        $query = $this->query("Select attackerdorfid,predictedLabel FROM `sos`");
        foreach ($query as $attack) {
            $colour = match ($attack["predictedLabel"]) {
                "1" => "white",
                "2" => "red",
                "3", "4" => "darkred",
                default => "black",
            };
            $returnAttacks[$attack["attackerdorfid"]] = $colour;
        }

        return [$tribeReturn, $returnAttacks];
    }
}