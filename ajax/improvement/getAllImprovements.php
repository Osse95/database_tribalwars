<?php
session_start();

if (!isset($_SESSION["name"])) return;
require dirname(__DIR__, 2) . "/backend/classes/World_User.php";
require dirname(__DIR__, 2) . "/backend/classes/Database/Admin.php";
require dirname(__DIR__, 2) . "/backend/classes/General.php";
$World_User = new World_User($_SESSION["name"], $_SESSION["world"]);

if (!$World_User->isActivated()) {
    General::redirectHeader();
}

$Admin = new Admin();
echo json_encode($Admin->getImprovements());
