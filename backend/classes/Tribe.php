<?php
require_once "DB.php";

class Tribe extends DB
{

    public bool $exists = false;
    public array $tribeArray;

    function __construct($world, $tribe)
    {
        parent::__construct($world);
        $stmt = $this->conn->prepare("SELECT * FROM `tribestats` WHERE UPPER(Tribetag) = UPPER(?) or UPPER(Tribename) = UPPER(?) or Tribeid = ?");
        $stmt->execute([$tribe, $tribe, $tribe]);
        foreach ($stmt->get_result() as $row) {
            $this->tribeArray = array(
                "ID" => $row["Tribeid"],
                "name" => $row["Tribename"],
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
                "maxRank" => $row["MaxRang"],
                "maxRankDate" => $row["RangDatum"],
                "tribeChanges" => $row["Stammeswechsel"],
                "allBashis" => $row["all_kills"],
                "allRank" => $row["all_rang"],
                "attBashis" => $row["att_kills"],
                "attRank" => $row["att_rang"],
                "defBashis" => $row["deff_kills"],
                "defRank" => $row["deff_rang"],
            );
            $this->exists = true;
        }
        $stmt->close();
    }

    function getTribeID()
    {
        return $this->tribeArray["ID"];
    }

    function getRank($days = ""): array
    {
        if (is_int($days)) {
            return array_reverse($this->query("SELECT rang,date FROM `tribeshistory` where id = '{$this->tribeArray["ID"]}' ORDER by date desc LIMIT $days;"));
        } else {
            return array_reverse($this->query("SELECT rang,date FROM `tribeshistory` where id = '{$this->tribeArray["ID"]}' ORDER by date desc"));
        }
    }

    function getVillages($days = ""): array
    {
        if (is_int($days)) {
            return array_reverse($this->query("SELECT villages as dorfanzahl,date FROM `tribeshistory` where id = '{$this->tribeArray["ID"]}' ORDER by date desc LIMIT $days;"));
        } else {
            return array_reverse($this->query("SELECT villages as dorfanzahl,date FROM `tribeshistory` where id = '{$this->tribeArray["ID"]}' ORDER by date desc"));
        }
    }

    function getPoints($days = ""): bool|array
    {
        if (is_int($days)) {
            return array_reverse($this->query("SELECT allepunkte as punkte,date FROM `tribeshistory` where id = '{$this->tribeArray["ID"]}' ORDER by date desc LIMIT $days;"));
        } else {
            return array_reverse($this->query("SELECT allepunkte as punkte,date FROM `tribeshistory` where id = '{$this->tribeArray["ID"]}' ORDER by date desc"));
        }
    }

    function getAllBashis($days = ""): array
    {
        if (is_int($days)) {
            return array_reverse($this->query("SELECT kills,date FROM `all_tribe` where id = '{$this->tribeArray["ID"]}' ORDER by date desc LIMIT $days;"));
        } else {
            return array_reverse($this->query("SELECT kills,date FROM `all_tribe` where id = '{$this->tribeArray["ID"]}' ORDER by date desc"));
        }
    }

    function getAttBashis($days = ""): array
    {
        if (is_int($days)) {
            return array_reverse($this->query("SELECT kills,date FROM `att_tribe` where id = '{$this->tribeArray["ID"]}' ORDER by date desc LIMIT $days;"));
        } else {
            return array_reverse($this->query("SELECT kills,date FROM `att_tribe` where id = '{$this->tribeArray["ID"]}' ORDER by date desc"));
        }
    }

    function getDefBashis($days = ""): array
    {
        if (is_int($days)) {
            return array_reverse($this->query("SELECT kills,date FROM `deff_tribe` where id = '{$this->tribeArray["ID"]}' ORDER by date desc LIMIT $days;"));
        } else {
            return array_reverse($this->query("SELECT kills,date FROM `deff_tribe` where id = '{$this->tribeArray["ID"]}' ORDER by date desc"));
        }
    }

}