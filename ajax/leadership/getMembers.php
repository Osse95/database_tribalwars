<?php
session_start();

if (!isset($_SESSION["name"])) return;

require dirname(__DIR__, 2) . "/backend/classes/World_User.php";
require dirname(__DIR__, 2) . "/backend/classes/General.php";
require dirname(__DIR__, 2) . "/backend/classes/Database/Leadership.php";
$World_User = new World_User($_SESSION["name"], $_SESSION["world"]);

if (!$World_User->isSF()) {
    General::redirectHeader();
}

$leadership = new Leadership($World_User->getWorld(),$World_User->getWorldVersion(),$World_User->getVersion());
echo json_encode($leadership->getMemberNames());