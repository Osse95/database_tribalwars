<?php
require_once dirname(__DIR__,2)."/backend/classes/Inno.php";
$Return = Inno::getActiveWorlds();
echo json_encode($Return,true);