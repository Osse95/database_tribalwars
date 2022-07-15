<?php
session_start();
if(isset($_SESSION["world"])){
    $_POST["world"] = $_SESSION["world"];
}
if(!isset($_POST["world"])){
    return;
}
require_once dirname(__DIR__,2)."/backend/classes/Players.php";
require_once dirname(__DIR__,2)."/backend/classes/Inno.php";

if(!Inno::existWorld($_POST["world"])){
    $Return["result"] = false;
    $Return["msg"] = "Bitte eine aktive Welt auswählen.";

}else{
    $Return["result"] = true;
    $userNames = new Players($_POST["world"]);
    $userNames = $userNames->getAllPlayerNames();
    $Return["userNames"] = $userNames;
}
echo json_encode($Return,true);