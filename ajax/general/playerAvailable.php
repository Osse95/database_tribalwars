<?php
session_start();
if(!isset($_SESSION["name"])) return;
if(!isset($_POST["id"])) return;
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once dirname(__DIR__,2)."/backend/classes/Player.php";

$Player = new Player($_SESSION["world"],$_POST["id"]);

echo json_encode($Player->exists);