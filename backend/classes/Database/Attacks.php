<?php

require_once dirname(__DIR__, 3) . "/backend/classes/DB.php";
require_once dirname(__DIR__, 3) . "/backend/classes/Players.php";

class Attacks extends DB
{
    private string $worldName;
    private $playersClass;
    private array $userNames;

    function __construct($world = "Allgemein")
    {
        parent::__construct($world);
        preg_match("/(?<world>\w+\d+)/", $world, $match);
        $this->worldName = $match["world"];
        $this->playersClass = new Players($this->worldName);
    }

    function getPlayerNames()
    {
        $this->userNames = $this->playersClass->getAllPlayersDataSortByID();
    }

    function getAllAttacks(): array
    {
        $this->getPlayerNames();
        $return = [];

        $query = $this->query("SELECT count(*) AS quantity,defenderid FROM `sos` GROUP BY defenderid");
        foreach ($query as $attacks) {
            if (isset($this->userNames[$attacks["defenderid"]])) {
                $return[$this->userNames[$attacks["defenderid"]]["playerName"]]["all"] = $attacks["quantity"];
            }
        }
        $query = $this->query("SELECT count(*) AS quantity,defenderid FROM `sos` WHERE predictedLabel = '1' GROUP BY defenderid");
        foreach ($query as $attacks) {
            if (isset($this->userNames[$attacks["defenderid"]])) {
                $return[$this->userNames[$attacks["defenderid"]]["playerName"]]["fakes"] = $attacks["quantity"];
            }
        }
        $query = $this->query("SELECT count(*) AS quantity,defenderid FROM `sos` WHERE predictedLabel > '3' GROUP BY defenderid");
        foreach ($query as $attacks) {
            if (isset($this->userNames[$attacks["defenderid"]])) {
                $return[$this->userNames[$attacks["defenderid"]]["playerName"]]["offs"] = $attacks["quantity"];
            }
        }
        $query = $this->query("SELECT count(*) AS quantity,defenderid FROM `sos` WHERE predictedLabel = '2' GROUP BY defenderid");
        foreach ($query as $attacks) {
            if (isset($this->userNames[$attacks["defenderid"]])) {
                $return[$this->userNames[$attacks["defenderid"]]["playerName"]]["possibleOffs"] = $attacks["quantity"];
            }
        }
        $query = $this->query("SELECT count(*) AS quantity,defenderid FROM `sos` WHERE UPPER(type2) = 'AG' OR UPPER(type2) = 'SNOB' GROUP BY defenderid");
        foreach ($query as $attacks) {
            if (isset($this->userNames[$attacks["defenderid"]])) {
                $return[$this->userNames[$attacks["defenderid"]]["playerName"]]["snobs"] = $attacks["quantity"];
            }
        }
        return $return;
    }

    function getAllAttackQuantity()
    {
        $query = $this->query("SELECT count(*) AS quantity FROM `sos`");
        return $query[0]["quantity"];
    }

    function getAllAttackQuantityUser($playerID)
    {
        $query = $this->query("SELECT count(*) AS quantity FROM `sos` where defenderid = '$playerID'");
        return $query[0]["quantity"];
    }

    function getAllDailyAttacksQuantity()
    {
        $query = $this->query("SELECT count(*) AS quantity FROM `daily_attacks`");
        return $query[0]["quantity"];
    }

    function getNames(): array
    {
        $this->getPlayerNames();
        $return = [];
        $query = $this->query("SELECT attackerid AS id FROM `sos` UNION DISTINCT SELECT defenderid FROM `sos`;");
        foreach ($query as $id) {
            if (isset($this->userNames[$id["id"]])) {
                $return[] = $this->userNames[$id["id"]]["playerName"];
            }
        }
        return $return;
    }
}