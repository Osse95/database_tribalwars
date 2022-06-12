<?php

require_once dirname(__DIR__, 3) . "/backend/classes/DB.php";
require_once dirname(__DIR__, 3) . "/backend/classes/Players.php";

class Reports extends DB
{
    private string $worldName;
    private $playersClass;
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
        $return = array("large"=>[],"medium"=>[],"small"=>[]);
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
        $return = array("large"=>[],"medium"=>[],"small"=>[]);
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

    function getAllReportsQuantity(){
        $query = $this->query("SELECT COUNT(*) AS quantity FROM `reports`");
        return $query[0]["quantity"];
    }

}
