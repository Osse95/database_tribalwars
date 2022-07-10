<?php

use JetBrains\PhpStorm\ArrayShape;

require_once dirname(__DIR__, 3) . "/backend/classes/DB.php";
require_once dirname(__DIR__, 3) . "/backend/classes/Inno.php";

class DatabaseVillage extends DB
{

    private string $villageID;

    public function __construct($world, $village)
    {
        parent::__construct($world);
        $this->villageID = $village;
    }

    #[ArrayShape(["reports" => "int|mixed", "supReports" => "int|mixed"])] function getQuantityReports(): array
    {
        $return = array(
            "reports" => 0,
            "supReports" => 0
        );
        $villageID = $this->villageID;
        $query = $this->query("SELECT COUNT(*) as quantity FROM `reports` where (defender_coordsid = '$villageID' or attacker_coordsid = '$villageID')");
        $return["reports"] = $query[0]["quantity"] ?? 0;
        $query = $this->query("SELECT COUNT(*) as quantity FROM `ut_reports` where (defender_koordsid = '$villageID' or supporter_koordsid = '$villageID')");
        $return["supReports"] = $query[0]["quantity"] ?? 0;

        return $return;
    }

    function getVillageType(): string
    {
        $villageID = $this->villageID;
        $query = $this->query("SELECT type FROM `villages` where coordsid = '$villageID'");
        $villageType = intval($query[0]["type"]??-1);
        return match ($villageType) {
            0 => "Def",
            1 => "Off",
            default => "Unbekannt",
        };
    }

}