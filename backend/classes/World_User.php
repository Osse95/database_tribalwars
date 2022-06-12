<?php
require_once "DB.php";

class World_User extends DB
{
    private $name;
    public bool $exists = false;
    private array $World_Account;

    function __construct($user, $world)
    {
        parent::__construct();
        $stmt = $this->conn->prepare("SELECT * FROM `Allgemein`.`userrollen` WHERE name = ? and world = ?");
        $stmt->bind_param("ss", $user, $world);
        $stmt->execute();
        $stmt->bind_result($name, $world, $version, $playerID, $tribeID, $level, $mod, $off, $def, $reports, $attacks, $uvActive, $uvPlayerID);
        while ($stmt->fetch()) {
            $this->World_Account = array("Name" => $name,
                "world" => $world,
                "version" => $version,
                "worldVersion" => $world . "-" . $version,
                "playerID" => $playerID,
                "tribeID" => $tribeID,
                "level" => $level,
                "mod" => $mod,
                "off" => $off,
                "def" => $def,
                "reports" => $reports,
                "attacks" => $attacks,
                "uvActive" => $uvActive,
                "uvPlayerID" => $uvPlayerID);
            $this->exists = true;
            $this->name = $user;
        }
    }

    function createNormalUser($user, $world, $playerID, $tribeID)
    {
        $stmt = $this->conn->prepare("INSERT INTO `userrollen` (name,world,playerid,stammesid,level,version,reports,attacks,uv_active) VALUES (?, ?, ?, ?, ?, ? ,? ,? , ?)");
        $null = 0;
        $version = -1;
        $eins = 1;
        $no = "no";
        $stmt->bind_param("ssssiiiis", $user, $world, $playerID, $tribeID, $null, $version, $eins, $eins, $no);
        $stmt->execute();
        $stmt->close();
    }

    function createSFUser($user, $world, $playerID, $tribeID)
    {
        $stmt = $this->conn->prepare("INSERT INTO `userrollen` (name,world,playerid,stammesid,level,version,reports,attacks,uv_active) VALUES (?, ?, ?, ?, ?, ? ,? ,? , ?)");
        $version = $this->maxVersion($world) + 1;
        $eins = 1;
        $ten = 10;
        $no = "no";
        $stmt->bind_param("ssssiiiis", $user, $world, $playerID, $tribeID, $ten, $version, $eins, $eins, $no);
        $stmt->execute();
        $stmt->close();
    }

    function isAdmin(): bool
    {
        if ($this->World_Account["level"] == 15) {
            return true;
        } else {
            return false;
        }
    }

    function getWorldVersion()
    {
        return $this->World_Account["worldVersion"];
    }

    function getWorld()
    {
        return $this->World_Account["world"];
    }

    function getPlayerID()
    {
        return $this->World_Account["playerID"];
    }

    function getTribeID()
    {
        return $this->World_Account["tribeID"];
    }

    function isMod(): bool
    {
        if ($this->World_Account["mod"] == 1) {
            return true;
        } else {
            return false;
        }
    }

    function isSF(): bool
    {
        if ($this->World_Account["level"] >= 10) {
            return true;
        } else {
            return false;
        }
    }

    function isOffKoord(): bool
    {
        if ($this->World_Account["off"] == 1) {
            return true;
        } else {
            return false;
        }
    }

    function isDefKoord(): bool
    {
        if ($this->World_Account["def"] == 1) {
            return true;
        } else {
            return false;
        }
    }

    function isActivated(): bool
    {
        if (!$this->exists) {
            return false;
        }
        if ($this->World_Account["level"] > 0) {
            return true;
        } else {
            return false;
        }
    }

    function uvModeActivated(): bool
    {
        if ($this->World_Account["uvActive"] == "no") {
            return false;
        } else {
            return true;
        }
    }

    function maxVersion($world): int
    {
        $maxID = $this->query("SELECT MAX(Version) as MAX FROM `userrollen` WHERE world = '$world'");
        return intval($maxID[0]["MAX"]);
    }
}