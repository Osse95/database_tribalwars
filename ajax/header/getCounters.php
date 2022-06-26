<?php
session_start();
if(!isset($_SESSION["name"])) return;
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once dirname(__DIR__, 2) . "/backend/classes/World_User.php";
require_once dirname(__DIR__, 2) . "/backend/classes/General.php";
require_once dirname(__DIR__, 2) . "/backend/classes/Database/Attacks.php";
require_once dirname(__DIR__, 2) . "/backend/classes/Database/Reports.php";
require_once dirname(__DIR__, 2) . "/backend/classes/Database/SupportReports.php";

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
