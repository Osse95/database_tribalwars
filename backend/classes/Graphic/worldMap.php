<?php
require_once "mapHelpers.php";

class worldMap extends mapHelpers
{
    private array $villages = [];

    private array $tribes = [];
    private array $customTribes = [];

    private array $players = [];
    private array $customPlayers = [];

    private array $legends = [];
    private array $customLegends = [];

    private $image;
    private array $newSize = ["max" => 0, "min" => 4000];
    private array $customSize = ["maxX" => 0, "minX" => 4000, "maxY" => 0, "minY" => 4000];
    private bool $takeCustomSize = false;

    private array $colours;
    private array $transparentColours;

    private $font;
    private mixed $continentMap;

    private string $worldName;

    function __construct($world)
    {
        parent::__construct($world);
        $this->worldName = $world;
        $this->image = imagecreatetruecolor(4000, 4000);
        imagealphablending($this->image, true);
        imagesavealpha($this->image, true);
        $this->createColours();
        imagefill($this->image, 0, 0, $this->colours["green"]);
        $this->font = dirname(__DIR__, 3) . "/backend/fonts/SansBlack.ttf";
        $this->continentMap = imagecreatefrompng(dirname(__DIR__, 3) . "/backend/exampleGraphics/continent.png");
    }

    function createColours()
    {
        $this->transparentColours = array(
            "green" => imagecolorallocatealpha($this->image, 88, 118, 27, 110),
            "brown" => imagecolorallocatealpha($this->image, 7, 45, 8, 100),
            "grey" => imagecolorallocatealpha($this->image, 184, 184, 184, 119),
            "white" => imagecolorallocatealpha($this->image, 255, 255, 255, 90),
            "yellow" => imagecolorallocatealpha($this->image, 225, 235, 52, 110),
            "blue" => imagecolorallocatealpha($this->image, 0, 0, 200, 110),
            "lightblue" => imagecolorallocatealpha($this->image, 125, 122, 255, 110),
            "red" => imagecolorallocatealpha($this->image, 252, 3, 3, 100),
            "darkred" => imagecolorallocatealpha($this->image, 161, 0, 0, 110),
            "black" => imagecolorallocatealpha($this->image, 0, 0, 0, 110),
            "purple" => imagecolorallocatealpha($this->image, 128, 0, 128, 100),
            "pink" => imagecolorallocatealpha($this->image, 252, 3, 123, 110),
            "darkgrey" => imagecolorallocatealpha($this->image, 96, 75, 102, 110),
            "orange" => imagecolorallocatealpha($this->image, 247, 158, 49, 110),
            "lightgreen" => imagecolorallocatealpha($this->image, 16, 232, 95, 110)
        );
        $this->colours = array(
            "green" => imagecolorallocate($this->image, 88, 118, 27),
            "brown" => imagecolorallocate($this->image, 7, 45, 8),
            "grey" => imagecolorallocate($this->image, 184, 184, 184),
            "white" => imagecolorallocate($this->image, 255, 255, 255),
            "yellow" => imagecolorallocate($this->image, 225, 235, 52),
            "blue" => imagecolorallocate($this->image, 0, 0, 200),
            "lightblue" => imagecolorallocate($this->image, 125, 122, 255),
            "red" => imagecolorallocate($this->image, 252, 3, 3),
            "darkred" => imagecolorallocate($this->image, 161, 0, 0),
            "black" => imagecolorallocate($this->image, 0, 0, 0),
            "purple" => imagecolorallocate($this->image, 128, 0, 128),
            "pink" => imagecolorallocate($this->image, 252, 3, 123),
            "darkgrey" => imagecolorallocate($this->image, 96, 75, 102),
            "orange" => imagecolorallocate($this->image, 247, 158, 49),
            "lightgreen" => imagecolorallocate($this->image, 16, 232, 95)
        );
    }

    function getImage(): GdImage|bool
    {
        return $this->image;
    }

    function activateCustomSize()
    {
        $this->takeCustomSize = true;
    }

    function safeImage($type)
    {
        switch ($type) {
            case("heatmap"):
                break;
            case("diplomacy"):
                imagepng($this->image, dirname(__DIR__, 3) . "/graphic/diplomacyMap/" . $this->worldName . ".png");
                break;
            case("userMap"):
                $this->villages = [3];
                break;
            case("topTenMap"):
                imagepng($this->image, dirname(__DIR__, 3) . "/graphic/topTenMaps/" . $this->worldName . ".png");
                break;
        }
    }

    function selectMapType($type, $playerID = "")
    {
        switch ($type) {
            case("heatmap"):
                break;
            case("diplomacy"):
                $diplomacy = $this->getDiploTribes();
                $this->tribes = $diplomacy[0];
                $this->legends = $diplomacy[1];
                break;
            case("userMap"):
                $this->villages = [3];
                break;
            case("topTenMap"):
                $topTen = $this->topTenTribes();
                $this->tribes = $topTen[0];
                $this->legends = $topTen[1];
                break;
        }
    }

    function createMap()
    {
        $this->villages = $this->getVillages();

        foreach ($this->villages as $village) {

            $playerID = $village["spielerid"];
            $tribeID = $village["tribe"];

            $villageCoords = explode("|", substr($village["dorfcoords"], 1, -1));
            $villageX = round(4 * $villageCoords[0]);
            $villageY = round(4 * $villageCoords[1]);

            $customSize = false;
            $max = max($villageX, $villageY);
            $min = min($villageX, $villageY);
            if ($this->newSize["min"] > $min) {
                $this->newSize["min"] = $min;
            }
            if ($this->newSize["max"] < $max) {
                $this->newSize["max"] = $max;
            }

            if ($playerID >= 0) {
                imagefilledrectangle($this->image, $villageX - 1, $villageY - 1, $villageX + 1, $villageY + 1, $this->colours["brown"]);
            } else {
                imagefilledrectangle($this->image, $villageX - 1, $villageY - 1, $villageX + 1, $villageY + 1, $this->colours["grey"]);
            }

            if (isset($this->tribes[$tribeID])) {
                $customSize = true;
                imagefilledrectangle($this->image, $villageX - 6, $villageY - 6, $villageX + 6, $villageY + 6, $this->colours["green"]);
                imagefilledrectangle($this->image, $villageX - 1, $villageY - 1, $villageX + 1, $villageY + 1, $this->colours[$this->tribes[$tribeID]]);
                imagefilledrectangle($this->image, $villageX - 6, $villageY - 6, $villageX + 6, $villageY + 6, $this->transparentColours[$this->tribes[$tribeID]]);
            }
            if (isset($this->players[$playerID])) {
                $customSize = true;
                imagefilledrectangle($this->image, $villageX - 6, $villageY - 6, $villageX + 6, $villageY + 6, $this->colours["green"]);
                imagefilledrectangle($this->image, $villageX - 1, $villageY - 1, $villageX + 1, $villageY + 1, $this->colours[$this->players[$playerID]]);
                imagefilledrectangle($this->image, $villageX - 6, $villageY - 6, $villageX + 6, $villageY + 6, $this->transparentColours[$this->players[$playerID]]);
            }

            if ($customSize) {
                if ($this->customSize["minX"] > $villageX) {
                    $this->customSize["minX"] = $villageX;
                }
                if ($this->customSize["minY"] > $villageY) {
                    $this->customSize["minY"] = $villageY;
                }
                if ($this->customSize["maxX"] < $villageX) {
                    $this->customSize["maxX"] = $villageX;
                }
                if ($this->customSize["maxY"] < $villageY) {
                    $this->customSize["maxY"] = $villageY;
                }
            }
        }

        imagecopy($this->image, $this->continentMap, 0, 0, 0, 0, 4000, 4000);

        foreach ($this->villages as $village) {

            $playerID = $village["spielerid"];
            $tribeID = $village["tribe"];

            $villageCoords = explode("|", substr($village["dorfcoords"], 1, -1));
            $villageX = round(4 * $villageCoords[0]);
            $villageY = round(4 * $villageCoords[1]);

            if ($playerID >= 0) {
                imagefilledrectangle($this->image, $villageX - 1, $villageY - 1, $villageX + 1, $villageY + 1, $this->transparentColours["brown"]);
            } else {
                imagefilledrectangle($this->image, $villageX - 1, $villageY - 1, $villageX + 1, $villageY + 1, $this->transparentColours["grey"]);
            }
            if (isset($this->tribes[$tribeID])) {
                imagefilledrectangle($this->image, $villageX - 1, $villageY - 1, $villageX + 1, $villageY + 1, $this->colours[$this->tribes[$tribeID]]);
            }
            if (isset($this->players[$playerID])) {
                imagefilledrectangle($this->image, $villageX - 1, $villageY - 1, $villageX + 1, $villageY + 1, $this->colours[$this->players[$playerID]]);
            }
        }

        foreach ($this->legends as $legend) {
            $villageX = round(4 * $legend["x"]);
            $villageY = round(4 * $legend["y"]);
            if (count($this->villages) < 10000) {
                $textSize = [15, 14, 14, 13];
            } elseif (count($this->villages) < 20000) {
                $textSize = [22, 17, 21, 16];
            } elseif (count($this->villages) < 30000) {
                $textSize = [27, 17, 26, 16];
            } else {
                $textSize = [35, 25, 34, 24];
            }

            imagettftext($this->image, $textSize[0], 0, $villageX + 1, $villageY + 1, $this->colours["black"], $this->font, $legend["text"]);
            imagettftext($this->image, $textSize[0], 0, $villageX - 1, $villageY - 1, $this->colours["black"], $this->font, $legend["text"]);
            imagettftext($this->image, $textSize[2], 0, $villageX, $villageY, $this->colours[$legend["colour"]], $this->font, $legend["text"]);

            if (isset($legend["proportion"])) {
                imagettftext($this->image, $textSize[1], 0, $villageX + 1, $villageY + $textSize[1], $this->colours["black"], $this->font, $legend["proportion"]);
                imagettftext($this->image, $textSize[1], 0, $villageX - 1, $villageY + $textSize[1], $this->colours["black"], $this->font, $legend["proportion"]);
                imagettftext($this->image, $textSize[3], 0, $villageX, $villageY + $textSize[1], $this->colours[$legend["colour"]], $this->font, $legend["proportion"]);
            }
        }

        if ($this->takeCustomSize) {
            $this->customSize["maxX"] = $this->customSize["maxX"] + 20;
            $this->customSize["maxY"] = $this->customSize["maxY"] + 20;
            $this->customSize["minX"] = $this->customSize["minX"] - 20;
            $this->customSize["minY"] = $this->customSize["minY"] - 20;
            $w = $this->customSize["maxX"] - $this->customSize["minX"];
            $h = $this->customSize["maxY"] - $this->customSize["minY"];
            $image = imagecreatetruecolor($w, $h);
            imagecopy($image, $this->image, 0, 0, $this->customSize["minX"], $this->customSize["minY"], $w, $h);
        } else {
            $this->newSize["max"] = $this->newSize["max"] + 50;
            $this->newSize["min"] = $this->newSize["min"] - 50;
            $w = $this->newSize["max"] - $this->newSize["min"];
            $s = $this->newSize["min"];
            $image = imagecreatetruecolor($w, $w);
            imagecopy($image, $this->image, 0, 0, $s, $s, $w, $w);
        }
        $this->image = $image;
    }

}