<?php

require_once "DB.php";

class Tribes extends DB
{
    function __construct($world)
    {
        parent::__construct($world);
    }

    function getAllTribesDataSortByID(): array
    {
        $return = [];
        $query = $this->query("SELECT * FROM `tribes`");
        foreach ($query as $Tribe) {
            $return[$Tribe["id"]] = array("tribeName" => $Tribe["name"],
                "points" => $Tribe["allepunkte"],
                "tribeTag" => $Tribe["tag"],
                "tribeID" => $Tribe["id"],
                "tribeMembers" => $Tribe["members"],
                "villages" => $Tribe["villages"],
                "rank" => $Tribe["rang"]);
        }
        return $return;
    }

    function getTribeNames(): array
    {
        $return = [];
        $query = $this->query("SELECT tag FROM `tribes` order by rang asc");
        foreach ($query as $tag) {
            $return[] = $tag["tag"];
        }
        return $return;
    }

    function getAllTribeNames(): array
    {
        $return = [];
        $query = $this->query("SELECT Tribetag FROM `tribestats` ORDER by date desc,Rang asc;");
        foreach ($query as $tag) {
            $return[] = $tag["Tribetag"];
        }
        return $return;
    }

    function getAllTribeNamesSortByID(): array
    {
        $return = [];
        $query = $this->query("SELECT Tribetag,Tribeid FROM `tribestats` ORDER by date desc,Rang asc;");
        foreach ($query as $tag) {
            $return[$tag["Tribeid"]] = $tag["Tribetag"];
        }
        return $return;
    }

    function getLimitTribeData($limit = 10): array
    {
        $return = [];
        $query = $this->query("SELECT id,name,tag,members,villages,allepunkte,rang FROM `tribes` ORDER BY rang ASC LIMIT $limit");
        foreach ($query as $Tribe) {
            $return[] = array("tribeName" => $Tribe["name"],
                "points" => $Tribe["allepunkte"],
                "tribeTag" => $Tribe["tag"],
                "tribeID" => $Tribe["id"],
                "tribeMembers" => $Tribe["members"],
                "villages" => $Tribe["villages"],
                "rank" => $Tribe["rang"]);
        }
        return $return;
    }

    function getDailys($limit): array
    {
        $return = [];
        $query = $this->query("SELECT * FROM `dailytribe` ORDER BY rang ASC LIMIT $limit");
        foreach ($query as $Tribe) {
            $return[] = array("rank" => $Tribe["rang"],
                "allID" => $Tribe["all_tribeid"],
                "allTag" => $Tribe["all_tribetag"],
                "allDiff" => $Tribe["all_diff"],
                "defID" => $Tribe["deff_tribeid"],
                "defTag" => $Tribe["deff_tribetag"],
                "defDiff" => $Tribe["deff_diff"],
                "attID" => $Tribe["att_tribeid"],
                "attTag" => $Tribe["att_tribetag"],
                "attDiff" => $Tribe["att_diff"]);
        }
        return $return;
    }

    function getBashis($limit): array
    {
        $return["All"] = [];
        $tribeNames = $this->getAllTribesDataSortByID();
        $query = $this->query("SELECT * FROM `all_tribe` ORDER by date desc,rang asc LIMIT $limit");
        foreach ($query as $tribe) {
            if (isset($tribeNames[$tribe["id"]])) {
                $return["All"][] = array("rank" => $tribe["rang"],
                    "id" => $tribe["id"],
                    "name" => $tribeNames[$tribe["id"]]["tribeTag"],
                    "kills" => $tribe["kills"]);
            }
        }

        $return["Att"] = [];
        $query = $this->query("SELECT * FROM `att_tribe` ORDER by date desc,rang asc LIMIT $limit");
        foreach ($query as $tribe) {
            if (isset($tribeNames[$tribe["id"]])) {
                $return["Att"][] = array("rank" => $tribe["rang"],
                    "id" => $tribe["id"],
                    "name" => $tribeNames[$tribe["id"]]["tribeTag"],
                    "kills" => $tribe["kills"]);
            }
        }

        $return["Def"] = [];
        $query = $this->query("SELECT * FROM `deff_tribe` ORDER by date desc,rang asc LIMIT $limit");
        foreach ($query as $tribe) {
            if (isset($tribeNames[$tribe["id"]])) {
                $return["Def"][] = array("rank" => $tribe["rang"],
                    "id" => $tribe["id"],
                    "name" => $tribeNames[$tribe["id"]]["tribeTag"],
                    "kills" => $tribe["kills"]);
            }
        }
        return $return;
    }
}