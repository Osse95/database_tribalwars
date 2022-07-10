<?php
session_start();
if(!isset($_SESSION["name"])) return;
if(!isset($_POST["id"])) return;

require dirname(__DIR__, 2) . "/backend/classes/World_User.php";
require dirname(__DIR__, 2) . "/backend/classes/General.php";
require dirname(__DIR__, 2) . "/backend/classes/Tribe.php";

$World_User = new World_User($_SESSION["name"],$_SESSION["world"]);
if(!$World_User->isActivated()){
    General::destroySession();
    General::redirectHeader();
}
$Tribe = new Tribe($World_User->getWorld(),$_POST["id"]);

$Return["points"] = [];
$Return["pointsDates"] = [];
$Return["rank"] = [];
$Return["rankDates"] = [];
$Return["villages"] = [];
$Return["villagesDates"] = [];


$Return["allBashis"] = [];
$Return["allBashisDates"] = [];
$Return["attBashis"] = [];
$Return["attBashisDates"] = [];
$Return["defBashis"] = [];
$Return["defBashisDates"] = [];
$Return["supBashis"] = [];
$Return["supBashisDates"] = [];


if($Tribe->exists){
    foreach($Tribe->getPoints() AS $Point){
        $Return["points"][] = $Point["punkte"];
        $Return["pointsDates"][] = $Point["date"];
    };
    foreach($Tribe->getRank() AS $Point){
        $Return["rank"][] = $Point["rang"];
        $Return["rankDates"][] = $Point["date"];
    };
    foreach($Tribe->getVillages() AS $Point){
        $Return["villages"][] = $Point["dorfanzahl"];
        $Return["villagesDates"][] = $Point["date"];
    };
    foreach($Tribe->getAllBashis() AS $Bash){
        $Return["allBashis"][] = $Bash["kills"];
        $Return["allBashisDates"][] = $Bash["date"];
    };
    foreach($Tribe->getAttBashis() AS $Bash){
        $Return["attBashis"][] = $Bash["kills"];
        $Return["attBashisDates"][] = $Bash["date"];
    };
    foreach($Tribe->getDefBashis() AS $Bash){
        $Return["defBashis"][] = $Bash["kills"];
        $Return["defBashisDates"][] = $Bash["date"];
    };
}
echo json_encode($Return);