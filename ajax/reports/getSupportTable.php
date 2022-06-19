<?php
session_start();

if (!isset($_SESSION["name"]) or !isset($_POST)) return;
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require dirname(__DIR__, 2) . "/backend/classes/DB.php";
require dirname(__DIR__, 2) . "/backend/classes/World_User.php";
require dirname(__DIR__, 2) . "/backend/classes/Tribe.php";
require dirname(__DIR__, 2) . "/backend/classes/General.php";
require dirname(__DIR__, 2) . "/backend/classes/DataTables.php";

$World_User = new World_User($_SESSION["name"], $_SESSION["world"]);

if (!$World_User->isActivated()) {
    General::redirectHeader();
}

$DB = new DB();
$DB->connectTo($World_User->getWorldVersion());

$bindParams = [];
$Query = "SELECT supporter_nick,supporter_id,defender_nick,defender_id,betreff,id,support_time FROM `ut_reports` WHERE 1 = 1";


if(!$World_User->seeAllReports()){
    $playerID = $World_User->getPlayerID();
    $Query .= " AND (supporter_id = '$playerID' OR defender_id = '$playerID')";
}

$accountName = $_POST["playerName"] ?? "";
if (strlen($accountName) > 0) {
    $bindParams[] = $accountName;
    $bindParams[] = $accountName;
    $Query .= " AND (supporter_nick = ? OR defender_nick = ?)";
}

$tribeTag = $_POST["tribeName"];
if (strlen($tribeTag) > 0) {
    $Tribe = new Tribe($_SESSION["world"], $tribeTag);
    if ($Tribe->exists) {
        $bindParams[] = $Tribe->tribeArray["ID"];
        $bindParams[] = $Tribe->tribeArray["ID"];
        $Query .= " AND (attacker_tribeid = ? OR defender_tribeid = ?)";
    }
}

$coordX = $_POST["coordX"] ?? "";
$coordY = $_POST["coordY"] ?? "";
$coord = "($coordX|$coordY)";
if (strlen($coord) == 9) {
    $bindParams[] = $coord;
    $bindParams[] = $coord;
    $Query .= " AND (attacker_coords = ? OR defender_coords = ?)";
}

$supporterName = $_POST["supporterName"] ?? "";
if (strlen($supporterName) > 0) {
    $bindParams[] = $supporterName;
    $Query .= " AND supporter_nick = ?";
}

$defenderName = $_POST["defenderName"] ?? "";
if (strlen($defenderName) > 0) {
    $bindParams[] = $defenderName;
    $Query .= " AND defender_nick = ?";
}

$dateBefore = $_POST["dateBefore"] ?? "";
if (strlen($dateBefore) > 0) {
    $d = DateTime::createFromFormat('Y-m-d', $dateBefore);
    if ($d) {
        $bindParams[] = $d->getTimestamp();
        $Query .= " AND support_time < ?";
    }
}

$dateAfter = $_POST["dateAfter"] ?? "";
if (strlen($dateAfter) > 0) {
    $d = DateTime::createFromFormat('Y-m-d', $dateAfter);
    if ($d) {
        $bindParams[] = $d->getTimestamp();
        $Query .= " AND support_time > ?";
    }
}

$Query .= " ORDER BY ".DataTables::sortSupportReportTable($_POST["order"][0]["column"]);
$Query .= DataTables::sortBy($_POST["order"][0]["dir"]);

if (isset($_POST["order"][1]["column"])) {
    $Query .= " ,".DataTables::sortSupportReportTable($_POST["order"][1]["column"]);
    $Query .= DataTables::sortBy($_POST["order"][1]["dir"]);
}
if (isset($_POST["order"][2]["column"])) {
    $Query .= " ,".DataTables::sortSupportReportTable($_POST["order"][2]["column"]);
    $Query .= DataTables::sortBy($_POST["order"][2]["dir"]);
}

$allResultsQuery = str_replace("SELECT supporter_nick,supporter_id,defender_nick,defender_id,betreff,id,support_time", "SELECT COUNT(*) as quantity", $Query);
$stmt = $DB->conn->prepare($allResultsQuery);
$stmt->execute($bindParams);

foreach ($stmt->get_result() as $row) {
    $rows["recordsFiltered"] = $row["quantity"];
}
$stmt->close();

$rows["recordsTotal"] = $DB->query("SELECT COUNT(*) AS quantity FROM `ut_reports`");
$rows["recordsTotal"] = $rows["recordsTotal"][0]["quantity"];


$Query .= " LIMIT ? Offset ?";
$bindParams[] = $_POST["length"];
$bindParams[] = $_POST["start"];

$stmt = $DB->conn->prepare($Query);
$stmt->execute($bindParams);

$rows["data"] = [];

foreach ($stmt->get_result() as $row) {
    $attackerUrl = "/playerInfo?ID={$row["supporter_id"]}";
    $attackerUrl = "<a href='$attackerUrl' target='_blank'> {$row["supporter_nick"]} </a>";

    $defenderUrl = "/playerInfo?ID={$row["defender_id"]}";
    $defenderUrl = "<a href='$defenderUrl' target='_blank'> {$row["defender_nick"]} </a>";

    $reportUrl = "/showSupportReport?ID={$row["id"]}";
    $reportUrl = "<a href='$reportUrl' target='_blank'> {$row["betreff"]} </a>";
    $supportTime = date("h:i:s d.m.Y", $row["support_time"]);
    $deleteButton = "<input type='checkbox' class='deleteReport' id='{$row["id"]}'>";

    if($World_User->isSF() || $World_User->isMod()){
        $rows["data"][] = array($attackerUrl, $defenderUrl, $reportUrl, $supportTime,$deleteButton);
    }else{
        $rows["data"][] = array($attackerUrl, $defenderUrl, $reportUrl, $supportTime);
    }

}

$stmt->close();
echo json_encode($rows, JSON_UNESCAPED_UNICODE);