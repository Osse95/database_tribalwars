<?php
session_start();
if(!isset($_SESSION["name"])) return;
if(!isset($_POST["id"])) return;

require dirname(__DIR__, 2) . "/backend/classes/World_User.php";
require dirname(__DIR__, 2) . "/backend/classes/General.php";
require dirname(__DIR__, 2) . "/backend/classes/Village.php";

$World_User = new World_User($_SESSION["name"],$_SESSION["world"]);
if(!$World_User->isActivated()){
    General::destroySession();
    General::redirectHeader();
}
$Village = new Village($World_User->getWorld(),$_POST["id"]);
$Return = [];
if($Village->exists){
    $Return["villageInfo"] = $Village->villageArray;
    $Return["villageOwner"] = $Village->getOwner();
    $Return["villageTribe"] = $Village->getTribe();
    $Return["lastConquer"] =$Village->getLastConquer();
    $Return["conquerQuantity"] = $Village->getQuantityConquers();
}
echo json_encode($Return);