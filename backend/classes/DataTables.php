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

    public static function sortBy($sort): string
    {
        if($sort == "asc"){
            return " asc";
        }else{
            return " desc";
        }
    }
}