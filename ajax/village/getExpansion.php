<?php
session_start();
if(!isset($_SESSION["name"])) return;
if(!isset($_POST["id"])) return;

require dirname(__DIR__, 2) . "/backend/classes/World_User.php";
require dirname(__DIR__, 2) . "/backend/classes/General.php";
require dirname(__DIR__, 2) . "/backend/classes/Helper/VillageHelper.php";

$World_User = new World_User($_SESSION["name"],$_SESSION["world"]);
if(!$World_User->isActivated()){
    General::destroySession();
    General::redirectHeader();
}
$points = $_POST["id"]??0;
$Return = VillageHelper::getExpansions($points);
echo json_encode($Return);