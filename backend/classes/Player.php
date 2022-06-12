<?php
require_once "DB.php";

class Player extends DB
{
    public bool $exists = false;
    public array $playerArray;

    function __construct($world, $player)
    {
        parent::__construct($world);
        $stmt = $this->conn->prepare("SELECT * FROM `{$this->world}`.`spielerdaten` WHERE UPPER(spielername) = UPPER(?) or spielerid = ?");
        $stmt->bind_param("ss", $player, $player);
        $stmt->execute();
        $stmt->bind_result($id, $name, $tribeID, $villages, $points, $rang, $x, $y);
        while ($stmt->fetch()) {
            $this->playerArray = array(
                "ID" => $id,
                "Name" => $name,
                "TribeID" => $tribeID,
                "Villages" => $villages,
                "Points" => $points,
                "Rang" => $rang,
                "X" => $x,
                "Y" => $y
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