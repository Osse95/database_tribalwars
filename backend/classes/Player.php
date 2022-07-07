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
        $stmt->execute([$player,$player]);
        foreach ($stmt->get_result() as $row) {
            $this->playerArray = array(
                "ID" => $row["userid"],
                "Name" => $row["username"],
                "TribeID" => $row["Tribeid"],
                "Villages" => $row["Dorfanzahl"],
                "Points" => $row["Punkte"],
                "Rang" => $row["Rang"]
            );
            $this->exists = true;
        }
        $stmt->close();
    }

    function getPoints($days): bool|array
    {
        return array_reverse($this->query("SELECT punkte,date FROM `spielerdatenhistory` where spielerid = '{$this->playerArray["ID"]}' ORDER by date desc LIMIT $days;"));
    }

    function getAllBashis($days): bool|array
    {
        return array_reverse($this->query("SELECT kills,date FROM `all` where id = '{$this->playerArray["ID"]}' ORDER by date desc LIMIT $days;"));
    }

}