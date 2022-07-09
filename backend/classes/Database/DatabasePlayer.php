<?php

use JetBrains\PhpStorm\ArrayShape;

require_once dirname(__DIR__, 3) . "/backend/classes/DB.php";
require_once dirname(__DIR__, 3) . "/backend/classes/Database/DatabaseGeneral.php";

class DatabasePlayer extends DB
{
    public bool $exists = false;
    public array $playerArray;

    function __construct($world = "Allgemein", $player)
    {
        parent::__construct($world);

        $stmt = $this->conn->prepare("SELECT * FROM `userstats` WHERE UPPER(username) = UPPER(?) or userid = ?");
        $stmt->execute([$player, $player]);
        foreach ($stmt->get_result() as $row) {
            $this->playerArray = array(
                "ID" => $row["userid"],
                "name" => $row["username"],
                "tribeID" => $row["Tribeid"],
                "tribeTag" => $row["Tribetag"],
                "villages" => $row["Dorfanzahl"],
                "points" => $row["Punkte"],
                "rank" => $row["Rang"],
                "conquersWin" => $row["erobert"],
                "conquersLoss" => $row["verloren"],
                "conquersSelf" => $row["selbstadelung"],
                "conquersInternal" => $row["Intern_Adelungen"],
                "conquersBarbarian" => $row["Baba_Adelungen"],
                "maxVillages" => $row["MaxDoerfer"],
                "maxVillagesDate" => $row["DatumDoerfer"],
                "maxPoints" => $row["MaxPunkte"],
                "maxPointsDate" => $row["DatumPunkte"],
                "maxPointsDate" => $row["DatumPunkte"],
                "maxRank" => $row["BestRang"],
                "tribeChanges" => $row["Stammeswechsel"],
                "quantityReports" => $row["Reports"],
                "quantitySupReports" => $row["UT_Reports"],
                "offensiveVillages" => $row["Off"],
                "defensiveVillages" => $row["Deff"],
                "watchtowers" => $row["Wachturm"],
                "churches" => $row["Kirche"],
                "allBashis" => $row["all_kills"],
                "allRank" => $row["all_rang"],
                "attBashis" => $row["att_kills"],
                "attRank" => $row["att_rang"],
                "defBashis" => $row["deff_kills"],
                "defRank" => $row["deff_rang"],
                "supBashis" => $row["sup_kills"],
                "supRank" => $row["sup_rang"],
                "averageOff" => "Axt: " . $row["Axt"] . " Lkav: " . $row["Lkav"] . " Ramme: " . $row["Ramme"] . " Kata: " . $row["Kata"],
                "averageFake" => "Axt: " . $row["Axt_Fake"] . " Lkav: " . $row["Lkav_Fake"] . " Ramme: " . $row["Ramme_Fake"] . " Kata: " . $row["Katta_Fake"],
                "averageDef" => "Speer: " . $row["Speer_Deff_Groß"] . " Schwert: " . $row["Schwert_Deff_Groß"] . " Spy: " . $row["Spy_Deff_Groß"] . " Lkav: " . $row["Lkav_Deff_Groß"] . " Skav: " . $row["Skav_Deff_Groß"],
                "averageTab" => "Speer: " . $row["Speer_Deff"] . " Schwert: " . $row["Schwert_Deff"] . " Spy: " . $row["Spy_Deff"] . " Lkav: " . $row["Lkav_Deff"] . " Skav: " . $row["Skav_Deff"],
            );
            $this->exists = true;
        }
        $stmt->close();
    }

    function getPlayerID()
    {
        return $this->playerArray["ID"];
    }

    function getPossibleOffensiveVillages(): int
    {
        $playerID = $this->getPlayerID();
        $query = $this->query("SELECT COUNT(*) AS quantity FROM `villages` where clean = '0' AND type = '1' and playerid = '$playerID';");
        return intval($query[0]["quantity"]);
    }

    #[ArrayShape(["fake" => "int", "small" => "int", "middle" => "int", "large" => "int"])] function getAllAttackQuantitys(): array
    {
        $playerID = $this->getPlayerID();
        $query = $this->query("SELECT COUNT(*) AS quantity,size FROM `reports` WHERE size > '0' and attacker_id = '$playerID' GROUP by size ORDER BY size ASC;");
        return array(
            "fake" => intval($query["0"]["quantity"]),
            "small" => intval($query["1"]["quantity"]),
            "middle" => intval($query["2"]["quantity"]),
            "large" => intval($query["3"]["quantity"])
        );
    }
    function getLastSendTimes(): array
    {
        $return = [];
        $playerID = $this->getPlayerID();
        $query = $this->query("SELECT DISTINCT FROM_UNIXTIME(attacker_abschickzeit,'%y-%m-%d %h') AS DATE_2,FROM_UNIXTIME(attacker_abschickzeit,'%d.%m') AS date, FROM_UNIXTIME(attacker_abschickzeit,'%H') AS hour FROM `reports` where attacker_id = '$playerID' and attacker_abschickzeit>0 ORDER by DATE_2 DESC LIMIT 25;");
        foreach ($query AS $sendTime){
            $return[] = [$sendTime["hour"],$sendTime["date"]];
        }
        return $return;
    }
}