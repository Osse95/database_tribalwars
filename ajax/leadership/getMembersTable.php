<?php
session_start();

if (!isset($_SESSION["name"])) return;

require dirname(__DIR__, 2) . "/backend/classes/World_User.php";
require dirname(__DIR__, 2) . "/backend/classes/General.php";
require dirname(__DIR__, 2) . "/backend/classes/DataTables.php";
require dirname(__DIR__, 2) . "/backend/classes/Players.php";
$World_User = new World_User($_SESSION["name"], $_SESSION["world"]);

if (!$World_User->isSF()) {
    General::redirectHeader();
}

$DB = new DB();
$world = $World_User->getWorld();
$version = $World_User->getVersion();

$bindParams = [];
$Query = "SELECT * FROM `userrollen` WHERE world = '$world' and (Version = $version OR Version = -1) and Level < 11";

$searchName = $_POST["search"]["value"] ?? "";
if(strlen($searchName) > 0){
    $Query .= " and UPPER(name) like UPPER(CONCAT('%',?, '%'))";
    $bindParams[] = $searchName;
}

$Query .= " ORDER BY " . DataTables::sortAllMembers($_POST["order"][0]["column"]??"");
$Query .= DataTables::sortBy($_POST["order"][0]["dir"]);

if (isset($_POST["order"][1]["column"])) {
    $Query .= " ," . DataTables::sortAllMembers($_POST["order"][1]["column"]);
    $Query .= DataTables::sortBy($_POST["order"][1]["dir"]);
}
if (isset($_POST["order"][2]["column"])) {
    $Query .= " ," . DataTables::sortAllMembers($_POST["order"][2]["column"]);
    $Query .= DataTables::sortBy($_POST["order"][2]["dir"]);
}
if (isset($_POST["order"][3]["column"])) {
    $Query .= " ," . DataTables::sortAllMembers($_POST["order"][3]["column"]);
    $Query .= DataTables::sortBy($_POST["order"][3]["dir"]);
}
if (isset($_POST["order"][4]["column"])) {
    $Query .= " ," . DataTables::sortAllMembers($_POST["order"][4]["column"]);
    $Query .= DataTables::sortBy($_POST["order"][4]["dir"]);
}
if (isset($_POST["order"][5]["column"])) {
    $Query .= " ," . DataTables::sortAllMembers($_POST["order"][5]["column"]);
    $Query .= DataTables::sortBy($_POST["order"][5]["dir"]);
}
if (isset($_POST["order"][6]["column"])) {
    $Query .= " ," . DataTables::sortAllMembers($_POST["order"][6]["column"]);
    $Query .= DataTables::sortBy($_POST["order"][6]["dir"]);
}
if (isset($_POST["order"][7]["column"])) {
    $Query .= " ," . DataTables::sortAllMembers($_POST["order"][7]["column"]);
    $Query .= DataTables::sortBy($_POST["order"][7]["dir"]);
}
if (isset($_POST["order"][8]["column"])) {
    $Query .= " ," . DataTables::sortAllMembers($_POST["order"][8]["column"]);
    $Query .= DataTables::sortBy($_POST["order"][8]["dir"]);
}
if (isset($_POST["order"][9]["column"])) {
    $Query .= " ," . DataTables::sortAllMembers($_POST["order"][9]["column"]);
    $Query .= DataTables::sortBy($_POST["order"][9]["dir"]);
}

$allResultsQuery = str_replace("SELECT *", "SELECT COUNT(*) as quantity", $Query);
$stmt = $DB->conn->prepare($allResultsQuery);
$stmt->execute($bindParams);

foreach ($stmt->get_result() as $row) {
    $rows["recordsFiltered"] = $row["quantity"];
}
$stmt->close();

$rows["recordsTotal"] = $DB->query("SELECT COUNT(*) AS quantity FROM `userrollen`");
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

    $name = $row["name"];
    $accountName = $playerNames[$row["playerid"]]["playerName"] ?? "Unbekannt";
    $accountName = "<input class='$name' name='accountName' value='$accountName'>";

    $lastLogin = "Kommt später";

    if ($row["level"] == 10) {
        $memberLevel = "<select class='$name' name='memberLevel'><option value='10'>SF</option><option value='1'>Member</option></select>";
    } else {
        $memberLevel = "<select class='$name' name='memberLevel'><option value='1'>Member</option><option value='10'>SF</option></select>";
    }

    if ($row["mods"] == 1) {
        $modLevel = "<select class='$name' name='modLevel'><option value='1'>Ja</option><option value='0'>Nein</option></select>";
    } else {
        $modLevel = "<select class='$name' name='modLevel'><option value='0'>Nein</option><option value='1'>Ja</option></select>";
    }

    if ($row["offkoord"] == 1) {
        $offLevel = "<select class='$name' name='offKoord'><option value='1'>Ja</option><option value='0'>Nein</option></select>";
    } else {
        $offLevel = "<select class='$name' name='offKoord'><option value='0'>Nein</option><option value='1'>Ja</option></select>";
    }

    if ($row["deffkoord"] == 1) {
        $defLevel = "<select class='$name' name='defKoord'><option value='1'>Ja</option><option value='0'>Nein</option></select>";
    } else {
        $defLevel = "<select class='$name' name='defKoord'><option value='0'>Nein</option><option value='1'>Ja</option></select>";
    }

    if ($row["reports"] == 1) {
        $reportLevel = "<select class='$name' name='allReports'><option value='1'>Ja</option><option value='0'>Nein</option></select>";
    } else {
        $reportLevel = "<select class='$name' name='allReports'><option value='0'>Nein</option><option value='1'>Ja</option></select>";
    }

    if ($row["attacks"] == 1) {
        $attackLevel = "<select class='$name' name='allAttacks'><option value='1'>Ja</option><option value='0'>Nein</option></select>";
    } else {
        $attackLevel = "<select class='$name' name='allAttacks'><option value='0'>Nein</option><option value='1'>Ja</option></select>";
    }

    if ($row["Version"] > -1) {
        $userLevel = "<select class='$name' name='activated'><option value='1'>Ja</option><option value='0'>Nein</option></select>";
    } else {
        $userLevel = "<select class='$name' name='activated'><option value='0'>Nein</option><option value='1'>Ja</option></select>";
    }

    $changePassword = "<input class='$name' name='changePassword'>";
    $rows["data"][] = array($name,$accountName,$lastLogin,$memberLevel,$modLevel,$offLevel,$defLevel,$reportLevel,$attackLevel,$userLevel,$changePassword);

}

$stmt->close();
echo json_encode($rows, JSON_UNESCAPED_UNICODE);

