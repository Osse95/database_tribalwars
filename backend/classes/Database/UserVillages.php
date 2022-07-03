<?php

use JetBrains\PhpStorm\ArrayShape;

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

    #[ArrayShape(["village" => "array", "own" => "array", "inVillage" => "array", "outwards" => "array", "all" => "array"])] function getAllPlayerTroopsAjax(): array
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
            $villageURL = "<a href='" . Inno::getServerUrl($this->worldName);
            $villageURL .= "game.php?village={$village["coordsid"]}&screen=overview" . "' target='_blank'>";
            $villageURL .= $village["dorfname"] . " " . $village["coords"] . " " . "K" . $village["kontinent"] . "</a>";
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

    #[ArrayShape(["village" => "array", "own" => "array", "inVillage" => "array", "outwards" => "array", "all" => "array"])] function getAllPlayerTroopsAllinAllAjax(): array
    {
        $return = array(
            "time" => [],
            "own" => [],
            "inVillage" => [],
            "outwards" => [],
            "all" => []);
        $playerID = $this->playerID;
        $query = $this->query("SELECT 
		SUM(espeer) as 'espeer',
		SUM(eschwert) as 'eschwert',
		SUM(eaxt) as 'eaxt',
		SUM(ebogen) as 'ebogen',
		SUM(espaeher) as 'espaeher',					
		SUM(elkav) as 'elkav',
		SUM(eberittene) as 'eberittene',
		SUM(eskav) as 'eskav',
		SUM(eramme) as 'eramme', 
		SUM(ekata) as 'ekata',
		SUM(epala) as 'epala',
		SUM(eag) as 'eag',
		SUM(ispeer) as 'ispeer',
		SUM(ischwert) as 'ischwert',
		SUM(iaxt) as 'iaxt',
		SUM(ibogen) as 'ibogen',
		SUM(ispaeher) as 'ispaeher',					
		SUM(ilkav) as 'ilkav',
		SUM(iberittene) as 'iberittene',
		SUM(iskav) as 'iskav',
		SUM(iramme) as 'iramme', 
		SUM(ikata) as 'ikata',
		SUM(ipala) as 'ipala',
		SUM(iag) as 'iag',
		SUM(dspeer) as 'dspeer',
		SUM(dschwert) as 'dschwert',
		SUM(daxt) as 'daxt',
		SUM(dbogen) as 'dbogen',
		SUM(dspaeher) as 'dspaeher',					
		SUM(dlkav) as 'dlkav',
		SUM(dberittene) as 'dberittene',
		SUM(dskav) as 'dskav',
		SUM(dramme) as 'dramme', 
		SUM(dkata) as 'dkata',
		SUM(dpala) as 'dpala',
		SUM(dag) as 'dag',
		SUM(aspeer) as 'aspeer',
		SUM(aschwert) as 'aschwert',
		SUM(aaxt) as 'aaxt',
		SUM(abogen) as 'abogen',
		SUM(aspaeher) as 'aspaeher',					
		SUM(alkav) as 'alkav',
		SUM(aberittene) as 'aberittene',
		SUM(askav) as 'askav',
		SUM(aramme) as 'aramme', 
		SUM(akata) as 'akata',
		SUM(apala) as 'apala',
		SUM(aag) as 'aag',
		AVG(time) as time
		FROM `troups` WHERE playerid = '$playerID'");
        foreach ($query as $village) {
            $return["time"] = date("h:i d.m", $village["time"]);
            $return["own"] = [
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
                $village["eag"]];
            $return["inVillage"] = [
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
                $village["dag"]];
            $return["outwards"] = [
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
                $village["aag"]];
            $return["all"] = [
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
                $village["iag"]];
        }
        return $return;
    }

    function getAllPlayerBuildingsAjax(): array
    {
        $return = [];
        $playerID = $this->playerID;
        $query = $this->query("SELECT * FROM `buildings` WHERE playerid = '$playerID'");
        foreach($query AS $village){
            $villageURL = "<a href='" . Inno::getServerUrl($this->worldName);
            $villageURL .= "game.php?village={$village["coordsid"]}&screen=overview" . "' target='_blank'>";
            $villageURL .= $village["dorfname"] . " " . $village["dorfcoords"] . "</a>";
            $return[] = [
                $villageURL,
                $village["hg"],
                $village["kaserne"],
                $village["stall"],
                $village["werkstatt"],
                $village["kirche"],
                $village["erstekirche"],
                $village["wachturm"],
                $village["adelshof"],
                $village["schmiede"],
                $village["vp"],
                $village["statue"],
                $village["marktplatz"],
                $village["holz"],
                $village["stein"],
                $village["eisen"],
                $village["bauernhof"],
                $village["speicher"],
                $village["versteck"],
                $village["wall"]
            ];
        }
        return $return;
    }
}