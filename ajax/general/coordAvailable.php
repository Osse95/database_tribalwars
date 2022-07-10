<?php
session_start();
if(!isset($_SESSION["name"])) return;
if(!isset($_POST["id"])) return;

require_once dirname(__DIR__,2)."/backend/classes/Village.php";

$Village = new Village($_SESSION["world"],$_POST["id"]);

echo json_encode($Village->exists);