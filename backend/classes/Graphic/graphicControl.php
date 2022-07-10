<?php

class graphicControl
{

    static function checkTopTenMap($world): bool
    {
        //check if map exist or is older then 4hours
        $file = dirname(__DIR__, 3) . "/graphic/topTenMaps/" . $world . ".png";
        if (!file_exists($file)) {
            return false;
        }
        if (filemtime($file) < time() - 3600 * 4) {
            return false;
        }
        return true;
    }

    static function checkDiplomacyMap($world): bool
    {
        //check if map exist or is older then 4hours
        $file = dirname(__DIR__, 3) . "/graphic/diplomacyMap/" . $world . ".png";
        if (!file_exists($file)) {
            return false;
        }
        if (filemtime($file) < time() - 3600 * 4) {
            return false;
        }
        return true;
    }

    static function checkUserMap($world, $playerID): bool
    {
        //check if map exist or is older then 12hours
        $file = dirname(__DIR__, 3) . "/graphic/usermaps/" . $world . $playerID . ".png";
        if (!file_exists($file)) {
            return false;
        }
        if (filemtime($file) < time() - 3600 * 12) {
            return false;
        }
        return true;
    }

    static function checkHeatMap($world): bool
    {
        //check if map exist or is older then 3hours
        $file = dirname(__DIR__, 3) . "/graphic/heatmaps/" . $world . ".png";
        if (!file_exists($file)) {
            return false;
        }
        if (filemtime($file) < time() - 3600 * 3) {
            return false;
        }
        return true;
    }

    static function checkSourceMap($world): bool
    {
        //check if map exist or is older then 3hours
        $file = dirname(__DIR__, 3) . "/graphic/sourceMaps/" . $world . ".png";
        if (!file_exists($file)) {
            return false;
        }
        if (filemtime($file) < time() - 3600 * 3) {
            return false;
        }
        return true;
    }

    static function checkPlayerMap($world, $playerID): bool
    {
        //check if map exist or is older then 6hours
        $file = dirname(__DIR__, 3) . "/graphic/playerMaps/" . $world . $playerID . ".png";
        if (!file_exists($file)) {
            return false;
        }
        if (filemtime($file) < time() - 3600 * 6) {
            return false;
        }
        return true;
    }

    static function checkTribeMap($world, $tribeID): bool
    {
        //check if map exist or is older then 6hours
        $file = dirname(__DIR__, 3) . "/graphic/tribeMaps/" . $world . $tribeID . ".png";
        if (!file_exists($file)) {
            return false;
        }
        if (filemtime($file) < time() - 3600 * 6) {
            return false;
        }
        return true;
    }

    static function getTopTenMap($world): bool
    {
        $file = dirname(__DIR__, 3) . "/graphic/topTenMaps/" . $world . ".png";
        $file = imagecreatefrompng($file);
        return imagepng($file);
    }

    static function getDiplomacyMap($world): bool
    {
        $file = dirname(__DIR__, 3) . "/graphic/diplomacyMap/" . $world . ".png";
        $file = imagecreatefrompng($file);
        return imagepng($file);
    }

    static function getUserMap($world, $playerID): bool
    {
        $file = dirname(__DIR__, 3) . "/graphic/usermaps/" . $world . $playerID . ".png";
        $file = imagecreatefrompng($file);
        return imagepng($file);
    }

    static function getHeatMap($world): bool
    {
        $file = dirname(__DIR__, 3) . "/graphic/heatmaps/" . $world . ".png";
        $file = imagecreatefrompng($file);
        return imagepng($file);
    }

    static function getSourceMap($world): bool
    {
        $file = dirname(__DIR__, 3) . "/graphic/sourceMaps/" . $world . ".png";
        $file = imagecreatefrompng($file);
        return imagepng($file);
    }
    
    static function getPlayerMap($world, $playerID): bool
    {
        $file = dirname(__DIR__, 3) . "/graphic/playerMaps/" . $world . $playerID . ".png";
        $file = imagecreatefrompng($file);
        return imagepng($file);
    }

    static function getTribeMap($world, $tribeID): bool
    {
        $file = dirname(__DIR__, 3) . "/graphic/tribeMaps/" . $world . $tribeID . ".png";
        $file = imagecreatefrompng($file);
        return imagepng($file);
    }

}