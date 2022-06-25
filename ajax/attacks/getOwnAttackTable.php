<?php
session_start();

if (!isset($_SESSION["name"]) or !isset($_POST)) return;
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require dirname(__DIR__, 2) . "/backend/classes/DB.php";
require dirname(__DIR__, 2) . "/backend/classes/World_User.php";
require dirname(__DIR__, 2) . "/backend/classes/World.php";
require dirname(__DIR__, 2) . "/backend/classes/Players.php";
require dirname(__DIR__, 2) . "/backend/classes/Player.php";
require dirname(__DIR__, 2) . "/backend/classes/General.php";
require dirname(__DIR__, 2) . "/backend/classes/DataTables.php";
require dirname(__DIR__, 2) . "/backend/classes/Database/Reports.php";
require dirname(__DIR__, 2) . "/backend/classes/Villages.php";
$World_User = new World_User($_SESSION["name"], $_SESSION["world"]);

if (!$World_User->isActivated()) {
    General::redirectHeader();
}
$DB = new DB();
$DB->connectTo($World_User->getWorldVersion());

$World = new World($_SESSION["world"]);

$Reports = new Reports($World_User->getWorldVersion());
$knownVillages = $Reports->getAllReportsSortByCoordID();

$Villages = new Villages($World_User->getWorld());
$villageInfos = $Villages->getAllVillagesSortByID();

$bindParams = [];
$Query = "SELECT * FROM `sos` WHERE 1 = 1";

$playerID = $World_User->getPlayerID();
$bindParams[] = $playerID;
$bindParams[] = $playerID;
$Query .= " AND (attackerid = ? OR defenderid = ?)";

$accountName = $_POST["playerName"] ?? "";
if (strlen($accountName) > 0) {
    $Player = new Player($_SESSION["world"], $accountName);
    if ($Player->exists) {
        $bindParams[] = $Player->playerArray["ID"];
        $bindParams[] = $Player->playerArray["ID"];
        $Query .= " AND (attackerid = ? OR defenderid = ?)";
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

$type = $_POST["type"] ?? "";
if (strlen($type) > 0) {
    $bindParams[] = $type;
    $Query .= " AND type2 = ?";
}

$off = $_POST["off"] ?? "false";
if ($off == "true") {
    $Query .= " AND predictedLabel >= 2";
}

$fake = $_POST["fake"] ?? "false";
if ($fake == "true") {
    $Query .= " AND predictedLabel = 1";
}

$doubler = $_POST["double"] ?? "false";
if ($doubler == "true") {
    $Query .= " AND counter > 0";
}


if ($World->isWatchtowerAvailable()) {
    $Query .= " ORDER BY " . DataTables::sortOwnAttacksWithWatchtower($_POST["order"][0]["column"]);
} else {
    $Query .= " ORDER BY " . DataTables::sortOwnAttacksWithoutWatchtower($_POST["order"][0]["column"]);
}
$Query .= DataTables::sortBy($_POST["order"][0]["dir"]);

if (isset($_POST["order"][1]["column"])) {
    for ($i = 1; $i < count($_POST["order"]); $i++) {
        if ($World->isWatchtowerAvailable()) {
            $Query .= " ," . DataTables::sortOwnAttacksWithWatchtower($_POST["order"][$i]["column"]);
        } else {
            $Query .= " ," . DataTables::sortOwnAttacksWithoutWatchtower($_POST["order"][$i]["column"]);
        }
        $Query .= DataTables::sortBy($_POST["order"][$i]["dir"]);
    }
}

$allResultsQuery = str_replace("SELECT *", "SELECT COUNT(*) as quantity", $Query);
$stmt = $DB->conn->prepare($allResultsQuery);
$stmt->execute($bindParams);

foreach ($stmt->get_result() as $row) {
    $rows["recordsFiltered"] = $row["quantity"];
}
$stmt->close();

$rows["recordsTotal"] = $DB->query("SELECT COUNT(*) AS quantity FROM `sos`");
$rows["recordsTotal"] = $rows["recordsTotal"][0]["quantity"];


$Query .= " LIMIT ? Offset ?";
$bindParams[] = $_POST["length"];
$bindParams[] = $_POST["start"];

$stmt = $DB->conn->prepare($Query);
$stmt->execute($bindParams);

$rows["data"] = [];
$playerNames = new Players($_SESSION["world"]);
$playerNames = $playerNames->getAllPlayersDataSortByID();

foreach ($stmt->get_result() as $row) {
    $type = strtolower($row["type2"]);
    $file = dirname(__DIR__, 2) . "/assets/images/inno/units/$type.png";
    if (file_exists($file)) {
        $type = "<img src='/assets/images/inno/units/$type.png' alt='$type'> " . $row["type"];
    } else {
        $type = $row["type2"] . " " . $row["type"];
    }

    $defenderCoordUrl = "/villageInfo?ID={$row["defenderdorfid"]}";
    $defenderCoordUrl = "<a href='$defenderCoordUrl' target='_blank'> {$row["defendercoords"]} </a>";

    $attackerUrl = "/playerInfo?ID={$row["attackerid"]}";
    $attackerName = $playerNames[$row["attackerid"]]["playerName"] ?? "Barbar";
    $attackerUrl = "<a href='$attackerUrl' target='_blank'> $attackerName </a>";

    $attackerCoordUrl = "/villageInfo?ID={$row["attackerdorfid"]}";
    $attackerCoordUrl = "<a href='$attackerCoordUrl' target='_blank'> {$row["attackercoords"]} </a>";

    if(isset($villageInfos[$row["attackerdorfid"]])){
        $attackerVillagePoints = $villageInfos[$row["attackerdorfid"]]["points"];
    }else{
        $attackerVillagePoints = 0;
    }

    if (isset($knownVillages[$row["attackerdorfid"]])) {
        $knownVillage = $knownVillages[$row["attackerdorfid"]];
        $knownVillage = "<a href='/showReport?id=$knownVillage'target='_blank'>Report</a>
                            <div class='preview'>
                                <object data='/showReport?id=$knownVillage=preview=attack' class='previewBox'>
                                </object>
                            </div>";
    }else{
        $knownVillage = "";
    }

    $reason = $row["reason"];

    $watchtowerTime = "";
    if ($row["watchtowertime"] > 1 && $row["watchtowertime"] < $row["timeunix"]) {
        $watchtowerTime = date("d.m.Y h:i:s", $row["eingelesen_am"]);
    }

    $doubler = $row["counter"];

    $typ = $row["predictedLabel"];
    switch ($typ) {
        case "0":
            $typ = "Unbekannt";
            break;
        case "1":
            $typ = "Fake";
            break;
        case "2":
            $typ = "mögliche Off";
            break;
        case "3":
            $typ = "Off";
            break;
        case "4":
            $typ = "mittlerer Angriff";
            break;
    }
    if(strtolower($row["type2"]) == "snob" OR strtolower($row["type2"]) == "ag"){
        $typ = "AG";
    }
    $arrivalTime = date("d.m.Y h:i:s", $row["timeunix"]);

    $deleteButton = "<input type='checkbox' class='deleteAttack' id='{$row["id"]}'>";
    if ($World->isWatchtowerAvailable()) {
        $rows["data"][] = array($type, $defenderCoordUrl, $knownVillage, $reason, $attackerUrl, $attackerCoordUrl, $attackerVillagePoints, $doubler, $typ, $watchtowerTime, $arrivalTime, $deleteButton);
    } else {
        $rows["data"][] = array($type, $defenderCoordUrl, $knownVillage, $reason, $attackerUrl, $attackerCoordUrl, $attackerVillagePoints, $doubler, $typ, $arrivalTime, $deleteButton);
    }


}

$stmt->close();
echo json_encode($rows, JSON_UNESCAPED_UNICODE);