<?php
session_start();

if (!isset($_SESSION["name"])) return;
require dirname(__DIR__, 2) . "/backend/classes/DB.php";
require dirname(__DIR__, 2) . "/backend/classes/World_User.php";
require dirname(__DIR__, 2) . "/backend/classes/Database/Admin.php";
require dirname(__DIR__, 2) . "/backend/classes/General.php";
$World_User = new World_User($_SESSION["name"], $_SESSION["world"]);

if (!$World_User->isActivated() || !$World_User->isAdmin()) {
    General::redirectHeader();
}

$Admin = new Admin($World_User->getWorld(),$World_User->getVersion());
$Return = $Admin->getMaxVersion();

echo json_encode($Return);
