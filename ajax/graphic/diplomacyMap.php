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

if (!graphicControl::checkDiplomacyMap($World_User->getWorldVersion())) {
    $worldMap = new worldMap($World_User->getWorldVersion());
    $worldMap->selectMapType("diplomacy");
    $worldMap->createMap();
    $worldMap->safeImage("diplomacy");
}
graphicControl::getDiplomacyMap($World_User->getWorldVersion());