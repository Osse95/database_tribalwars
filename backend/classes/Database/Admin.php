<?php

require_once dirname(__DIR__, 3) . "/backend/classes/DB.php";

class Admin extends DB
{
    private string $worldVersion;
    private string $worldName;

    public function __construct($world = "", $Version = "")
    {
        parent::__construct();
        $this->worldVersion = $Version;
        $this->worldName = $world;
    }

    function getMaxVersion(): int
    {
        $query = $this->query("SELECT MAX(version) as maxVersion FROM `userrollen` where world = '{$this->worldName}'");
        return $query[0]["maxVersion"];
    }

    function getAllVersions(): array
    {
        $Return = [];
        $query = $this->query("SELECT DISTINCT version FROM `userrollen` where world = '{$this->worldName}' order by version ASC");
        foreach ($query as $user) {
            $Return[] = $user["version"];
        }
        return $Return;
    }

    function getAllUsersAjax(): array
    {
        $Return = [];
        $query = $this->query("SELECT name,lastlogin,activated,register FROM `users`");
        foreach ($query as $user) {
            $lastLogin = date("d.m.Y H:i:s", $user["lastlogin"]);
            $register = date("d.m.Y H:i:s", $user["register"]);
            if ($user["activated"] == 1) {
                $activated = "<button class='ms-3 btn btn-primary {$user["name"]} deactivatedUser'> Benutzer deaktivieren </button>";
            } else {
                $activated = "<button class='ms-3 btn btn-primary {$user["name"]} activatedUser'> Benutzer aktivieren </button>";
            }
            $deleteUser = "<button class='btn btn-primary {$user["name"]} deleteUser'> Benutzer löschen </button>";
            $Return[] = [$user["name"], $register, $lastLogin, $activated, $deleteUser];
        }
        return $Return;
    }

    function getAllUserNamesAjax(): array
    {
        $Return = [];
        $query = $this->query("SELECT name FROM `users`");
        foreach ($query as $user) {
            $Return[] = $user["name"];
        }
        return $Return;
    }
}