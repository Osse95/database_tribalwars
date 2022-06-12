<?php
session_start();
if(!isset($_SESSION["name"])) return;

require dirname(__DIR__, 2) . "/backend/classes/World_User.php";
require dirname(__DIR__, 2) . "/backend/classes/General.php";
require dirname(__DIR__, 2) . "/backend/classes/Tribe.php";
require dirname(__DIR__, 2) . "/backend/classes/Player.php";

$World_User = new World_User($_SESSION["name"],$_SESSION["world"]);
if(!$World_User->isActivated()){
    General::destroySession();
    General::redirectHeader();
}
$Player = new Player($World_User->getWorld(),$World_User->getPlayerID());
$Tribe = new Tribe($World_User->getWorld(),$World_User->getTribeID());
$Return["points"] = [];
$Return["bashis"] = [];
$Return["pointsDates"] = [];
$Return["bashisDates"] = [];
$Return["tribePoints"] = [];
$Return["tribeBashis"] = [];
$Return["tribePointsDates"] = [];
$Return["tribeBashisDates"] = [];
if($Player->exists){
    foreach($Player->getPoints(14) AS $Point){
        $Return["points"][] = $Point["punkte"];
        $Return["pointsDates"][] = $Point["date"];
    };
    foreach($Player->getAllBashis(14) AS $Bash){
        $Return["bashis"][] = $Bash["kills"];
        $Return["bashisDates"][] = $Bash["date"];
    };
}
if($Tribe->exists){
    foreach($Tribe->getPoints(14) AS $Point){
        $Return["tribePoints"][] = $Point["punkte"];
        $Return["tribePointsDates"][] = $Point["date"];
    };
    foreach($Tribe->getAllBashis(14) AS $Bash){
        $Return["tribeBashis"][] = $Bash["kills"];
        $Return["tribeBashisDates"][] = $Bash["date"];
    };
}
echo json_encode($Return);