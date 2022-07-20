<?php
session_start();
if(!isset($_SESSION["name"])) return;
if(!isset($_POST["improvement"])) return;

require dirname(__DIR__, 2) . "/backend/classes/World_User.php";
require dirname(__DIR__, 2) . "/backend/classes/General.php";

$World_User = new World_User($_SESSION["name"],$_SESSION["world"]);
if(!$World_User->isActivated()){
    General::destroySession();
    General::redirectHeader();
}

$improvement  = $_POST["improvement"]??"";
if(strlen($improvement) > 30){
    $World_User->addImprovement($improvement);
    echo json_encode($World_User->getName());
}else{
    echo json_encode(false);
}