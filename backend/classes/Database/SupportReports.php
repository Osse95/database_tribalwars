<?php

require_once dirname(__DIR__, 3) . "/backend/classes/DB.php";
require_once dirname(__DIR__, 3) . "/backend/classes/Players.php";

class SupportReports extends DB
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
        $query = $this->query("SELECT supporter_nick AS accountName FROM `ut_reports` UNION DISTINCT SELECT defender_nick FROM `ut_reports`;");
        foreach ($query as $nick) {
            $return[] = $nick["accountName"];
        }
        return $return;
    }
    function getPlayerNames()
    {
        $this->userNames = $this->playersClass->getAllPlayersDataSortByID();
    }

    function getAllReportsQuantity(){
        $query = $this->query("SELECT COUNT(*) AS quantity FROM `ut_reports`");
        return $query[0]["quantity"];
    }

}
