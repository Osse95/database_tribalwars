<?php
session_start();
if (!isset($_SESSION["name"])) return;
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require dirname(__DIR__, 2) . "/backend/classes/World_User.php";
require dirname(__DIR__, 2) . "/backend/classes/General.php";
require dirname(__DIR__, 2) . "/backend/classes/Database/Attacks.php";

$World_User = new World_User($_SESSION["name"], $_SESSION["world"]);
if (!$World_User->isActivated()) {
    General::destroySession();
    General::redirectHeader();
}
$Attacks = new Attacks($World_User->getWorldVersion());

$return = array(
    "offs" => $Attacks->getAllOffCoords(),
    "fakes" => $Attacks->getAllFakeCoords()
);

echo json_encode($return);