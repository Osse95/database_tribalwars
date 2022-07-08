<?php
session_start();
if(!isset($_SESSION["name"])) return;
if(!isset($_POST["id"])) return;

require_once dirname(__DIR__,2)."/backend/classes/Inno.php";
require_once dirname(__DIR__,2)."/backend/classes/Player.php";

$Player = new Player($_SESSION["world"],$_POST["id"]);

if($Player->exists){
    $serverURL = Inno::getServerUrl($_SESSION["world"]);
    echo file_get_contents("$serverURL/guest.php?screen=info_player&id={$Player->getPlayerID()}");
}
