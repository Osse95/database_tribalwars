<?php

require_once dirname(__DIR__, 3) . "/backend/classes/DB.php";
require_once dirname(__DIR__, 3) . "/backend/classes/Players.php";

class Reports extends DB
{
    private string $worldName;
    private Players $playersClass;
    private array $userNames;

    function __construct($world)
    {
        parent::__construct($world);
        preg_match("/(?<world>\w+\d+)/", $world, $match);
        $this->worldName = $match["world"];
        $this->playersClass = new Players($this->worldName);
    }

    function getNames(): array
    {
        $return = [];
        $query = $this->query("SELECT attacker_nick AS accountName FROM `reports` UNION DISTINCT SELECT defender_nick FROM `reports`;");
        foreach ($query as $nick) {
            $return[] = $nick["accountName"];
        }
        return $return;
    }

    function getTargets(): array
    {
        $return = [];
        $query = $this->query("SELECT DISTINCT catapult_building FROM `reports` where catapult_building != -1");
        foreach ($query as $target) {
            $return[] = $target["catapult_building"];
        }
        return $return;
    }

    function getPlayerNames()
    {
        $this->userNames = $this->playersClass->getAllPlayersDataSortByID();
    }

    function getTopAttackNames(): array
    {
        $this->getPlayerNames();
        $return = [];
        $query = $this->query("SELECT COUNT(*) AS quantity,defenderid FROM `soshistory` GROUP BY defenderid ORDER BY `quantity` DESC LIMIT 10");
        foreach ($query as $sos) {
            if (isset($this->userNames[$sos["defenderid"]])) {
                $return[] = array("quantity" => $sos["quantity"],
                    "name" => $this->userNames[$sos["defenderid"]]["playerName"],
                    "id" => $sos["defenderid"]);
            }
        }
        return $return;
    }

    function getMostAttacks(): array
    {
        $this->getPlayerNames();
        $return = array("large" => [], "medium" => [], "small" => []);
        $query = $this->query("SELECT COUNT(*) AS quantity,attacker_id FROM `reports` WHERE size = '4' GROUP BY attacker_id ORDER BY `quantity` DESC LIMIT 10");
        foreach ($query as $attacks) {
            if (isset($this->userNames[$attacks["attacker_id"]])) {
                $return["large"][] = array("quantity" => $attacks["quantity"],
                    "id" => $attacks["attacker_id"],
                    "name" => $this->userNames[$attacks["attacker_id"]]["playerName"]);
            }
        }
        $query = $this->query("SELECT COUNT(*) AS quantity,attacker_id FROM `reports` WHERE size = '3' GROUP BY attacker_id ORDER BY `quantity` DESC LIMIT 10");
        foreach ($query as $attacks) {
            if (isset($this->userNames[$attacks["attacker_id"]])) {
                $return["medium"][] = array("quantity" => $attacks["quantity"],
                    "id" => $attacks["attacker_id"],
                    "name" => $this->userNames[$attacks["attacker_id"]]["playerName"]);
            }
        }
        $query = $this->query("SELECT COUNT(*) AS quantity,attacker_id FROM `reports` WHERE size <= '2' GROUP BY attacker_id ORDER BY `quantity` DESC LIMIT 10");
        foreach ($query as $attacks) {
            if (isset($this->userNames[$attacks["attacker_id"]])) {
                $return["small"][] = array("quantity" => $attacks["quantity"],
                    "id" => $attacks["attacker_id"],
                    "name" => $this->userNames[$attacks["attacker_id"]]["playerName"]);
            }
        }
        return $return;
    }

    function getMostDefense(): array
    {
        $this->getPlayerNames();
        $return = array("large" => [], "medium" => [], "small" => []);
        $query = $this->query("SELECT COUNT(*) AS quantity,defender_id FROM `reports` WHERE size = '4' GROUP BY defender_id ORDER BY `quantity` DESC LIMIT 10");
        foreach ($query as $attacks) {
            if (isset($this->userNames[$attacks["defender_id"]])) {
                $return["large"][] = array("quantity" => $attacks["quantity"],
                    "id" => $attacks["attacker_id"],
                    "name" => $this->userNames[$attacks["defender_id"]]["playerName"]);
            }
        }
        $query = $this->query("SELECT COUNT(*) AS quantity,defender_id FROM `reports` WHERE size = '3' GROUP BY defender_id ORDER BY `quantity` DESC LIMIT 10");
        foreach ($query as $attacks) {
            if (isset($this->userNames[$attacks["defender_id"]])) {
                $return["medium"][] = array("quantity" => $attacks["quantity"],
                    "id" => $attacks["defender_id"],
                    "name" => $this->userNames[$attacks["defender_id"]]["playerName"]);
            }
        }
        $query = $this->query("SELECT COUNT(*) AS quantity,defender_id FROM `reports` WHERE size <= '2' GROUP BY defender_id ORDER BY `quantity` DESC LIMIT 10");
        foreach ($query as $attacks) {
            if (isset($this->userNames[$attacks["defender_id"]])) {
                $return["small"][] = array("quantity" => $attacks["quantity"],
                    "id" => $attacks["attacker_id"],
                    "name" => $this->userNames[$attacks["defender_id"]]["playerName"]);
            }
        }
        return $return;
    }

    function getTopReportUploader(): array
    {
        $return = [];
        $query = $this->query("SELECT COUNT(*) AS quantity,user FROM `reports` GROUP BY user ORDER BY `quantity` DESC LIMIT 10");
        foreach ($query as $sos) {
            $return[] = array("quantity" => $sos["quantity"],
                "name" => $sos["user"]);
        }
        return $return;
    }

    function getAllReportsQuantity()
    {
        $query = $this->query("SELECT COUNT(*) AS quantity FROM `reports`");
        return $query[0]["quantity"];
    }

    function getAllReportsSortByCoordID(): array
    {
        $return = [];
        $query = $this->query("SELECT fighttime,defender_coordsid as coordsID,id as reportID,defender_id as playerID FROM `reports` WHERE defender_coordtyp > '-1' UNION SELECT fighttime,attacker_coordsid,id,attacker_id FROM `reports` WHERE attacker_coordtyp > '-1' and size > '2' ORDER by fighttime asc;");
        foreach ($query as $report) {
            $return[$report["coordsID"]] = $report["reportID"];
        }
        return $return;
    }

    function getAllIdentifiedReportsSortByType(): array
    {
        $return = [];
        $query = $this->query("SELECT fighttime,attacker_coordsid,defender_coordsid,attacker_coordtyp,size FROM `reports`");
        foreach ($query as $report) {
            $time = $report["fighttime"];
            $attackerCoordID = $report["attacker_coordsid"];
            $defenderCoordID = $report["defender_coordsid"];
            $type = $report["attacker_coordtyp"];
            $size = $report["size"];
            $identifier = $time . $defenderCoordID . $attackerCoordID;
            if ($type == 0 or $size <= 2) {
                $return["fake"][$identifier] = 1;
            } elseif ($type == 1 and $size == 4) {
                $return["off"][$identifier] = 1;
            } elseif ($type == 1 and $size == 3) {
                $return["offMiddle"][$identifier] = 1;
            }
            if ($type == 1 and $size <= 2) {
                $return["offFake"][$identifier] = 1;
            }
            $return["allReports"][$identifier] = 1;
        }
        return $return;
    }
}
