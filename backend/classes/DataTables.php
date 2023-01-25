<?php
class DataTables{

    public static function sortOwnAttacksWithWatchtower($column): string
    {
        return match ($column) {
            "1" => "defendercoords",
            "3" => "reason",
            "4" => "attackerid",
            "5" => "attackercoords",
            "7" => "counter",
            "8" => "predictedLabel",
            "9" => "watchtowertime",
            "10" => "timeunix",
            default => "type2",
        };
    }

    public static function sortOwnAttacksWithoutWatchtower($column): string
    {
        return match ($column) {
            "1" => "defendercoords",
            "3" => "reason",
            "4" => "attackerid",
            "5" => "attackercoords",
            "7" => "counter",
            "8" => "predictedLabel",
            "9" => "timeunix",
            default => "type2",
        };
    }

    public static function sortAllAttacks($column): string
    {
        return match ($column) {
            "1" => "defenderid",
            "2" => "defendercoords",
            "3" => "attackerid",
            "4" => "attackercoords",
            "5" => "reason",
            "6" => "eingelesen_am",
            "7" => "counter",
            "8" => "predictedLabel",
            "9" => "timeunix",
            default => "type2",
        };
    }

    public static function sortAllMembers($column): string
    {
        return match ($column) {
            "1" => "playerid",
            "3" => "level",
            "4" => "mods",
            "5" => "offkoord",
            "6" => "deffkoord",
            "7" => "reports",
            "8" => "attacks",
            "9" => "Version",
            default => "name",
        };
    }

    public static function sortReportTable($column): string
    {
        return match ($column) {
            "1" => "defender_nick",
            "3" => "fighttime",
            default => "attacker_nick"
        };
    }

    public static function sortSupportReportTable($column): string
    {
        return match ($column) {
            "1" => "defender_nick",
            "3" => "support_time",
            default => "supporter_nick"
        };
    }

    public static function sortConquerTable($column): string
    {
        return match ($column) {
            "0" => "villageid",
            "1" => "points",
            "2" => "old_owner",
            "3" => "old_tribe",
            "4" => "new_owner",
            "5" => "new_tribe",
            "6" => "timestamp",
            default => "attacker_nick"
        };
    }

    public static function sortBy($sort): string
    {
        if($sort == "asc"){
            return " asc";
        }else{
            return " desc";
        }
    }
}