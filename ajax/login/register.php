<?php
session_start();
require_once dirname(__DIR__, 2) . "/backend/classes/User.php";
require_once dirname(__DIR__, 2) . "/backend/classes/World_User.php";
require_once dirname(__DIR__, 2) . "/backend/classes/Inno.php";
require_once dirname(__DIR__, 2) . "/backend/classes/Player.php";
if (isset($_SESSION["name"]) or !isset($_POST["name"]) or !isset($_POST["password"]) or !isset($_POST["world"]) or !isset($_POST["account"])) {
    return;
}
if (strlen($_POST["name"]) == 0) {
    $Return["result"] = false;
    $Return["msg"] = "Bitte einen Namen eingeben.";
    echo json_encode($Return, true);
    return;
}
if (strlen($_POST["password"]) == 0) {
    $Return["result"] = false;
    $Return["msg"] = "Bitte ein Password eingeben.";
    echo json_encode($Return, true);
    return;
}

if (!Inno::existWorld($_POST["world"])) {
    $Return["result"] = false;
    $Return["msg"] = "Welt wird nicht unterstützt.";
    echo json_encode($Return, true);
    return;
}

$User = new User($_POST["name"]);
$Player = new Player($_POST["world"], $_POST["account"]);
$World_User = new World_User($_POST["name"], $_POST["world"]);
if (!$Player->exists) {
    $Return["result"] = false;
    $Return["msg"] = "Spieler wurde auf der Welt nicht gefunden.";
    echo json_encode($Return, true);
    return;
}

$Return = [];
if ($User->exists) {
    if ($User->login($_POST["password"])) {
        if ($World_User->exists) {
            $Return["result"] = false;
            $Return["msg"] = "Bitte anderen Benutzernamen auswählen.";
        } else {
            if ($_POST["newDatabase"] == "false") {
                $World_User->createNormalUser($_POST["name"], $_POST["world"], $Player->playerArray["ID"], $Player->playerArray["TribeID"]);
                $Return["result"] = false;
                $Return["msg"] = "Du hast dich erfolgreich registriert.";
            }else{
                $World_User->createSFUser($_POST["name"], $_POST["world"], $Player->playerArray["ID"], $Player->playerArray["TribeID"]);
                $_SESSION["name"] = $_POST["name"];
                $_SESSION["world"] = $_POST["world"];
                $Return["result"] = true;
            }
        }
    } else {
        $Return["result"] = false;
        $Return["msg"] = "Bitte anderen Benutzernamen auswählen.";
    }
} else {
    $User->registerUser($_POST["name"], $_POST["password"]);
    if ($_POST["newDatabase"] == "false") {
        $World_User->createNormalUser($_POST["name"], $_POST["world"], $Player->playerArray["ID"], $Player->playerArray["TribeID"]);
        $Return["result"] = false;
        $Return["msg"] = "Du hast dich erfolgreich registriert.";
    }else{
        $World_User->createSFUser($_POST["name"], $_POST["world"], $Player->playerArray["ID"], $Player->playerArray["TribeID"]);
        $_SESSION["name"] = $_POST["name"];
        $_SESSION["world"] = $_POST["world"];
        $Return["result"] = true;
    }
}
echo json_encode($Return, true);