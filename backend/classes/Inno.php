<?php

class Inno
{
    static function getActiveWorlds(): array
    {
        $activeWorlds = [];
        $switzerWorlds = gzfile("https://staemme.ch/backend/get_servers.php");
        $germanWorlds = gzfile("https://die-staemme.de/backend/get_servers.php");
        $re = '/\"(?<world>[a-z]+\d+)\"/';
        preg_match_all($re, $germanWorlds[0], $germanWorlds, PREG_SET_ORDER, 0);
        foreach ($germanWorlds as $world) {
            $activeWorlds[] = $world["world"];
        }
        preg_match_all($re, $switzerWorlds[0], $switzerWorlds, PREG_SET_ORDER, 0);
        foreach ($switzerWorlds as $world) {
            $activeWorlds[] = $world["world"];
        }
        return $activeWorlds;
    }

    static function existWorld($world): bool
    {
        $activeWorlds = self::getActiveWorlds();
        if (in_array($world, $activeWorlds)) {
            return true;
        } else {
            return false;
        }
    }

    static function getServerUrl($world): bool|string
    {
        preg_match("/(?<world>\w+\d+)/", $world, $match);
        $world = $match["world"] ?? "";
        if (str_contains($world, "de")) {
            return "https://$world.die-staemme.de/";
        } elseif (str_contains($world, "ch")) {
            return "https://$world.staemme.ch";
        } else {
            return false;
        }
    }

    static function getWatchtowerRange($level): float|int
    {
        return match (intval($level)) {
            2 => 1.3,
            3 => 1.5,
            4 => 1.7,
            5 => 2,
            6 => 2.3,
            7 => 2.6,
            8 => 3,
            9 => 3.4,
            10 => 3.9,
            11 => 4.4,
            12 => 5.1,
            13 => 5.8,
            14 => 6.7,
            15 => 7.6,
            16 => 8.7,
            17 => 10,
            18 => 11.5,
            19 => 13.1,
            20 => 15,
            default => 1.1,
        };
    }

    static function getChurchRange($level): int
    {
        return match (intval($level)) {
            2 => 6,
            3 => 8,
            default => 4,
        };
    }
}