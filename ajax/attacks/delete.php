<?php
session_start();
if (!isset($_SESSION["name"])) return;

require dirname(__DIR__, 2) . "/backend/classes/World_User.php";
require dirname(__DIR__, 2) . "/backend/classes/General.php";
require dirname(__DIR__, 2) . "/backend/classes/Database/Attacks.php";

$World_User = new World_User($_SESSION["name"], $_SESSION["world"]);
if (!$World_User->isActivated()) {
    General::destroySession();
    General::redirectHeader();
}
if (!isset($_POST["deleteIDS"])) {
    General::redirectHeader();
}

$deleteIDS = "";
if ($World_User->isSF() || $World_User->isMod()) {
    for($i=0;$i<count($_POST["deleteIDS"]);$i++){
        $ID = $_POST["deleteIDS"][$i];
        if($i == 0){
            $deleteIDS .= " WHERE ID = '$ID'";
        }else{
            $deleteIDS .= " OR ID = '$ID'";
        }
    }
}else{
    for($i=0;$i<count($_POST["deleteIDS"]);$i++){
        $ID = $_POST["deleteIDS"][$i];
        $playerID = $World_User->getPlayerID();
        if($i == 0){
            $deleteIDS .= " WHERE ID = '$ID' AND (attackerid = '$playerID' OR defenderid = '$playerID')";
        }else{
            $deleteIDS .= " OR ID = '$ID' AND (attackerid = '$playerID' OR defenderid = '$playerID')";
        }
    }
}

if(strlen($deleteIDS) > 0){
    $World_User->connectTo($World_User->getWorldVersion());
    $World_User->query("DELETE FROM `sos` $deleteIDS");
    $return["return"] = true;
}else{
    $return["return"] = false;
}
echo json_encode($return);