<?php
session_start();
if(!isset($_SESSION["name"])) return;

require dirname(__DIR__, 2) . "/backend/classes/World_User.php";
require dirname(__DIR__, 2) . "/backend/classes/General.php";
require dirname(__DIR__, 2) . "/backend/classes/Villages.php";
require dirname(__DIR__, 2) . "/backend/classes/Player.php";
require dirname(__DIR__, 2) . "/backend/classes/Tribe.php";

$World_User = new World_User($_SESSION["name"],$_SESSION["world"]);
if(!$World_User->isActivated()){
    General::destroySession();
    General::redirectHeader();
}

$Return["data"] = [];

$Villages = new Villages($World_User->getWorld());

$playerID = $_POST["playerID"]??"";

$onlyOne = true;
if(strlen($playerID) > 0){
    $player = new Player($World_User->getWorld(),$playerID);
    if($player->exists){
        $Return["data"] = $Villages->getAllVillagesFromPlayerAjax($player->getPlayerID());
        $onlyOne = false;
    }
}

$tribeID = $_POST["tribeID"]??"";
if(strlen($tribeID) > 0 && $onlyOne){
    $tribe = new Tribe($World_User->getWorld(),$tribeID);
    if($tribe->exists){
        $Return["data"] = $Villages->getAllVillagesFromTribeAjax($tribe->getTribeID());
    }
}


echo json_encode($Return);
