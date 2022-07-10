<?php
session_start();
if(!isset($_SESSION["name"])) return;
if(!isset($_POST["id"])) return;

require dirname(__DIR__, 2) . "/backend/classes/World_User.php";
require dirname(__DIR__, 2) . "/backend/classes/General.php";
require dirname(__DIR__, 2) . "/backend/classes/Village.php";
require dirname(__DIR__, 2) . "/backend/classes/Database/DatabaseVillage.php";

$World_User = new World_User($_SESSION["name"],$_SESSION["world"]);
if(!$World_User->isActivated()){
    General::destroySession();
    General::redirectHeader();
}
$Return = [];

if($World_User->seeAllReports()){
    $Village = new Village($World_User->getWorld(),$_POST["id"]);
    if($Village->exists){
        $villageID = $Village->villageArray["ID"];
        $Return["coordX"] = $Village->villageArray["coordX"];
        $Return["coordY"] = $Village->villageArray["coordY"];
        $Village = new DatabaseVillage($World_User->getWorldVersion(),$villageID);
        $Return["quantityReports"] = $Village->getQuantityReports();
        $Return["type"] = $Village->getVillageType();
    }
}

echo json_encode($Return);