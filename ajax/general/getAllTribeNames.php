<?php
session_start();
if(isset($_SESSION["world"])){
    $_POST["world"] = $_SESSION["world"];
}
if(!isset($_POST["world"])){
    return;
}
require_once dirname(__DIR__,2)."/backend/classes/Tribes.php";
require_once dirname(__DIR__,2)."/backend/classes/Inno.php";

if(!Inno::existWorld($_POST["world"])){
    $Return["result"] = false;
    $Return["msg"] = "Bitte eine aktive Welt auswählen.";

}else{
    $Return["result"] = true;
    $tribeNames = new Tribes($_POST["world"]);
    $tribeNames = $tribeNames->getAllTribeNames();
    $Return["tribeNames"] = $tribeNames;
}
echo json_encode($Return,true);