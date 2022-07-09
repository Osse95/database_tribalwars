<?php
session_start();
if(!isset($_SESSION["name"])) return;
if(!isset($_POST["id"])) return;

require dirname(__DIR__, 2) . "/backend/classes/World_User.php";
require dirname(__DIR__, 2) . "/backend/classes/General.php";
require dirname(__DIR__, 2) . "/backend/classes/Database/DatabaseGeneral.php";
require dirname(__DIR__, 2) . "/backend/classes/Database/DatabasePlayer.php";

$World_User = new World_User($_SESSION["name"],$_SESSION["world"]);
if(!$World_User->isActivated()){
    General::destroySession();
    General::redirectHeader();
}

$DatabaseGeneral = new DatabaseGeneral($World_User->getWorldVersion());
$DatabasePlayerPresent = $DatabaseGeneral->checkDatabasePlayerPresent($_POST["id"]);

$Player = new DatabasePlayer($World_User->getWorldVersion(),$_POST["id"]);

$Return = false;

if($DatabasePlayerPresent){
    if($World_User->isSF() || $World_User->getPlayerID() == $_POST["id"]){
        if($Player->exists){
            $Return["PlayerData"] = $Player->playerArray;
            $Return["attackSizes"] =  $Player->getAllAttackQuantitys();
            $Return["possibleOffensiveVillages"] = $Player->getPossibleOffensiveVillages();
            $Return["lastSendTimes"] = $Player->getLastSendTimes();
        }
    }
}else{
    if($Player->exists){
        $Return["PlayerData"] = $Player->playerArray;
        $Return["attackSizes"] =  $Player->getAllAttackQuantitys();
        $Return["possibleOffensiveVillages"] = $Player->getPossibleOffensiveVillages();
        $Return["lastSendTimes"] = $Player->getLastSendTimes();
    }
}

echo json_encode($Return);