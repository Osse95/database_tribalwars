<?php
session_start();

if (!isset($_SESSION["name"]) or !isset($_POST)) return;

require dirname(__DIR__, 2) . "/backend/classes/World_User.php";
require dirname(__DIR__, 2) . "/backend/classes/World.php";
require dirname(__DIR__, 2) . "/backend/classes/General.php";
require dirname(__DIR__, 2) . "/backend/classes/Database/Report.php";

$World_User = new World_User($_SESSION["name"], $_SESSION["world"]);

if (!$World_User->isActivated()) {
    General::redirectHeader();
}

$World = new World($World_User->getWorld());

if($World->isArcherAvailable()){
    $return["archer"] = true;
}else{
    $return["archer"] = false;
}

if($World->isKnightAvailable()){
    $return["knight"] = true;
}else{
    $return["knight"] = false;
}

if($World->isChurchAvailable()){
    $return["church"] = true;
}else{
    $return["church"] = false;
}
$reportID = $_POST["id"]??0;
$Report =  new Report($World_User->getWorldVersion(),$reportID);

if($Report->isReportAvailable()){
    $return["reportAvailable"] = true;
}else{
    $return["reportAvailable"] = false;
    echo json_encode($return);
    die();
}

$return["subject"] = $Report->getSubject();
$return["fighttime"] = date("h:i:s d.m.Y",$Report->getFighttime());
$return["luck"] = $Report->getAttackerLuck();
$return["moral"] = $Report->getAttackerMoral();
$return["attackerInfos"] = $Report->getAttackerInfo();
$return["attackerUnits"] = $Report->getAttackerUnits();
$return["attackerUnitsLoss"] = $Report->getAttackerUnitsLoss();
$return["defenderInfos"] = $Report->getDefenderInfo();
$return["defenderUnits"] = $Report->getDefenderUnits();
$return["defenderUnitsLoss"] = $Report->getDefenderUnitsLoss();
$return["defenderUnitsOutside"] = $Report->getDefenderUnitsOutside();
$return["buildings"] = $Report->getDefenderBuildings();
$return["damageRam"] = $Report->getRamDamage();
$return["damageCata"] = $Report->getCataDamage();
$return["moodDeduction"] = $Report->getMoodDeduction();
echo json_encode($return);