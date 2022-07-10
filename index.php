<?php
session_start();

require_once __DIR__ . "/backend/classes/User.php";
require_once __DIR__ . "/backend/classes/World_User.php";
require_once __DIR__ . "/backend/classes/General.php";
require_once __DIR__ . "/backend/classes/Players.php";
error_reporting(E_ALL);
ini_set('display_errors', 'On');
if(!isset($_SESSION["name"]) && isset($_COOKIE["cookie"])){
    $World_User = new World_User();
    $Cookie = $World_User->loadCookie($_COOKIE["cookie"]);

    if($Cookie){
        $_SESSION["name"] = $Cookie["name"];
        $_SESSION["world"] = $Cookie["world"];
    }
}

if (!isset($_SESSION["name"])) {
    require __DIR__ . "/backend/pages/login/login.html";
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
    }
    if(!str_contains($_SERVER['REQUEST_URI'],"preview")){
        require "./backend/pages/header/header.php";
    }else{
        require "./backend/pages/header/headerPreview.php";
    }
    switch ($side) {
        case("showReports"):
            require __DIR__ . "/backend/pages/reports/showReports.php";
            break;
        case("showUTReports"):
            require __DIR__ . "/backend/pages/reports/showSupportReports.php";
            break;
        case("showReport"):
            require __DIR__ . "/backend/pages/previewReports/showReport.html";
            break;
        case("insert"):
            require __DIR__ . "/backend/pages/insert/insert.html";
            break;
        case("ranking"):
            require __DIR__ . "/backend/pages/ranking/ranking.html";
            break;
        case("dbRanking"):
            require __DIR__ . "/backend/pages/ranking/dbRanking.html";
            break;
        case("evaluation"):
            require __DIR__ . "/backend/pages/ranking/evaluation.html";
            break;
        case("villages"):
            require __DIR__ . "/backend/pages/villages/villages.html";
            break;
        case("allAttacks"):
            require __DIR__ . "/backend/pages/attacks/allAttacks.php";
            break;
        case("ownAttacks"):
            require __DIR__ . "/backend/pages/attacks/ownAttacks.php";
            break;
        case("retimes"):
            require __DIR__ . "/backend/pages/attacks/retimes.html";
            break;
        case("heatMap"):
            require __DIR__ . "/backend/pages/attacks/heatMap.html";
            break;
        case("sourceMap"):
            require __DIR__ . "/backend/pages/attacks/sourceMap.html";
            break;
        case("getAttacks"):
            require __DIR__ . "/backend/pages/attacks/getAttacks.php";
            break;
        case("topTen"):
            require __DIR__ . "/backend/pages/graphics/topTen.html";
            break;
        case("playerInfo"):
            require __DIR__ . "/backend/pages/search/playerInfo.html";
            break;
        case("tribeInfo"):
            require __DIR__ . "/backend/pages/search/tribeInfo.html";
            break;
        default:
            require __DIR__ . "/backend/pages/overview/overview.html";
    }

}
