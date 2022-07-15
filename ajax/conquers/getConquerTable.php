<?php
session_start();

if (!isset($_SESSION["name"]) or !isset($_POST)) return;

require dirname(__DIR__, 2) . "/backend/classes/DB.php";
require dirname(__DIR__, 2) . "/backend/classes/World_User.php";
require dirname(__DIR__, 2) . "/backend/classes/Tribe.php";
require dirname(__DIR__, 2) . "/backend/classes/Tribes.php";
require dirname(__DIR__, 2) . "/backend/classes/Player.php";
require dirname(__DIR__, 2) . "/backend/classes/Players.php";
require dirname(__DIR__, 2) . "/backend/classes/Village.php";
require dirname(__DIR__, 2) . "/backend/classes/Villages.php";
require dirname(__DIR__, 2) . "/backend/classes/General.php";
require dirname(__DIR__, 2) . "/backend/classes/DataTables.php";

$World_User = new World_User($_SESSION["name"], $_SESSION["world"]);

if (!$World_User->isActivated()) {
    General::redirectHeader();
}

$DB = new DB();
$DB->connectTo($World_User->getWorld());

$bindParams = [];
$Query = "SELECT * FROM `conquer` WHERE 1 = 1";

$oldOwner = $_POST["oldOwner"] ?? "";
if (strlen($oldOwner) > 0) {
    $oldOwner = new Player($World_User->getWorld(),$oldOwner);
    if($oldOwner->exists){
        $bindParams[] = $oldOwner->getPlayerID();
        $Query .= " AND old_owner = ?";
    }
}

$newOwner = $_POST["newOwner"] ?? "";
if (strlen($newOwner) > 0) {
    $newOwner = new Player($World_User->getWorld(),$newOwner);
    if($newOwner->exists){
        $bindParams[] = $newOwner->getPlayerID();
        $Query .= " AND new_owner = ?";
    }
}

$oldTribe = $_POST["oldTribe"];
if (strlen($oldTribe) > 0) {
    $oldTribe = new Tribe($World_User->getWorld(), $oldTribe);
    if ($oldTribe->exists) {
        $bindParams[] = $oldTribe->getTribeID();
        $Query .= " AND old_tribe = ?";
    }
}

$newTribe = $_POST["newTribe"];
if (strlen($newTribe) > 0) {
    $newTribe = new Tribe($World_User->getWorld(), $newTribe);
    if ($newTribe->exists) {
        $bindParams[] = $newTribe->getTribeID();
        $Query .= " AND new_tribe = ?";
    }
}

$coordX = $_POST["coordX"] ?? "";
$coordY = $_POST["coordY"] ?? "";
$coord = "($coordX|$coordY)";
if (strlen($coord) == 9) {
    $coord = new Village($World_User->getWorld(),$coord);
    if($coord->exists){
        $bindParams[] = $coord->getVillageID();
        $Query .= " AND villageid = ?)";
    }
}

$dateBefore = $_POST["dateBefore"] ?? "";
if (strlen($dateBefore) > 0) {
    $d = DateTime::createFromFormat('Y-m-d', $dateBefore);
    if ($d) {
        $bindParams[] = $d->getTimestamp();
        $Query .= " AND timestamp < ?";
    }
}

$dateAfter = $_POST["dateAfter"] ?? "";
if (strlen($dateAfter) > 0) {
    $d = DateTime::createFromFormat('Y-m-d', $dateAfter);
    if ($d) {
        $bindParams[] = $d->getTimestamp();
        $Query .= " AND timestamp > ?";
    }
}

$Query .= " ORDER BY ".DataTables::sortConquerTable($_POST["order"][0]["column"]);
$Query .= DataTables::sortBy($_POST["order"][0]["dir"]);

if (isset($_POST["order"][1]["column"])) {
    $Query .= " ,".DataTables::sortConquerTable($_POST["order"][1]["column"]);
    $Query .= DataTables::sortBy($_POST["order"][1]["dir"]);
}
if (isset($_POST["order"][2]["column"])) {
    $Query .= " ,".DataTables::sortConquerTable($_POST["order"][2]["column"]);
    $Query .= DataTables::sortBy($_POST["order"][2]["dir"]);
}
if (isset($_POST["order"][3]["column"])) {
    $Query .= " ,".DataTables::sortConquerTable($_POST["order"][3]["column"]);
    $Query .= DataTables::sortBy($_POST["order"][3]["dir"]);
}
if (isset($_POST["order"][4]["column"])) {
    $Query .= " ,".DataTables::sortConquerTable($_POST["order"][2]["column"]);
    $Query .= DataTables::sortBy($_POST["order"][4]["dir"]);
}
if (isset($_POST["order"][5]["column"])) {
    $Query .= " ,".DataTables::sortConquerTable($_POST["order"][2]["column"]);
    $Query .= DataTables::sortBy($_POST["order"][5]["dir"]);
}

$allResultsQuery = str_replace("SELECT *", "SELECT COUNT(*) as quantity", $Query);
$stmt = $DB->conn->prepare($allResultsQuery);
$stmt->execute($bindParams);

foreach ($stmt->get_result() as $row) {
    $rows["recordsFiltered"] = $row["quantity"];
}
$stmt->close();

$rows["recordsTotal"] = $DB->query("SELECT COUNT(*) AS quantity FROM `conquer`");
$rows["recordsTotal"] = $rows["recordsTotal"][0]["quantity"];


$Query .= " LIMIT ? Offset ?";
$bindParams[] = $_POST["length"];
$bindParams[] = $_POST["start"];

$stmt = $DB->conn->prepare($Query);
$stmt->execute($bindParams);

$rows["data"] = [];

$tribeNames = new Tribes($World_User->getWorld());
$tribeNames = $tribeNames->getAllTribeNamesSortByID();

$playerNames = new Players($World_User->getWorld());
$playerNames = $playerNames->getAllPlayerNamesSortByID();

$villageCoords = new Villages($World_User->getWorld());
$villageCoords = $villageCoords->getAllVillageCoordsSortByID();

foreach ($stmt->get_result() as $row) {

    $villageURL = "/villageInfo?ID={$row["villageid"]}";
    $villageCoord = $villageCoords[$row["villageid"]]??"gelöschtes Dorf";
    $villageURL = "<a class='previewVillageinfo' href='$villageURL' target='_blank'> $villageCoord </a>";

    $villagePoints = $row["points"];

    $oldOwnerUrl = "/playerInfo?ID={$row["old_owner"]}";
    $oldOwnerName = $playerNames[$row["old_owner"]]??"Barbaren";
    $oldOwnerUrl = "<a class='previewPlayerinfo' href='$oldOwnerUrl' target='_blank'> $oldOwnerName </a>";

    $newOwnerUrl = "/playerInfo?ID={$row["new_owner"]}";
    $newOwnerName = $playerNames[$row["new_owner"]]??"Barbaren";
    $newOwnerUrl = "<a class='previewPlayerinfo' href='$newOwnerUrl' target='_blank'> $newOwnerName </a>";

    if($row["old_tribe"] > 0){
        $oldTribeUrl = "/tribeInfo?ID={$row["old_tribe"]}";
        $oldTribeName = $tribeNames[$row["old_tribe"]]??"gelöschter Stamm";
        $oldTribeUrl = "<a class='previewTribeinfo' href='$oldTribeUrl' target='_blank'> $oldTribeName </a>";
    }else{
        $oldTribeUrl = "";
    }

    if($row["new_tribe"] > 0){
        $newTribeUrl = "/tribeInfo?ID={$row["new_tribe"]}";
        $newTribeName = $tribeNames[$row["new_tribe"]]??"gelöschter Stamm";
        $newTribeUrl = "<a class='previewTribeinfo' href='$newTribeUrl' target='_blank'> $newTribeName </a>";
    }else{
        $newTribeUrl = "";
    }




    $time = date("H:i:s d.m.Y", $row["timestamp"]);

    $rows["data"][] = array($villageURL,$villagePoints,$oldOwnerUrl,$oldTribeUrl,$newOwnerUrl,$newTribeUrl,$time);

}

$stmt->close();
echo json_encode($rows, JSON_UNESCAPED_UNICODE);