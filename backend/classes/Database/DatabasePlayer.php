<?php
require_once dirname(__DIR__, 3) . "/backend/classes/DB.php";
require_once dirname(__DIR__, 3) . "/backend/classes/Database/DatabaseGeneral.php";

class DatabasePlayer extends DB
{
    public bool $exists = false;
    public array $playerArray;
    public DatabaseGeneral $DatabaseGeneral;

    function __construct($world = "Allgemein",$player)
    {
        parent::__construct($world);
        $this->DatabaseGeneral = new DatabaseGeneral($world);

        $stmt = $this->conn->prepare("SELECT * FROM `userstats` WHERE UPPER(username) = UPPER(?) or userid = ?");
        $stmt->execute([$player,$player]);
        foreach ($stmt->get_result() as $row) {
            $this->playerArray = array(
                "ID" => $row["userid"],
                "Name" => $row["username"],
                "TribeID" => $row["Tribeid"],
                "TribeTag"=> $row["Tribetag"],
                "Villages" => $row["Dorfanzahl"],
                "Points" => $row["Punkte"],
                "Rang" => $row["Rang"]
            );
            $this->exists = true;
        }
        $stmt->close();
    }
}