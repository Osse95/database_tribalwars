<?php
require_once "DB.php";

class Players extends DB
{
    function __construct($world)
    {
        parent::__construct($world);
    }

    function getAllPlayersDataSortByID(): array
    {
        $return = [];
        $query = $this->query("SELECT spielername,spielerid,dorfanzahl,punkte,rang FROM `spielerdaten`");
        foreach ($query as $Player) {
            $return[$Player["spielerid"]] = array("playerName" => $Player["spielername"],
                "playerID" => $Player["spielerid"],
                "villages" => $Player["dorfanzahl"],
                "points" => $Player["punkte"],
                "rank" => $Player["rang"]);
        }
        return $return;
    }

    function getAllPlayersDataSortByName(): array
    {
        $return = [];
        $query = $this->query("SELECT spielername,spielerid,dorfanzahl,punkte,rang FROM `spielerdaten`");
        foreach ($query as $Player) {
            $return[$Player["spielername"]] = array("playerName" => $Player["spielername"],
                "playerID" => $Player["spielerid"],
                "villages" => $Player["dorfanzahl"],
                "points" => $Player["punkte"],
                "rank" => $Player["rang"]);
        }
        return $return;
    }

    function getLimitPlayersData($limit = 10): array
    {
        $return = [];
        $query = $this->query("SELECT spielername,spielerid,dorfanzahl,punkte,rang FROM `spielerdaten` ORDER BY rang ASC LIMIT $limit");
        foreach ($query as $Player) {
            $return[] = array("playerName" => $Player["spielername"],
                "playerID" => $Player["spielerid"],
                "villages" => $Player["dorfanzahl"],
                "points" => $Player["punkte"],
                "rank" => $Player["rang"]);
        }
        return $return;
    }

    function getPlayerNames(): array
    {
        $return = [];
        $query = $this->query("SELECT spielername FROM `spielerdaten` ORDER BY rang ASC");
        foreach ($query as $Player) {
            $return[] = $Player["spielername"];
        }
        return $return;
    }

    function getBashis($limit): array
    {
        $return["All"] = [];
        $userNames = $this->getAllPlayersDataSortByID();
        $query = $this->query("SELECT * FROM `all` ORDER by date desc,rang asc LIMIT $limit");
        foreach ($query as $user) {
            if (isset($userNames[$user["id"]])) {
                $return["All"][] = array("rank" => $user["rang"],
                    "id" => $user["id"],
                    "name" => $userNames[$user["id"]]["playerName"],
                    "kills" => $user["kills"]);
            }
        }

        $return["Att"] = [];
        $query = $this->query("SELECT * FROM `att` ORDER by date desc,rang asc LIMIT $limit");
        foreach ($query as $user) {
            if (isset($userNames[$user["id"]])) {
                $return["Att"][] = array("rank" => $user["rang"],
                    "id" => $user["id"],
                    "name" => $userNames[$user["id"]]["playerName"],
                    "kills" => $user["kills"]);
            }
        }

        $return["Def"] = [];
        $query = $this->query("SELECT * FROM `deff` ORDER by date desc,rang asc LIMIT $limit");
        foreach ($query as $user) {
            if (isset($userNames[$user["id"]])) {
                $return["Def"][] = array("rank" => $user["rang"],
                    "id" => $user["id"],
                    "name" => $userNames[$user["id"]]["playerName"],
                    "kills" => $user["kills"]);
            }
        }

        $return["Sup"] = [];
        $query = $this->query("SELECT * FROM `sup` ORDER by date desc,rang asc LIMIT $limit");
        foreach ($query as $user) {
            if (isset($userNames[$user["id"]])) {
                $return["Sup"][] = array("rank" => $user["rang"],
                    "id" => $user["id"],
                    "name" => $userNames[$user["id"]]["playerName"],
                    "kills" => $user["kills"]);
            }
        }
        return $return;
    }

    function getDailys($limit): array
    {
        $return = [];
        $query = $this->query("SELECT * FROM `dailyuser` ORDER BY rang ASC LIMIT $limit");
        foreach ($query as $user) {
            $return[] = array("rank" => $user["rang"],
                "allID" => $user["all_userid"],
                "allName" => $user["all_username"],
                "allDiff" => $user["all_diff"],
                "defID" => $user["deff_userid"],
                "defName" => $user["deff_username"],
                "defDiff" => $user["deff_diff"],
                "attID" => $user["att_userid"],
                "attName" => $user["att_username"],
                "attDiff" => $user["att_diff"],
                "supID" => $user["sup_userid"],
                "supName" => $user["sup_username"],
                "supDiff" => $user["sup_diff"]);
        }
        return $return;
    }

    function getInternalConquers($limit): array
    {
        $return = [];
        $date = date("Y.m.d", $date);
        $query = $this->query("SELECT round(Intern_Adelungen/MaxDoerfer*100,2) as Prozent,Intern_Adelungen,MaxDoerfer,userid,username FROM `userstats` WHERE Rang < 100 and Date = '$date' ORDER by Prozent DESC LIMIT $limit");
        foreach ($query as $user) {
            $return[] = array("id" => $user["userid"],
                "name" => $user["username"],
                "percent" => $user["Prozent"],
                "internalConquers" => $user["Intern_Adelungen"],
                "maxVillages" => $user["MaxDoerfer"]);
        }
        return $return;
    }

    function getBarbarianConquers($limit): array
    {
        $return = [];
        $date = date("Y.m.d", $date);
        $query = $this->query("SELECT round(Baba_Adelungen/MaxDoerfer*100,2) as Prozent,Baba_Adelungen,MaxDoerfer,userid,username FROM `userstats` WHERE Rang < 100 and Date = '$date' ORDER by Prozent DESC LIMIT $limit");
        foreach ($query as $user) {
            $return[] = array("id" => $user["userid"],
                "name" => $user["username"],
                "percent" => $user["Prozent"],
                "barbarianConquers" => $user["Baba_Adelungen"],
                "maxVillages" => $user["MaxDoerfer"]);
        }
        return $return;
    }
}