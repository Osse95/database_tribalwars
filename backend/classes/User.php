<?php

require_once "DB.php";

class User extends DB
{
    private $name;
    public $exists = false;
    private $DB_Account;

    function __construct($user = "")
    {
        parent::__construct();
        $this->name = $user;
        $stmt = $this->conn->prepare("SELECT * FROM `Allgemein`.`users` WHERE name = ?");
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $stmt->bind_result($name, $password, $design, $lastLogin, $activated, $register, $map, $question, $answer);
        while ($stmt->fetch()) {
            $this->DB_Account = array("Name" => $name,
                "password" => $password,
                "design" => $design,
                "lastLogin" => $lastLogin,
                "activated" => $activated,
                "register" => $register,
                "map" => $map,
                "question" => $question,
                "answer" => $answer);
        }
        if (is_array($this->DB_Account)) {
            $this->exists = true;
        }
    }

    function registerUser($name, $password): bool
    {
        if (!$this->exists) {
            $stmt = $this->conn->prepare("INSERT INTO `Allgemein`.`users` (name,passwort,design,lastlogin,activated,register,weltkarte) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $map = "normal";
            $heatmap = "heatmap";
            $time = time();
            $i = 1;
            $stmt->bind_param("sssiiis", $name, $hash, $map, $time, $i, $time, $heatmap);
            $stmt->execute();
            $stmt->close();
            return true;
        } else {
            return false;
        }
    }

    function login($password): bool
    {
        if ($this->exists) {
            if (password_verify($password, $this->DB_Account["password"])) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function isActivated(): bool
    {
        if($this->DB_Account["activated"] == 1){
            return true;
        }else{
            return false;
        }
    }
}