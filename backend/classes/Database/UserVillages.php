<?php

require_once dirname(__DIR__, 3) . "/backend/classes/DB.php";
require_once dirname(__DIR__, 3) . "/backend/classes/Inno.php";

class UserVillages extends DB
{
    private string $playerID;
    private string $worldName;

    function __construct($world, $playerID = 0)
    {
        parent::__construct($world);
        $this->playerID = $playerID;
        $this->worldName = $world;
    }

    function getAllPlayerTroopsAjax()
    {
        $return = array(
            "village" => [],
            "own" => [],
            "inVillage" => [],
            "outwards" => [],
            "all" => []);
        $playerID = $this->playerID;
        $query = $this->query("SELECT * FROM `troups` WHERE playerid = '$playerID'");
        foreach ($query as $village) {
            $villageURL = "<a href='". Inno::getServerUrl($this->worldName);
            $villageURL .= "game.php?village={$village["coordsid"]}&screen=overview" . "' target='_blank'>";
            $villageURL .= $village["dorfname"] . " " . $village["coords"] . " " . "K".$village["kontinent"] . "</a>";
            $return["village"][] = $villageURL;

            $return["own"][] = [
                $village["espeer"],
                $village["eschwert"],
                $village["eaxt"],
                $village["ebogen"],
                $village["espaeher"],
                $village["elkav"],
                $village["eberittene"],
                $village["eskav"],
                $village["eramme"],
                $village["ekata"],
                $village["epala"],
                $village["eag"]];
            $return["inVillage"][] = [
                $village["dspeer"],
                $village["dschwert"],
                $village["daxt"],
                $village["dbogen"],
                $village["dspaeher"],
                $village["dlkav"],
                $village["dberittene"],
                $village["dskav"],
                $village["dramme"],
                $village["dkata"],
                $village["dpala"],
                $village["dag"]];
            $return["outwards"][] = [
                $village["aspeer"],
                $village["aschwert"],
                $village["aaxt"],
                $village["abogen"],
                $village["aspaeher"],
                $village["alkav"],
                $village["aberittene"],
                $village["askav"],
                $village["aramme"],
                $village["akata"],
                $village["apala"],
                $village["aag"]];
            $return["all"][] = [
                $village["ispeer"],
                $village["ischwert"],
                $village["iaxt"],
                $village["ibogen"],
                $village["ispaeher"],
                $village["ilkav"],
                $village["iberittene"],
                $village["iskav"],
                $village["iramme"],
                $village["ikata"],
                $village["ipala"],
                $village["iag"]];
        }

        return $return;
    }

}