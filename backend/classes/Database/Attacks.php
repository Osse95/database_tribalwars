<?php

require_once dirname(__DIR__, 3) . "/backend/classes/DB.php";
require_once dirname(__DIR__, 3) . "/backend/classes/Players.php";
require_once dirname(__DIR__, 3) . "/backend/classes/Database/Reports.php";

class Attacks extends DB
{
    private string $worldName;
    private Players $playersClass;
    private Reports $reportsClass;
    private array $userNames;

    function __construct($world = "Allgemein")
    {
        parent::__construct($world);
        $this->reportsClass = new Reports($world);
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
        $query = $this->query("SELECT count(*) AS quantity,defenderid FROM `sos` WHERE predictedLabel >= '3' GROUP BY defenderid");
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

    function getEvaluation(): array
    {
        $return = array(
            "identifiedFakes" => 0,
            "readInReportsFakes" => 0,
            "correctFakes" => 0,
            "offMiddleInsteadOfFake" => 0,
            "offLargeInsteadOfFake" => 0,
            "identifiedOffs" => 0,
            "readInReportsOffs" => 0,
            "correctOffs" => 0,
            "fakeInsteadOfOff" => 0,
            "offFakeInsteadOfOff" => 0
        );
        $query = $this->query("SELECT * FROM `soshistory` where attack = 'attack' and predictedLabel > 0");
        $identifiedReports = $this->reportsClass->getAllIdentifiedReportsSortByType();
        foreach ($query as $attack) {
            $time = $attack["timeunix"];
            $attackerCoordID = $attack["attackerdorfid"];
            $defenderCoordID = $attack["defenderdorfid"];
            $identifier = $time . $defenderCoordID . $attackerCoordID;
            $pL = $attack["predictedLabel"];
            if ($pL == 1) {
                $return["identifiedFakes"] += 1;
                if (isset($identifiedReports["allReports"][$identifier])) {
                    $return["readInReportsFakes"] += 1;
                }
                if (isset($identifiedReports["fake"][$identifier])) {
                    $return["correctFakes"] += 1;
                } elseif (isset($identifiedReports["off"][$identifier])) {
                    $return["offLargeInsteadOfFake"] += 1;
                } elseif (isset($identifiedReports["offMiddle"][$identifier])) {
                    $return["offMiddleInsteadOfFake"] += 1;
                }
            } elseif ($pL == 2) {
                $return["identifiedOffs"] += 1;
                if (isset($identifiedReports["allReports"][$identifier])) {
                    $return["readInReportsOffs"] += 1;
                }
                if (isset($identifiedReports["off"][$identifier])) {
                    $return["correctOffs"] += 1;
                } elseif (isset($identifiedReports["fake"][$identifier])) {
                    $return["fakeInsteadOfOff"] += 1;
                }
                if (isset($identifiedReports["offFake"][$identifier])) {
                    $return["offFakeInsteadOfOff"] += 1;
                }
            }
        }
        return $return;
    }

    function getAllOffCoords(): array
    {
        $return = [];
        $query = $this->query("SELECT DISTINCT attackercoords FROM `sos` WHERE attack= 'attack' and predictedLabel = 2");
        foreach ($query as $attack) {
            $return[] = $attack["attackercoords"];
        }
        return $return;
    }

    function getAllFakeCoords(): array
    {
        $return = [];
        $query = $this->query("SELECT DISTINCT attackercoords FROM `sos` WHERE attack= 'attack' and predictedLabel = 1");
        foreach ($query as $attack) {
            $return[] = $attack["attackercoords"];

        }
        return $return;
    }
}