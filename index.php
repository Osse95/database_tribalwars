<?php
session_start();

require_once __DIR__ . "/backend/classes/User.php";
require_once __DIR__ . "/backend/classes/World_User.php";
require_once __DIR__ . "/backend/classes/General.php";
require_once __DIR__ . "/backend/classes/Players.php";

if (!isset($_SESSION["name"])) {
    require __DIR__ . "/backend/pages/login/login.php";
} else {
    $User = new User($_SESSION["name"]);
    if (!$User->exists) {
        General::destroySession();
        General::redirectHeader();
        return;
    } elseif (!$User->isActivated()) {
        General::destroySession();
        General::redirectHeader();
        return;
    }

    $World_User = new World_User($_SESSION["name"], $_SESSION["world"]);
    if (!$User->exists) {
        General::destroySession();
        General::redirectHeader();
        return;
    } elseif (!$World_User->isActivated()) {
        General::destroySession();
        General::redirectHeader();
        return;
    }

    $side = explode("/", $_SERVER['REQUEST_URI']);
    $side = $side[1] ?? "";
    $side = explode("?", $side);
    $side = $side[0];

    if($side == "logout"){
            General::destroySession();
            General::redirectHeader();
            die();
    }
    require "./backend/pages/header/header.php";
    switch ($side) {
        case("showReports"):
            require __DIR__ . "/backend/pages/reports/showReports.php";
            break;
        case("showUTReports"):
            require __DIR__ . "/backend/pages/reports/showSupportReports.php";
            break;
        case("insert"):
            require __DIR__ . "/backend/pages/insert/insert.php";
            break;
        case("ranking"):
            require __DIR__ . "/backend/pages/ranking/ranking.php";
            break;
        case("dbRanking"):
            require __DIR__ . "/backend/pages/ranking/dbRanking.php";
            break;
        default:
            require __DIR__ . "/backend/pages/overview/overview.php";
    }

}
