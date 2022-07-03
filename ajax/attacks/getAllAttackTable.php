<?php
session_start();

if (!isset($_SESSION["name"]) or !isset($_POST)) return;
require dirname(__DIR__, 2) . "/backend/classes/DB.php";
require dirname(__DIR__, 2) . "/backend/classes/World_User.php";
require dirname(__DIR__, 2) . "/backend/classes/Players.php";
require dirname(__DIR__, 2) . "/backend/classes/Player.php";
require dirname(__DIR__, 2) . "/backend/classes/General.php";
require dirname(__DIR__, 2) . "/backend/classes/DataTables.php";

$World_User = new World_User($_SESSION["name"], $_SESSION["world"]);

if (!$World_User->isActivated()) {
    General::redirectHeader();
}

$DB = new DB();
$DB->connectTo($World_User->getWorldVersion());

$bindParams = [];
$Query = "SELECT * FROM `sos` WHERE 1 = 1";

if(!$World_User->seeAllAttacks()){
    $playerID = $World_User->getPlayerID();
    $Query .= " AND (attackerid = '$playerID' OR defenderid = '$playerID')";
}

$accountName = $_POST["playerName"] ?? "";
if (strlen($accountName) > 0) {
    $Player = new Player($_SESSION["world"],$accountName);
    if($Player->exists){
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

$type = $_POST["type"]??"";
if(strlen($type)>0){
    $bindParams[] = $type;
    $Query .= " AND type2 = ?";
}

$off = $_POST["off"]??"false";
if($off == "true"){
    $Query .= " AND predictedLabel >= 2";
}

$fake = $_POST["fake"]??"false";
if($fake == "true"){
    $Query .= " AND predictedLabel = 1";
}

$doubler = $_POST["double"]??"false";
if($doubler == "true"){
    $bindParams[] = 0;
    $Query .= " AND counter > ?";
}


$Query .= " ORDER BY ".DataTables::sortAllAttacks($_POST["order"][0]["column"]);
$Query .= DataTables::sortBy($_POST["order"][0]["dir"]);

if (isset($_POST["order"][1]["column"])) {
    $Query .= " ,".DataTables::sortAllAttacks($_POST["order"][1]["column"]);
    $Query .= DataTables::sortBy($_POST["order"][1]["dir"]);
}
if (isset($_POST["order"][2]["column"])) {
    $Query .= " ,".DataTables::sortAllAttacks($_POST["order"][2]["column"]);
    $Query .= DataTables::sortBy($_POST["order"][2]["dir"]);
}
if (isset($_POST["order"][3]["column"])) {
    $Query .= " ,".DataTables::sortAllAttacks($_POST["order"][3]["column"]);
    $Query .= DataTables::sortBy($_POST["order"][3]["dir"]);
}
if (isset($_POST["order"][4]["column"])) {
    $Query .= " ,".DataTables::sortAllAttacks($_POST["order"][4]["column"]);
    $Query .= DataTables::sortBy($_POST["order"][4]["dir"]);
}
if (isset($_POST["order"][5]["column"])) {
    $Query .= " ,".DataTables::sortAllAttacks($_POST["order"][5]["column"]);
    $Query .= DataTables::sortBy($_POST["order"][5]["dir"]);
}
if (isset($_POST["order"][6]["column"])) {
    $Query .= " ,".DataTables::sortAllAttacks($_POST["order"][6]["column"]);
    $Query .= DataTables::sortBy($_POST["order"][6]["dir"]);
}
if (isset($_POST["order"][7]["column"])) {
    $Query .= " ,".DataTables::sortAllAttacks($_POST["order"][7]["column"]);
    $Query .= DataTables::sortBy($_POST["order"][7]["dir"]);
}
if (isset($_POST["order"][8]["column"])) {
    $Query .= " ,".DataTables::sortAllAttacks($_POST["order"][8]["column"]);
    $Query .= DataTables::sortBy($_POST["order"][8]["dir"]);
}
if (isset($_POST["order"][9]["column"])) {
    $Query .= " ,".DataTables::sortAllAttacks($_POST["order"][9]["column"]);
    $Query .= DataTables::sortBy($_POST["order"][9]["dir"]);
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

    $size = $row["attack"];
    $type = match ($size) {
        "attack_small" => "<img src='/assets/images/inno/icons/attack_small.png' alt='attack_small'> ",
        "attack_medium" => "<img src='/assets/images/inno/icons/attack_medium.png' alt='attack_medium'> ",
        "attack_large" => "<img src='/assets/images/inno/icons/attack_large.png' alt='attack_large'> ",
        default => "<img src='/assets/images/inno/icons/attack.png' alt='attack'> ",
    };

    $unitType = strtolower($row["type2"]);
    $file = dirname(__DIR__,2)."/assets/images/inno/units/$unitType.png";
    if(file_exists($file)){
        $type .= "<img src='/assets/images/inno/units/$unitType.png' alt='$unitType'> " . $row["type"];
    }else{
        $type .= $row["type2"] ." ". $row["type"];
    }

    $defenderUrl = "/playerInfo?ID={$row["defenderid"]}";
    $defenderName = $playerNames[$row["defenderid"]]["playerName"]??"Barbar";
    $defenderUrl = "<a href='$defenderUrl' target='_blank'> $defenderName </a>";

    $defenderCoordUrl = "/villageInfo?ID={$row["defenderdorfid"]}";
    $defenderCoordUrl = "<a href='$defenderCoordUrl' target='_blank'> {$row["defendercoords"]} </a>";

    $attackerUrl = "/playerInfo?ID={$row["attackerid"]}";
    $attackerName = $playerNames[$row["attackerid"]]["playerName"]??"Barbar";
    $attackerUrl = "<a href='$attackerUrl' target='_blank'> $attackerName </a>";

    $attackerCoordUrl = "/villageInfo?ID={$row["attackerdorfid"]}";
    $attackerCoordUrl = "<a href='$attackerCoordUrl' target='_blank'> {$row["attackercoords"]} </a>";

    $reason = $row["reason"];

    $readInTime = date("d.m.Y h:i:s", $row["eingelesen_am"]);

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

    if($World_User->isMod() || $World_User->isSF()){
        $rows["data"][] = array($type,$defenderUrl,$defenderCoordUrl,$attackerUrl,$attackerCoordUrl,$reason,$readInTime,$doubler,$typ,$arrivalTime,$deleteButton);
    }else{
        $rows["data"][] = array($type,$defenderUrl,$defenderCoordUrl,$attackerUrl,$attackerCoordUrl,$reason,$readInTime,$doubler,$typ,$arrivalTime);
    }

}

$stmt->close();
echo json_encode($rows, JSON_UNESCAPED_UNICODE);