<?php
session_start();


error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once dirname(__DIR__,2)."/backend/classes/User.php";
require_once dirname(__DIR__,2)."/backend/classes/World_User.php";

if(isset($_SESSION["name"]) OR !isset($_POST["name"]) OR !isset($_POST["password"]) OR !isset($_POST["world"])){
    return;
}

if(strlen($_POST["name"]) == 0){
    $Return["result"] = false;
    $Return["msg"] = "Bitte einen Namen eingeben.";
    echo json_encode($Return,true);
    return;
}

if(strlen($_POST["password"]) == 0){
    $Return["result"] = false;
    $Return["msg"] = "Bitte ein Password eingeben.";
    echo json_encode($Return,true);
    return;
}

$User = new User($_POST["name"]);
$Return = [];
if($User->exists){
    if($User->login($_POST["password"])){
        $World_User = new World_User($_POST["name"],$_POST["world"]);
        if($World_User->exists){
            if($World_User->isActivated()){
                $Return["result"] = true;
                $_SESSION["name"] = $_POST["name"];
                $_SESSION["world"] = $_POST["world"];
                if($_POST["stayLogged"]== "true"){
                    setcookie('cookie', $World_User->createCookie(), time() + (3600 * 96));
                }
            }else{
                $Return["result"] = false;
                $Return["msg"] = "Lass dich bitte von der SF aktivieren.";
            }
        }else{
            $Return["result"] = false;
            $Return["msg"] = "Benutzer auf der Welt nicht gefunden.";
        }
    }else{
        $Return["result"] = false;
        $Return["msg"] = "Benutzername oder Passwort stimmen nicht.";
    }

}else{
    $Return["result"] = false;
    $Return["msg"] = "Benutzername oder Passwort stimmen nicht.";
}
echo json_encode($Return,true);