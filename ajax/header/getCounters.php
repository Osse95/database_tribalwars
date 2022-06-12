<?php
session_start();
if(!isset($_SESSION["name"])) return;

require dirname(__DIR__, 2) . "/backend/classes/World_User.php";
require dirname(__DIR__, 2) . "/backend/classes/General.php";
require dirname(__DIR__, 2) . "/backend/classes/Database/Attacks.php";
require dirname(__DIR__, 2) . "/backend/classes/Database/Reports.php";
require dirname(__DIR__, 2) . "/backend/classes/Database/SupportReports.php";

$World_User = new World_User($_SESSION["name"],$_SESSION["world"]);
if(!$World_User->isActivated()){
    General::destroySession();
    General::redirectHeader();
}

$Attacks = new Attacks($World_User->getWorldVersion());
$Return["quantityAttacksAll"] = $Attacks->getAllAttackQuantity();
$Return["quantityAttacksOwn"] = $Attacks->getAllAttackQuantityUser($World_User->getPlayerID());
$Return["quantityDailys"] = $Attacks->getAllDailyAttacksQuantity();

$Reports = new Reports($World_User->getWorldVersion());
$Return["quantityReportsAll"] = $Reports->getAllReportsQuantity();

$SupportReports = new SupportReports($World_User->getWorldVersion());
$Return["quantitySupportReportsAll"] = $SupportReports->getAllReportsQuantity();

echo json_encode($Return);
