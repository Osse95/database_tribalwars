<?php
require_once "DB.php";

class Tribe extends DB
{

    public bool $exists = false;
    public array $tribeArray;

    function __construct($world, $tribe)
    {
        parent::__construct($world);
        $stmt = $this->conn->prepare("SELECT * FROM `tribes` WHERE UPPER(tag) = UPPER(?) or UPPER(name) = UPPER(?) or id = ?");
        $stmt->bind_param("sss", $tribe, $tribe, $tribe);
        $stmt->execute();
        $stmt->bind_result($id, $name, $tag, $members, $villages, $points, $allPoints, $rang, $x, $y);
        while ($stmt->fetch()) {
            $this->tribeArray = array(
                "ID" => $id,
                "Name" => $name,
                "Tag" => $tag,
                "Members" => $members,
                "Villages" => $villages,
                "Points" => $points,
                "AllPoints" => $allPoints,
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
        return array_reverse($this->query("SELECT allepunkte as punkte,date FROM `tribeshistory` where id = '{$this->tribeArray["ID"]}' ORDER by date desc LIMIT $days;"));
    }

    function getAllBashis($days): bool|array
    {
        return array_reverse($this->query("SELECT kills,date FROM `all_tribe` where id = '{$this->tribeArray["ID"]}' ORDER by date desc LIMIT $days;"));
    }

}