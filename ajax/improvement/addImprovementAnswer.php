<?php
session_start();
if (!isset($_SESSION["name"])) return;
if (!isset($_POST["answer"])) return;

require dirname(__DIR__, 2) . "/backend/classes/World_User.php";
require dirname(__DIR__, 2) . "/backend/classes/Database/Admin.php";
require dirname(__DIR__, 2) . "/backend/classes/General.php";

$World_User = new World_User($_SESSION["name"], $_SESSION["world"]);
if (!$World_User->isAdmin()) {
    General::redirectHeader();
}

$Admin = new Admin();
$Admin->addImprovementAnswer($_POST["answer"] ?? "", $_POST["user"] ?? "", $_POST["improvement"] ?? "");