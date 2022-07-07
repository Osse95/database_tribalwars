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

if (!graphicControl::checkUserMap($World_User->getWorldVersion(),$World_User->getPlayerID())) {
    $worldMap = new worldMap($World_User->getWorldVersion(),$World_User->getPlayerID());
    $worldMap->selectMapType("userMap");
    $worldMap->createMap();
    $worldMap->safeImage("userMap");
}
graphicControl::getUserMap($World_User->getWorldVersion(),$World_User->getPlayerID());