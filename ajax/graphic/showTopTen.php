<?php
session_start();
require_once dirname(__DIR__, 2) . "/backend/classes/General.php";
require_once dirname(__DIR__, 2) . "/backend/classes/Inno.php";
require_once dirname(__DIR__, 2) . "/backend/classes/Graphic/worldMap.php";
require_once dirname(__DIR__, 2) . "/backend/classes/Graphic/graphicControl.php";

if(isset($_SESSION["world"])){
    $_GET["world"] = $_SESSION["world"];
}

if (!isset($_GET["world"])) return;
if (!Inno::existWorld($_GET["world"])) return;

General::imageHeader();

if (!graphicControl::checkTopTenMap($_GET["world"])) {
    $worldMap = new worldMap($_GET["world"]);
    $worldMap->selectMapType("topTenMap");
    $worldMap->createMap();
    $worldMap->safeImage("topTenMap");
}
graphicControl::getTopTenMap($_GET["world"]);
