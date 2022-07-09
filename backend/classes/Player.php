<?php
require_once "DB.php";

class Player extends DB
{
    public bool $exists = false;
    public array $playerArray;

    function __construct($world, $player)
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
                "maxRank" => $row["BestRang"],
                "maxRankDate" => $row["DatumRang"],
                "tribeChanges" => $row["Stammeswechsel"],
                "allBashis" => $row["all_kills"],
                "allRank" => $row["all_rang"],
                "attBashis" => $row["att_kills"],
                "attRank" => $row["att_rang"],
                "defBashis" => $row["deff_kills"],
                "defRank" => $row["deff_rang"],
                "supBashis" => $row["sup_kills"],
                "supRank" => $row["sup_rang"],
            );
            $this->exists = true;
        }
        $stmt->close();
    }

    function loadPlayerData()
    {

    }

    function getPlayerID()
    {
        return $this->playerArray["ID"];
    }

    function getPoints($days = ""): array
    {
        if (is_int($days)) {
            return array_reverse($this->query("SELECT punkte,date FROM `spielerdatenhistory` where spielerid = '{$this->playerArray["ID"]}' ORDER by date desc LIMIT $days;"));
        } else {
            return array_reverse($this->query("SELECT punkte,date FROM `spielerdatenhistory` where spielerid = '{$this->playerArray["ID"]}' ORDER by date desc"));
        }
    }

    function getRank($days = ""): array
    {
        if (is_int($days)) {
            return array_reverse($this->query("SELECT rang,date FROM `spielerdatenhistory` where spielerid = '{$this->playerArray["ID"]}' ORDER by date desc LIMIT $days;"));
        } else {
            return array_reverse($this->query("SELECT rang,date FROM `spielerdatenhistory` where spielerid = '{$this->playerArray["ID"]}' ORDER by date desc"));
        }
    }

    function getVillages($days = ""): array
    {
        if (is_int($days)) {
            return array_reverse($this->query("SELECT dorfanzahl,date FROM `spielerdatenhistory` where spielerid = '{$this->playerArray["ID"]}' ORDER by date desc LIMIT $days;"));
        } else {
            return array_reverse($this->query("SELECT dorfanzahl,date FROM `spielerdatenhistory` where spielerid = '{$this->playerArray["ID"]}' ORDER by date desc"));
        }
    }

    function getAllBashis($days = ""): array
    {
        if (is_int($days)) {
            return array_reverse($this->query("SELECT kills,date FROM `all` where id = '{$this->playerArray["ID"]}' ORDER by date desc LIMIT $days;"));
        } else {
            return array_reverse($this->query("SELECT kills,date FROM `all` where id = '{$this->playerArray["ID"]}' ORDER by date desc"));
        }
    }

    function getAttBashis($days = ""): array
    {
        if (is_int($days)) {
            return array_reverse($this->query("SELECT kills,date FROM `att` where id = '{$this->playerArray["ID"]}' ORDER by date desc LIMIT $days;"));
        } else {
            return array_reverse($this->query("SELECT kills,date FROM `att` where id = '{$this->playerArray["ID"]}' ORDER by date desc"));
        }
    }

    function getDefBashis($days = ""): array
    {
        if (is_int($days)) {
            return array_reverse($this->query("SELECT kills,date FROM `deff` where id = '{$this->playerArray["ID"]}' ORDER by date desc LIMIT $days;"));
        } else {
            return array_reverse($this->query("SELECT kills,date FROM `deff` where id = '{$this->playerArray["ID"]}' ORDER by date desc"));
        }
    }

    function getSupBashis($days = ""): array
    {
        if (is_int($days)) {
            return array_reverse($this->query("SELECT kills,date FROM `sup` where id = '{$this->playerArray["ID"]}' ORDER by date desc LIMIT $days;"));
        } else {
            return array_reverse($this->query("SELECT kills,date FROM `sup` where id = '{$this->playerArray["ID"]}' ORDER by date desc"));
        }
    }

}