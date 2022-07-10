<?php
session_start();
if (!isset($_SESSION["name"])) return;

require dirname(__DIR__, 2) . "/backend/classes/World_User.php";
require dirname(__DIR__, 2) . "/backend/classes/General.php";
require dirname(__DIR__, 2) . "/backend/classes/Graphic/worldMap.php";
require_once dirname(__DIR__, 2) . "/backend/classes/Graphic/graphicControl.php";

$World_User = new World_User($_SESSION["name"], $_SESSION["world"]);
if (!$World_User->isActivated()) {
    General::destroySession();
    General::redirectHeader();
}

General::imageHeader();

$tribeID = $_GET["id"]??"-1";
if (!graphicControl::checktribeMap($World_User->getWorldVersion(),$tribeID)) {
    $worldMap = new worldMap($World_User->getWorldVersion(),$tribeID);
    $worldMap->selectMapType("tribeMap");
    $worldMap->createMap();
    $worldMap->safeImage("tribeMap");
}
graphicControl::gettribeMap($World_User->getWorldVersion(),$tribeID);