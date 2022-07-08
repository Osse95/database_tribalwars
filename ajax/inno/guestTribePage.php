<?php
session_start();
if(!isset($_SESSION["name"])) return;

require_once dirname(__DIR__,2)."/backend/classes/Inno.php";
require_once dirname(__DIR__,2)."/backend/classes/Tribe.php";

$Tribe = new Tribe($_SESSION["world"],$_POST["id"]);
if($Tribe->exists){
    $serverURL = Inno::getServerUrl($_SESSION["world"]);
    echo file_get_contents("$serverURL/guest.php?screen=info_ally&id={$Tribe->getTribeID()}");
}
