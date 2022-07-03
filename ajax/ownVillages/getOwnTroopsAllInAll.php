<?php
session_start();
if(!isset($_SESSION["name"])) return;

require dirname(__DIR__, 2) . "/backend/classes/World_User.php";
require dirname(__DIR__, 2) . "/backend/classes/General.php";
require dirname(__DIR__, 2) . "/backend/classes/Database/UserVillages.php";

$World_User = new World_User($_SESSION["name"],$_SESSION["world"]);
if(!$World_User->isActivated()){
    General::destroySession();
    General::redirectHeader();
}
$Villages = new UserVillages($World_User->getWorldVersion(),$World_User->getPlayerID());

echo json_encode($Villages->getAllPlayerTroopsAllinAllAjax());
