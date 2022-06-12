<?php
session_start();
if(!isset($_SESSION["name"])) return;

require_once dirname(__DIR__,2)."/backend/classes/Inno.php";

$serverURL = Inno::getServerUrl($_SESSION["world"]);
echo file_get_contents("$serverURL/guest.php?screen=info_ally&id={$_POST["id"]}");