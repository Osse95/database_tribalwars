<?php

require_once dirname(__DIR__, 3) . "/backend/classes/DB.php";
require_once dirname(__DIR__, 3) . "/backend/classes/Inno.php";

class Report extends DB
{
    private mixed $report = [];
    private bool $exist = false;
    private int $reportID = 0;
    private string $World;

    function __construct($world, $reportID = 0)
    {
        parent::__construct($world);
        $this->World = $world;

        $stmt = $this->conn->prepare("SELECT * FROM `reports` WHERE ID = ?");
        $stmt->execute([$reportID]);

        foreach ($stmt->get_result() as $row) {
            $this->report = $row;
        }
        if (count($this->report) != 0) {
            $this->exist = true;
            $this->reportID = $reportID;
        }
    }

    function isReportAvailable(): bool
    {
        return $this->exist;
    }

    function getSubject()
    {
        return $this->report["bericht"];
    }

    function getFighttime()
    {
        return $this->report["fighttime"];
    }

    function getAttackerLuck()
    {
        return $this->report["luck"];
    }

    function getAttackerMoral()
    {
        return $this->report["moral"];
    }

    function getAttackerInfo(): array
    {
        $ingameURL = Inno::getServerUrl($this->World) . "game.php?screen=info_player&id=" . $this->report["attacker_id"];
        $ingameCoordUrl = Inno::getServerUrl($this->World) . "game.php?game.php?screen=info_village&id=" . $this->report["attacker_coordsid"];
        return array(
            "attackerName" => $this->report["attacker_nick"],
            "attackerID" => $this->report["attacker_id"],
            "attackerIngameLink" => $ingameURL,
            "attackerVillageName" => $this->report["attacker_village"],
            "attackerCoord" => $this->report["attacker_coords"],
            "attackerCoordID" => $this->report["attacker_coordsid"],
            "attackerCoordUrl" => $ingameCoordUrl,
            "attackerContinent" => $this->report["attacker_continent"],
            "attackerFaith" => $this->report["attacker_faith"]);
    }

    function getDefenderInfo(): array
    {
        $ingameURL = Inno::getServerUrl($this->World) . "game.php?screen=info_player&id=" . $this->report["defender_id"];
        $ingameCoordUrl = Inno::getServerUrl($this->World) . "game.php?game.php?screen=info_village&id=" . $this->report["defender_coordsid"];
        return array(
            "defenderName" => $this->report["defender_nick"],
            "defenderID" => $this->report["defender_id"],
            "defenderIngameLink" => $ingameURL,
            "defenderVillageName" => $this->report["defender_village"],
            "defenderCoord" => $this->report["defender_coords"],
            "defenderCoordID" => $this->report["defender_coordsid"],
            "defenderCoordUrl" => $ingameCoordUrl,
            "defenderContinent" => $this->report["defender_continent"],
            "defenderFaith" => $this->report["defender_faith"],
            "defenderTroopsInside" => $this->report["troupssee"],
            "defenderTroopsOutside" => $this->report["troupsseeout"]
        );
    }

    function getAttackerUnits(): array
    {
        return array(
            $this->report["troops_att_spear"],
            $this->report["troops_att_sword"],
            $this->report["troops_att_axe"],
            $this->report["troops_att_archer"],
            $this->report["troops_att_spy"],
            $this->report["troops_att_light"],
            $this->report["troops_att_marcher"],
            $this->report["troops_att_heavy"],
            $this->report["troops_att_ram"],
            $this->report["troops_att_catapult"],
            $this->report["troops_att_knight"],
            $this->report["troops_att_snob"]
        );
    }

    function getAttackerUnitsLoss(): array
    {
        return array(
            $this->report["troops_attl_spear"],
            $this->report["troops_attl_sword"],
            $this->report["troops_attl_axe"],
            $this->report["troops_attl_archer"],
            $this->report["troops_attl_spy"],
            $this->report["troops_attl_light"],
            $this->report["troops_attl_marcher"],
            $this->report["troops_attl_heavy"],
            $this->report["troops_attl_ram"],
            $this->report["troops_attl_catapult"],
            $this->report["troops_attl_knight"],
            $this->report["troops_attl_snob"]
        );
    }

    function getDefenderUnits(): array
    {
        return array(
            $this->report["troops_def_spear"],
            $this->report["troops_def_sword"],
            $this->report["troops_def_axe"],
            $this->report["troops_def_archer"],
            $this->report["troops_def_spy"],
            $this->report["troops_def_light"],
            $this->report["troops_def_marcher"],
            $this->report["troops_def_heavy"],
            $this->report["troops_def_ram"],
            $this->report["troops_def_catapult"],
            $this->report["troops_def_knight"],
            $this->report["troops_def_snob"]
        );
    }

    function getDefenderUnitsLoss(): array
    {
        return array(
            $this->report["troops_defl_spear"],
            $this->report["troops_defl_sword"],
            $this->report["troops_defl_axe"],
            $this->report["troops_defl_archer"],
            $this->report["troops_defl_spy"],
            $this->report["troops_defl_light"],
            $this->report["troops_defl_marcher"],
            $this->report["troops_defl_heavy"],
            $this->report["troops_defl_ram"],
            $this->report["troops_defl_catapult"],
            $this->report["troops_defl_knight"],
            $this->report["troops_defl_snob"]
        );
    }

    function getDefenderUnitsOutside(): array
    {
        return array(
            $this->report["spied_troops_out_spear"],
            $this->report["spied_troops_out_sword"],
            $this->report["spied_troops_out_axe"],
            $this->report["spied_troops_out_archer"],
            $this->report["spied_troops_out_spy"],
            $this->report["spied_troops_out_light"],
            $this->report["spied_troops_out_marcher"],
            $this->report["spied_troops_out_heavy"],
            $this->report["spied_troops_out_ram"],
            $this->report["spied_troops_out_catapult"],
            $this->report["spied_troops_out_knight"],
            $this->report["spied_troops_out_snob"]
        );
    }

    function getDefenderBuildings(): array
    {
        return array(
            "main" => $this->report["buildings_main"],
            "barracks" => $this->report["buildings_barracks"],
            "stable" => $this->report["buildings_stable"],
            "garage" => $this->report["buildings_garage"],
            "church" => $this->report["buildings_church"],
            "firstChurch" => $this->report["buildings_firstchurch"],
            "smith" => $this->report["buildings_smith"],
            "place" => $this->report["buildings_place"],
            "statue" => $this->report["buildings_statue"],
            "market" => $this->report["buildings_market"],
            "wood" => $this->report["buildings_wood"],
            "stone" => $this->report["buildings_stone"],
            "iron" => $this->report["buildings_iron"],
            "farm" => $this->report["buildings_farm"],
            "storage" => $this->report["buildings_storage"],
            "snob" => $this->report["buildings_snob"],
            "hide" => $this->report["buildings_hide"],
            "watchtower" => $this->report["buildings_watchtower"],
            "wall" => $this->report["buildings_wall"]
        );
    }

    function getRamDamage(): array
    {
        return array(
            "before" => $this->report["wall_before"],
            "after" => $this->report["wall_after"]
        );
    }
    function getCataDamage(): array
    {
        return array(
            "target" => $this->report["catapult_building"],
            "before" => $this->report["catapult_before"],
            "after" => $this->report["catapult_after"]
        );
    }
    function getMoodDeduction(): array
    {
        return array(
            "before" => $this->report["mood_before"],
            "after" => $this->report["mood_after"]
        );
    }
}