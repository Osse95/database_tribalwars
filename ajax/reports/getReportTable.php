<?php
session_start();

if (!isset($_SESSION["name"]) or !isset($_POST)) return;

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
$Query = "SELECT attacker_nick,attacker_id,defender_nick,defender_id,bericht,id,fighttime FROM `reports` WHERE 1 = 1";


if(!$World_User->seeAllReports()){
    $playerID = $World_User->getPlayerID();
    $Query .= " AND (attacker_id = '$playerID' OR defender_id = '$playerID')";
}

$accountName = $_POST["playerName"] ?? "";
if (strlen($accountName) > 0) {
    $bindParams[] = $accountName;
    $bindParams[] = $accountName;
    $Query .= " AND (attacker_nick = ? OR defender_nick = ?)";
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

$coordType = $_POST["coordType"] ?? "";
if (strlen($coordType) > 0) {
    switch ($coordType) {
        case "Off":
            $bindParams[] = 1;
            $bindParams[] = 1;
            $Query .= " AND (attacker_coordtyp = ? OR defender_coordtyp = ?)";
            break;
        case("Def"):
            $bindParams[] = 0;
            $bindParams[] = 0;
            $Query .= " AND (attacker_coordtyp = ? OR defender_coordtyp = ?)";
            break;
    }
}

$watchtower = $_POST["watchtower"] ?? "false";
if ($watchtower == "true") {
    $Query .= " AND buildings_watchtower > 0";
}

$church = $_POST["church"] ?? "false";
if ($church == "true") {
    $Query .= " AND (buildings_firstchurch > 0 OR buildings_church > 0)";
}

$academy = $_POST["academy"] ?? "false";
if ($academy == "true") {
    $Query .= " AND buildings_snob > 0";
}

$attackerName = $_POST["attackerName"] ?? "";
if (strlen($attackerName) > 0) {
    $bindParams[] = $attackerName;
    $Query .= " AND attacker_nick = ?";
}

$defenderName = $_POST["defenderName"] ?? "";
if (strlen($defenderName) > 0) {
    $bindParams[] = $defenderName;
    $Query .= " AND defender_nick = ?";
}

$storageLevel = $_POST["storageLevel"] ?? "";
if (intval($storageLevel) > 0) {
    $bindParams[] = $storageLevel;
    $Query .= " AND buildings_storage < ? AND buildings_storage > -1";
}

$farmLevel = $_POST["farmLevel"] ?? "";
if (intval($farmLevel) > 0) {
    $bindParams[] = $farmLevel;
    $Query .= " AND buildings_farm < ? AND buildings_farm > -1";
}

$smithLevel = $_POST["smithLevel"] ?? "";
if (intval($smithLevel) > 0) {
    $bindParams[] = $smithLevel;
    $Query .= " AND buildings_smith < ? AND buildings_smith > -1";
}

$watchtowerLevel = $_POST["watchtowerLevel"] ?? "";
if (intval($watchtowerLevel) > 0) {
    $bindParams[] = $watchtowerLevel;
    $Query .= " AND buildings_watchtower < ? AND buildings_watchtower > -1";
}

$moodUnder = $_POST["moodUnder"] ?? "";
if (intval($moodUnder) > 0) {
    $bindParams[] = $moodUnder;
    $bindParams[] = time() - 86400;
    $Query .= " AND mood_after < ? mood_after > -1 and fighttime > ?";
}

$dateBefore = $_POST["dateBefore"] ?? "";
if (strlen($dateBefore) > 0) {
    $d = DateTime::createFromFormat('Y-m-d', $dateBefore);
    if ($d) {
        $bindParams[] = $d->getTimestamp();
        $Query .= " AND fighttime < ?";
    }
}

$dateAfter = $_POST["dateAfter"] ?? "";
if (strlen($dateAfter) > 0) {
    $d = DateTime::createFromFormat('Y-m-d', $dateAfter);
    if ($d) {
        $bindParams[] = $d->getTimestamp();
        $Query .= " AND fighttime > ?";
    }
}

$cataTarget = $_POST["cataTarget"] ?? "";
if (strlen($cataTarget) > 0) {
    $bindParams[] = $cataTarget;
    $Query .= " AND catapult_building = ?";
}


$Query .= " ORDER BY ".DataTables::sortReportTable($_POST["order"][0]["column"]);
$Query .= DataTables::sortBy($_POST["order"][0]["dir"]);

if (isset($_POST["order"][1]["column"])) {
    $Query .= " ,".DataTables::sortReportTable($_POST["order"][1]["column"]);
    $Query .= DataTables::sortBy($_POST["order"][1]["dir"]);
}
if (isset($_POST["order"][2]["column"])) {
    $Query .= " ,".DataTables::sortReportTable($_POST["order"][2]["column"]);
    $Query .= DataTables::sortBy($_POST["order"][2]["dir"]);
}

$allResultsQuery = str_replace("SELECT attacker_nick,attacker_id,defender_nick,defender_id,bericht,id,fighttime", "SELECT COUNT(*) as quantity", $Query);
$stmt = $DB->conn->prepare($allResultsQuery);
$stmt->execute($bindParams);

foreach ($stmt->get_result() as $row) {
    $rows["recordsFiltered"] = $row["quantity"];
}
$stmt->close();

$rows["recordsTotal"] = $DB->query("SELECT COUNT(*) AS quantity FROM `reports`");
$rows["recordsTotal"] = $rows["recordsTotal"][0]["quantity"];


$Query .= " LIMIT ? Offset ?";
$bindParams[] = $_POST["length"];
$bindParams[] = $_POST["start"];

$stmt = $DB->conn->prepare($Query);
$stmt->execute($bindParams);

$rows["data"] = [];

foreach ($stmt->get_result() as $row) {
    $attackerUrl = "/playerInfo?ID={$row["attacker_id"]}";
    $attackerUrl = "<a href='$attackerUrl' target='_blank'> {$row["attacker_nick"]} </a>";

    $defenderUrl = "/playerInfo?ID={$row["defender_id"]}";
    $defenderUrl = "<a href='$defenderUrl' target='_blank'> {$row["defender_nick"]} </a>";

    $reportUrl = "/showReport?ID={$row["id"]}";
    $reportUrl = "<a href='$reportUrl' target='_blank'> {$row["bericht"]} </a>
                    <div class='box'>
					<object data='/pages/report/showReportPrev.php?id={$row["id"]}' class='testbox2'>
					</object></div>";
    $fightTime = date("h:i:s d.m.Y", $row["fighttime"]);
    $deleteButton = "<input type='checkbox' class='deleteReport' id='{$row["id"]}'>";
    if($World_User->isSF() || $World_User->isMod()){
        $rows["data"][] = array($attackerUrl, $defenderUrl, $reportUrl, $fightTime,$deleteButton);
    }else{
        $rows["data"][] = array($attackerUrl, $defenderUrl, $reportUrl, $fightTime);
    }

}

$stmt->close();
echo json_encode($rows, JSON_UNESCAPED_UNICODE);