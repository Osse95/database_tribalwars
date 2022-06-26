<?php

class graphicControl
{

    static function checkTopTenMap($world): bool
    {
        $file = dirname(__DIR__, 3) . "/graphic/topTenMaps/" . $world.".png";
        if (!file_exists($file)) {
            return false;
        }
        if (filemtime($file) < time() - 14400) {
            return false;
        }
        return true;
    }

    static function getTopTenMap($world): bool
    {
        $file = dirname(__DIR__, 3) . "/graphic/topTenMaps/" . $world.".png";
        $file = imagecreatefrompng($file);
        return imagepng($file);
    }
}