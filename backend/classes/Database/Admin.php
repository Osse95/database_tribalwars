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
                $activated = "<button id='{$user["name"]}' class='ms-3 btn btn-primary deactivatedUser'> Benutzer deaktivieren </button>";
            } else {
                $activated = "<button id='{$user["name"]}' class='ms-3 btn btn-primary activatedUser'> Benutzer aktivieren </button>";
            }
            $deleteUser = "<button id='{$user["name"]}' class='btn btn-primary deleteUser'> Benutzer löschen </button>";
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

    function deactivatedUser($userName)
    {
        $stmt = $this->conn->prepare("UPDATE `users` SET `activated` = '0' WHERE `users`.`name` = ?;");
        $stmt->execute([$userName]);
    }

    function activatedUser($userName)
    {
        $stmt = $this->conn->prepare("UPDATE `users` SET `activated` = '1' WHERE `users`.`name` = ?;");
        $stmt->execute([$userName]);
    }

    function deleteUser($userName){
        $stmt = $this->conn->prepare("DELETE FROM `users` WHERE `users`.`name` = ?;");
        $stmt->execute([$userName]);
    }

    function changeUserPassword($userName,$password){
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("UPDATE `users` SET `passwort` = ? WHERE `users`.`name` = ?;");
        $stmt->execute([$hash,$userName]);
    }

    function changeVersion($userName,$world,$version){
        $stmt = $this->conn->prepare("UPDATE `userrollen` SET `Version` = ? WHERE `userrollen`.`name` = ? AND `userrollen`.`world` = ?;");
        $stmt->execute([$version,$userName,$world]);
    }

    function getImprovements(): array
    {
        $return = [];
        $query = $this->query("SELECT * FROM `vorschlag`");
        foreach ($query as $improvement){
            $return[] = [$improvement["user"],$improvement["vorschlag"],$improvement["answer"]];
        }
        return $return;
    }
}