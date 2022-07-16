<?php
require_once "mapHelpers.php";

class worldMap extends mapHelpers
{

    private array $villages = [];
    private array $customVillages = [];

    private array $tribes = [];
    private array $customTribes = [];

    private array $players = [];
    private array $customPlayers = [];

    private array $legends = [];
    private array $customLegends = [];

    private array $buildings = [];
    private array $customBuildings = [];

    private $image;
    private array $newSize = ["max" => 0, "min" => 4000];
    private array $customSize = ["maxX" => 0, "minX" => 4000, "maxY" => 0, "minY" => 4000];
    private bool $takeCustomSize = false;

    private array $colours;
    private array $transparentColours;

    private $font;
    private mixed $continentMap;

    private string $worldName;
    private int $ID;

    function __construct($world, $ID = 0)
    {
        parent::__construct($world, $ID);
        $this->worldName = $world;
        $this->ID = intval($ID);

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
            "darkyellow" => imagecolorallocatealpha($this->image, 175, 184, 22, 100),
            "yellow" => imagecolorallocatealpha($this->image, 225, 235, 52, 110),
            "blue" => imagecolorallocatealpha($this->image, 0, 0, 200, 110),
            "darkblue" => imagecolorallocatealpha($this->image, 41, 39, 138, 110),
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
            "darkyellow" => imagecolorallocate($this->image, 175, 184, 22),
            "yellow" => imagecolorallocate($this->image, 225, 235, 52),
            "blue" => imagecolorallocate($this->image, 0, 0, 200),
            "darkblue" => imagecolorallocate($this->image, 41, 39, 138),
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
            case("heatMap"):
                imagepng($this->image, dirname(__DIR__, 3) . "/graphic/heatmaps/" . $this->worldName . ".png");
                break;
            case("sourceMap"):
                imagepng($this->image, dirname(__DIR__, 3) . "/graphic/sourceMaps/" . $this->worldName . ".png");
                break;
            case("diplomacy"):
                imagepng($this->image, dirname(__DIR__, 3) . "/graphic/diplomacyMap/" . $this->worldName . ".png");
                break;
            case("userMap"):
                imagepng($this->image, dirname(__DIR__, 3) . "/graphic/usermaps/" . $this->worldName . $this->ID . ".png");
                break;
            case("topTenMap"):
                imagepng($this->image, dirname(__DIR__, 3) . "/graphic/topTenMaps/" . $this->worldName . ".png");
                break;
            case("playerMap"):
                imagepng($this->image, dirname(__DIR__, 3) . "/graphic/playerMaps/" . $this->worldName . $this->ID . ".png");
                break;
            case("tribeMap"):
                imagepng($this->image, dirname(__DIR__, 3) . "/graphic/tribeMaps/" . $this->worldName . $this->ID . ".png");
                break;
            case("interactiveMap"):
                imagepng($this->image, dirname(__DIR__, 3) . "/graphic/interactiveMap/" . $this->worldName . ".png");
                break;

        }
    }

    function selectMapType($type, $ID = "")
    {
        switch ($type) {
            case("heatMap"):
                $heat = $this->getAttacks();
                $this->tribes = $heat[0];
                $this->villages = $heat[1];
                break;
            case("sourceMap"):
                $source = $this->getSources();
                $this->tribes = $source[0];
                $this->villages = $source[1];
                break;
            case("diplomacy"):
                $diplomacy = $this->getDiploTribes();
                $this->tribes = $diplomacy[0];
                $this->legends = $diplomacy[1];
                break;
            case("userMap"):
                $user = $this->getUserMap();
                $this->players = $user[0];
                $this->buildings = $user[1];
                break;
            case("topTenMap"):
                $topTen = $this->topTenTribes();
                $this->tribes = $topTen[0];
                $this->legends = $topTen[1];
                break;
            case("playerMap"):
                $playerMap = $this->playerMap();
                $this->tribes = $playerMap[0];
                $this->players = $playerMap[1];
                break;
            case("tribeMap"):
                $tribeMap = $this->tribeMap();
                $this->tribes = $tribeMap[0];
                break;
            case("interactiveMap"):
                $interactive = $this->getInteractive();
                $this->tribes = $interactive[0];
                break;
        }
    }

    function createMap()
    {
        $villages = $this->getVillages();

        foreach ($villages as $village) {

            $ID = $village["spielerid"];
            $tribeID = $village["tribe"];

            $villageID = $village["dorfid"];
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

            if ($ID >= 0) {
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
            if (isset($this->players[$ID])) {
                $customSize = true;
                imagefilledrectangle($this->image, $villageX - 6, $villageY - 6, $villageX + 6, $villageY + 6, $this->colours["green"]);
                imagefilledrectangle($this->image, $villageX - 1, $villageY - 1, $villageX + 1, $villageY + 1, $this->colours[$this->players[$ID]]);
                imagefilledrectangle($this->image, $villageX - 6, $villageY - 6, $villageX + 6, $villageY + 6, $this->transparentColours[$this->players[$ID]]);
            }
            if (isset($this->villages[$villageID])) {
                $customSize = true;
                imagefilledrectangle($this->image, $villageX - 6, $villageY - 6, $villageX + 6, $villageY + 6, $this->colours["green"]);
                imagefilledrectangle($this->image, $villageX - 1, $villageY - 1, $villageX + 1, $villageY + 1, $this->colours[$this->villages[$villageID]]);
                imagefilledrectangle($this->image, $villageX - 6, $villageY - 6, $villageX + 6, $villageY + 6, $this->transparentColours[$this->villages[$villageID]]);
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

        foreach ($villages as $village) {

            $ID = $village["spielerid"];
            $tribeID = $village["tribe"];

            $villageID = $village["dorfid"];
            $villageCoords = explode("|", substr($village["dorfcoords"], 1, -1));
            $villageX = round(4 * $villageCoords[0]);
            $villageY = round(4 * $villageCoords[1]);

            if ($ID >= 0) {
                imagefilledrectangle($this->image, $villageX - 1, $villageY - 1, $villageX + 1, $villageY + 1, $this->transparentColours["brown"]);
            } else {
                imagefilledrectangle($this->image, $villageX - 1, $villageY - 1, $villageX + 1, $villageY + 1, $this->transparentColours["grey"]);
            }
            if (isset($this->tribes[$tribeID])) {
                imagefilledrectangle($this->image, $villageX - 1, $villageY - 1, $villageX + 1, $villageY + 1, $this->colours[$this->tribes[$tribeID]]);
            }
            if (isset($this->players[$ID])) {
                imagefilledrectangle($this->image, $villageX - 1, $villageY - 1, $villageX + 1, $villageY + 1, $this->colours[$this->players[$ID]]);
            }
            if (isset($this->villages[$villageID])) {
                imagefilledrectangle($this->image, $villageX - 1, $villageY - 1, $villageX + 1, $villageY + 1, $this->colours[$this->villages[$villageID]]);
            }
        }
        $tryNoOverlay = [];
        foreach ($this->legends as $legend) {
            $villageX = round(4 * $legend["x"]) - 50;
            $villageY = round(4 * $legend["y"]);

            if (count($villages) < 10000) {
                $textSize = [15, 14, 14, 13];
                $overlaySize = [30, 50];
            } elseif (count($villages) < 20000) {
                $textSize = [22, 17, 21, 16];
                $overlaySize = [50, 70];
            } elseif (count($villages) < 30000) {
                $textSize = [27, 17, 26, 16];
                $overlaySize = [70, 90];
            } else {
                $textSize = [45, 25, 44, 24];
                $overlaySize = [80, 100];
            }

            for ($i = 0; $i < count($tryNoOverlay); $i++) {
                $x = $tryNoOverlay[$i]["X"];
                $y = $tryNoOverlay[$i]["Y"];
                if ($y + $overlaySize[0] >= $villageY and $y - $overlaySize[0] <= $villageY and $x + $overlaySize[0] >= $villageX and $x - $overlaySize[0] <= $villageX) {
                    $villageY = $villageY + $overlaySize[1];
                }
            }

            $tryNoOverlay[count($tryNoOverlay)] = array(
                "X" => $villageX,
                "Y" => $villageY
            );

            imagettftext($this->image, $textSize[0], 0, $villageX, $villageY + 2, $this->colours["black"], $this->font, $legend["text"]);
            imagettftext($this->image, $textSize[0], 0, $villageX + 2, $villageY + 2, $this->colours["black"], $this->font, $legend["text"]);
            imagettftext($this->image, $textSize[0], 0, $villageX + 2, $villageY + 2, $this->colours["black"], $this->font, $legend["text"]);
            imagettftext($this->image, $textSize[0], 0, $villageX + 2, $villageY, $this->colours["black"], $this->font, $legend["text"]);
            imagettftext($this->image, $textSize[0], 0, $villageX, $villageY, $this->colours["black"], $this->font, $legend["text"]);
            imagettftext($this->image, $textSize[0], 0, $villageX - 2, $villageY - 2, $this->colours["black"], $this->font, $legend["text"]);
            imagettftext($this->image, $textSize[0], 0, $villageX - 2, $villageY - 2, $this->colours["black"], $this->font, $legend["text"]);
            imagettftext($this->image, $textSize[0], 0, $villageX - 2, $villageY, $this->colours["black"], $this->font, $legend["text"]);
            imagettftext($this->image, $textSize[2], 0, $villageX, $villageY, $this->colours[$legend["colour"]], $this->font, $legend["text"]);

            if (isset($legend["proportion"])) {
                imagettftext($this->image, $textSize[1], 0, $villageX, $villageY + 2 + $textSize[1], $this->colours["black"], $this->font, $legend["proportion"]);
                imagettftext($this->image, $textSize[1], 0, $villageX + 2, $villageY + 2 + $textSize[1], $this->colours["black"], $this->font, $legend["proportion"]);
                imagettftext($this->image, $textSize[1], 0, $villageX + 2, $villageY + 2 + $textSize[1], $this->colours["black"], $this->font, $legend["proportion"]);
                imagettftext($this->image, $textSize[1], 0, $villageX + 2, $villageY + $textSize[1], $this->colours["black"], $this->font, $legend["proportion"]);
                imagettftext($this->image, $textSize[1], 0, $villageX, $villageY + $textSize[1], $this->colours["black"], $this->font, $legend["proportion"]);
                imagettftext($this->image, $textSize[1], 0, $villageX - 2, $villageY - 2 + $textSize[1], $this->colours["black"], $this->font, $legend["proportion"]);
                imagettftext($this->image, $textSize[1], 0, $villageX - 2, $villageY - 2 + $textSize[1], $this->colours["black"], $this->font, $legend["proportion"]);
                imagettftext($this->image, $textSize[1], 0, $villageX - 2, $villageY + $textSize[1], $this->colours["black"], $this->font, $legend["proportion"]);
                imagettftext($this->image, $textSize[3], 0, $villageX, $villageY + $textSize[1], $this->colours["white"], $this->font, $legend["proportion"]);
            }
        }

        if (isset($this->buildings["watchtowers"])) {
            foreach ($this->buildings["watchtowers"] as $watchtower) {
                imagefilledarc($this->image, $watchtower["x"] * 4, $watchtower["y"] * 4, intval($watchtower["range"] * 8), intval($watchtower["range"] * 8), 0, 360, $this->transparentColours[$watchtower["colour"]], IMG_ARC_EDGED);
                imagearc($this->image, $watchtower["x"] * 4, $watchtower["y"] * 4, intval($watchtower["range"] * 8), intval($watchtower["range"] * 8), 0, 360, $this->colours[$watchtower["colour"]]);
            }
        }
        if (isset($this->buildings["churches"])) {
            foreach ($this->buildings["churches"] as $church) {
                imagearc($this->image, $church["x"] * 4, $church["y"] * 4, $church["range"] * 8, $church["range"] * 8, 0, 360, $this->colours[$church["colour"]]);
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
            $this->newSize["max"] = $this->newSize["max"] + 20;
            $this->newSize["min"] = $this->newSize["min"] - 20;
            $w = $this->newSize["max"] - $this->newSize["min"];
            $s = $this->newSize["min"];
            $image = imagecreatetruecolor($w, $w);
            imagecopy($image, $this->image, 0, 0, $s, $s, $w, $w);
        }
        $this->image = $image;
    }

}