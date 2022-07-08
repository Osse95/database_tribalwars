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
        $stmt->execute([$tribe,$tribe,$tribe]);
        foreach ($stmt->get_result() as $row) {
            $this->tribeArray = array(
                "ID" => $row["Tribeid"],
                "Name" => $row["Tribename"],
                "Tag" => $row["Tribetag"],
                "Members" => $row["Members"],
                "Villages" => $row["Dorfanzahl"],
                "Points" => $row["Punkte"],
                "Rang" => $row["Rang"]
            );
            $this->exists = true;
        }
        $stmt->close();
    }

    function getTribeID(){
        return $this->tribeArray["ID"];
    }

    function getPoints($days): bool|array
    {
        return array_reverse($this->query("SELECT allepunkte as punkte,date FROM `tribeshistory` where id = '{$this->tribeArray["ID"]}' ORDER by date desc LIMIT $days;"));
    }

    function getAllBashis($days): bool|array
    {
        return array_reverse($this->query("SELECT kills,date FROM `all_tribe` where id = '{$this->tribeArray["ID"]}' ORDER by date desc LIMIT $days;"));
    }

}