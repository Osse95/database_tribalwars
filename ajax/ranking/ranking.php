<?php
session_start();
if(!isset($_SESSION["name"])) return;

require dirname(__DIR__, 2) . "/backend/classes/World_User.php";
require dirname(__DIR__, 2) . "/backend/classes/General.php";
require dirname(__DIR__, 2) . "/backend/classes/Tribes.php";
require dirname(__DIR__, 2) . "/backend/classes/Players.php";

$World_User = new World_User($_SESSION["name"],$_SESSION["world"]);
if(!$World_User->isActivated()){
    General::destroySession();
    General::redirectHeader();
}

$Players = new Players($World_User->getWorld());
$Return["playerRanking"] = $Players->getLimitPlayersData(10);

$Tribes = new Tribes($World_User->getWorld());
$Return["tribeRanking"] = $Tribes->getLimitTribeData(10);

echo json_encode($Return);
