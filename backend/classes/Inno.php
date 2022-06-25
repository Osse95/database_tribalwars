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

    static function getServerUrl($world)
    {
        preg_match("/(?<world>\w+\d+)/", $world, $match);
        $world = $match["world"]??"";
        if (str_contains($world, "de")) {
            return "https://$world.die-staemme.de/";
        } elseif (str_contains($world, "ch")) {
            return "https://$world.staemme.ch";
        } else {
            return false;
        }
    }
}